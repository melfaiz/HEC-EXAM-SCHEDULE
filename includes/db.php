<?php 

$servername = "localhost";
$username = "root";
$password = "";
$database = "hec_exam_schedule";

try {
    $bdd = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd->exec('set names utf8');

  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }

?>