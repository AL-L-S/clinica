<?php
//define('DB_SERVER', 'localhost');
//define('DB_USERNAME', 'root');
//define('DB_PASSWORD', '123456');
//define('DB_DATABASE', 'clinica');


$bdcon = pg_connect("dbname=clinica");
//conecta a um banco de dados chamado "cliente"

$con_string = "host=localhost port=5432 dbname=clinica user=postgres password=123456";
if(!$dbcon = pg_connect($con_string)) die ("Erro ao conectar ao banco<br>".pg_last_error($dbcon));
//$db = pg_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD,DB_DATABASE) or die ("Não foi possivel conectar ao servidor PostGreSQL");
$recording_path = "recordings/"; //Images upload folder 
?>
