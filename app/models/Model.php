<?php
namespace models;

class Model {

    protected $pdo;

    protected $table = null;
    protected $fields = [];
    

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function showError($sql,$data=[]){
        global $DEBUG_MODE;

        if ($DEBUG_MODE) {
            foreach($data as $key=>$value){
                $sql = str_replace($key, '\'' . str_replace('\'', '\\\'', $value) . '\'', $sql);
            }

            $msg = $this->pdo->errorInfo();
            print "<div class='codeError'>$sql<br/><br/>{$msg[2]}</div>";
        }
    }

    public function findById($id){
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $data = [':id' => $id];
        $stmt->execute($data);
        if ($stmt == false){
            $this->showError($sql,$data);
        }
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function paginate($page=null, $limit=10){

        if ($page == null){
            if (isset($_GET['page'])){
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
        }

        #Caso implemente algum filtro, ambos os SQL abaixo tem que ter o filtro implementado
        #porém no primeiro só é pra trazer o count(*)

        #a primeira consulta é somente para contar a quantidade de registros
        $sql = "SELECT count(*) as count FROM {$this->table}";
        $stmt = $this->pdo->prepare($sql);
        if ($stmt == false){
            $this->showError($sql);
        }
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        $count = $row['count'];
        $pageCount = ceil($count/$limit);

        #dado a pagina iniciando da pagina 1, converte para a instrução sql
        $from = ($page-1)*$limit;


        $sql = "SELECT * FROM {$this->table} limit :from,:limit";
        $data = [':from'=>$from, ':limit' => $limit];
        
        $stmt = $this->pdo->prepare($sql);
        if ($stmt == false){
            $this->showError($sql);
        }
        $stmt->execute($data);
        
        $list = [];

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            array_push($list,$row);
        }

        return ["data"=>$list, "pages"=>$pageCount, "count"=>$count, "actualPage"=>$page];
    }

    public function all(){
        $sql = "SELECT * FROM {$this->table}";
        
        $stmt = $this->pdo->prepare($sql);
        if ($stmt == false){
            $this->showError($sql);
        }
        $stmt->execute();
        
        $list = [];

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            array_push($list,$row);
        }

        return $list;
    }

    public function save($data){
        #filtra, para que só tenha nos values os campos que realmente existem na tabela
        $values = array_intersect_key($data, array_flip($this->fields));
        $fields = array_keys($values);

        $sql = "INSERT INTO {$this->table} (".implode(",",$fields).") 
                    VALUES 
                (:".implode(",:",$fields).")";
        
        #caso voce queira ver como está o SQL descomente a linha
        #dd($sql);

        $stmt = $this->pdo->prepare($sql);

        if ($stmt == false){
            $this->showError($sql, $values);
        }

        if ($stmt->execute($values)) {
            return $this->pdo->lastInsertId();
        } else {
            return false;
        }
    }

    public function update($id, $data){
        #filtra, para que só tenha nos values os campos que realmente existem na tabela
        $values = array_intersect_key($data, array_flip($this->fields));
        $fields = array_keys($values);
        #seta a ID
        $values["id"] = $id;

        #constroi o SQL do UPDATE
        $sql ="UPDATE {$this->table} SET ";
        foreach($fields as $field){
            $sql .= "$field = :$field,";
        }
        $sql = trim($sql,",")." WHERE id = :id";

        #caso voce queira ver como está o SQL descomente a linha
        #dd($sql);
        
        $stmt = $this->pdo->prepare($sql);

        if ($stmt == false){
            $this->showError($sql, $values);
        }
        
        if ($stmt->execute($values)) {
            return $id;
        } else {
            return false;
        }
    }

    public function delete($id){
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $values = ["id"=>$id];
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);

        if ($stmt == false){
            $this->showError($sql, $values);
        }

        return true;
    }


}