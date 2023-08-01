<?php

namespace models;

class Usuario extends Model {

    use UserTrait;

    protected $table = "usuarios";
    #nao esqueça da ID
    protected $fields = ["id","nome","email","senha","dataNascimento","tipo","ativado"];

    /**
     * Essa função será chamada quando as funções paginate ou all forem chamadas
     */
    public function addPaginateFilter($request){
        #constroi o filtro
        if (_v($request,"search") != ""){
            #a variavel filterSQL deve conter o SQL que irá fazer o filtro
            $this->filterSQL = " WHERE ";

            #a variavel filterValues deve conter todos os valores usados no filtro
            $s = _v($request,"search");
            $this->filterValues = ["search"=>"%$s%"];
            $this->filterSQL .= "nome like :search or email like :search";
        }
        
    }
    
}

