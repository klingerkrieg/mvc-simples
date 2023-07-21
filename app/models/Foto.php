<?php

namespace models;

class Foto extends Model {

    protected $table = "fotos";
    #nao esqueça da ID
    protected $fields = ["id", "nome", "foto"];
    
}

