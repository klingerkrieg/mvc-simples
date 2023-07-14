<?php

namespace models;

class Usuario extends Model {

    use UserTrait;

    protected $table = "usuarios";
    #nao esqueça da ID
    protected $fields = ["id","nome","email","senha","dataNascimento","tipo","ativado"];
    
}

