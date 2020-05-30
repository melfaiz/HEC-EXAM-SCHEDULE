<?php

include('db.php');
include('includes/functions.php');



if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        
        $cours = $_GET['cours'];
        $date = $_GET['date'];
        $heure = $_GET['heure'];
        $comment = $_GET['comment'];
        $duree = $_GET['duree'];
        append_exam($bdd,$cours,$date,$heure,$duree,$comment);

        header('Location:index.php');

}


?>
