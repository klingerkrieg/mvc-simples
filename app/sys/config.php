<?php
#primeiro controller a ser chamado por padrao
$index = "Principal";

$host = "app/database/database.sqlite";
#$host = "localhost";
#$dbname = "database";
#$user = "root";
#$pass = "";

const EMAIL_ENABLED = true;
const EMAIL_FROM = "suporte@seudominio.com";
const EMAIL_NAME = "Suporte";

$pdo = new \PDO("sqlite:" . $host);