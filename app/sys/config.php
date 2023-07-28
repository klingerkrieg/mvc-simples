<?php
#primeiro controller a ser chamado por padrão
const INDEX = "Principal";

$host = "app/database/database.sqlite";
#$host = "localhost";
#$dbname = "database";
#$user = "root";
#$pass = "";

#conexao com o banco de dados

#SQLITE
$pdo = new \PDO("sqlite:" . $host);
#MYSQL
#$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);


#Configuracoes para E-mail
const EMAIL_ENABLED = true;
const EMAIL_FROM = "suporte@seudominio.com";
const EMAIL_NAME = "Suporte";