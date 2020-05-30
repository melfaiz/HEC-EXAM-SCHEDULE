<?php

include('db.php');
include('includes/functions.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {


        $cours = $_GET['code_cours'];
        $date = $_GET['date'];
        delete_exam($bdd,$cours,$date);

        header('Location:index.php');
  

}


?>
