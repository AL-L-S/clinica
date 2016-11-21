<?php
//define('DB_SERVER', 'localhost');
//define('DB_USERNAME', 'root');
//define('DB_PASSWORD', '123456');
//define('DB_DATABASE', 'clinica');


$bdcon = pg_connect("host=localhost port=5432 dbname=clinica user=postgres password=123456");
//conecta a um banco de dados chamado "cliente"

$recording_path = "recordings/"; //Images upload folder 
?>
