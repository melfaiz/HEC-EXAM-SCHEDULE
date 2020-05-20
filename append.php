<?php

include('db.php');
include('includes/functions.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        
        $cours = $_GET['class'];
        $date = $_GET['time'];

        append_exam($bdd,$cours,$date);

        header('Location:index.php');

}


?>
