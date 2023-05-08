<?php

namespace models;

class Veiculo extends Model {

    protected $table = "veiculos";
    #nao esqueça da ID
    protected $fields = ["id", "placa","modelo_id","cor","ano"];



    public function getMotoristas($idVeiculo){
        $sql = "SELECT * FROM usuarios 
            INNER JOIN motoristas ON 
                usuarios.id = motoristas.usuario_id 
            WHERE motoristas.veiculo_id = :idVeiculo ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idVeiculo' => $idVeiculo]);

        $list = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            array_push($list,$row);
        }

        return $list;
    }

    
    public function findById($id){
        $sql = "SELECT veiculos.*, modelos.modelo as modelo FROM {$this->table} "
                ." LEFT JOIN modelos ON modelos.id = veiculos.modelo_id "
                ." WHERE veiculos.id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function all(){
        $sql = "SELECT veiculos.*, modelos.modelo as modelo FROM {$this->table} "
                ." LEFT JOIN modelos ON modelos.id = veiculos.modelo_id ";
        $stmt = $this->pdo->prepare($sql);
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
        
        if ($stmt->execute($values)) {
            return $id;
        } else {
            return false;
        }
    }

    public function delete($id){

        $stmt = $this->pdo->prepare("DELETE FROM motoristas WHERE veiculo_id = :id");
        $stmt->execute(["id"=>$id]);

        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(["id"=>$id]);
    }
    
}

