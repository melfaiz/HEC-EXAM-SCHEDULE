<?php 


$dbhost = 'localhost';
$dbname = 'hec_exam_schedule';

$dsn = "mysql:host={$dbhost};dbname={$dbname}";
$username = 'root';
$password = '';

$bdd = new PDO($dsn, $username, $password );
$bdd->query("SET NAMES utf8");




?>