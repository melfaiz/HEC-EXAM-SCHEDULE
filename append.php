<?php

include('db.php');
include('includes/functions.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        
        $cours = $_GET['cours'];
        $date = $_GET['date'];
        $heure = $_GET['heure'];
        $comment = $_GET['comment'];
        append_exam($bdd,$cours,$date,$heure,$comment);

        header('Location:index.php');

}


?>
