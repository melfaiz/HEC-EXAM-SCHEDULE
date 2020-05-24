<?php 


$dbhost = 'localhost';
$dbname = 'hec_exam_schedule';
$charset = 'utf8' ;

$dsn = "mysql:host={$dbhost};dbname={$dbname};charset={$charset}";
$username = 'root';
$password = '';

$bdd = new PDO($dsn, $username, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );



?>