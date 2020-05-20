<?php

include('db.php');
include('includes/functions.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {


        $cours = $_GET['code_cours'];
        delete_exam($bdd,$cours);

        header('Location:index.php');
  

}


?>
