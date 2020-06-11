<?php


include('includes/functions.php');





if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        
        $cours = $_GET['cours'];
        $date = $_GET['date'];
        $heure = $_GET['heure'];
        $comment = $_GET['comment'];
        $duree = $_GET['duree'];
        $annee = $_SESSION['annee'];
        $programme = $_SESSION['programme'];

        $query="SELECT * FROM cours_aa WHERE code_cours = '$cours' AND aa = '$annee' ";
        $req=$bdd->query($query);
        if($req->rowCount()){
                while ($tuple=$req->fetch()){
                        $id_cours=$tuple['id_cours_aa'];
                        $intitule=$tuple['intitule'];
                        $flag_partim=$tuple['flag_partimes'];
                        $meanwhile=$tuple['meanwhile_id_cours_aa'];
                        $query_programme="SELECT * FROM programme_aa, attrib_cours_aa, rh, cours_aa_pgm WHERE programme_aa.programme_long='$programme' AND programme_aa.aa='$annee' AND attrib_cours_aa.id_cours_aa='$id_cours' AND rh.id_rh=attrib_cours_aa.id_rh";
                        $req_programme=$bdd->query($query_programme);
                        if($req_programme->rowCount()){
                                while ($tuple_programme=$req_programme->fetch()){
                                        $id_programme_aa=$tuple_programme['id_programme_aa'];
                                        $bloc_cours=$tuple_programme['bloc'];
                                        $id_rh=$tuple_programme['id_rh'];
                                        $nom=$tuple_programme['nom'];
                                        $prenom=$tuple_programme['prenom'];
                                }   
                        }
                }
        }

        // LES TESTS 

        $query_schedule="SELECT * FROM schedule WHERE date = '$date'";
        //On a réfléchi pour le truc avec la durée que tu avais dit mais on a pas trouvé comment le mettre dans la requête
        $req_schedule=$bdd->query($query_schedule);
        if($req_schedule->rowCount()){
                while ($tuple_schedule=$req_schedule->fetch()){
                        if($id_rh==$tuple_schedule['id_rh']){
                                $query_bloc="SELECT * FROM schedule WHERE date = '$date' AND heure_debut = '$heure'";
                                $req_bloc=$bdd->query($query_bloc);
                                if($req_bloc->rowCount()){
                                        while ($tuple_bloc=$req_bloc->fetch()){
                                                if($id_rh==$tuple_bloc['id_rh']){

                                                        $_SESSION['messages'] = "Ce professeur est déjà à l'horaire.";
                                                        header('Location:index.php');
                                                }
                                        }
                                }
                        }
                        elseif($id_programme_aa==$tuple_schedule['id_programme_aa'] && $bloc_cours==$tuple_schedule['bloc']){
                                $_SESSION['messages'] = "Les étudiants de ce bloc et ce programme sont déjà à l'horaire.";
                                header('Location:index.php');
                        }
                        else{
                                append_exam($bdd,$cours,$date,$heure,$duree,$comment,$id_cours,$intitule,$flag_partim,$meanwhile,$id_programme_aa,$bloc_cours,$id_rh,$nom,$prenom);
                                header('Location:index.php');
                        }
                }  

        }else{ // SI TOUT EST OK
                append_exam($bdd,$cours,$date,$heure,$duree,$comment,$id_cours,$intitule,$flag_partim,$meanwhile,$id_programme_aa,$bloc_cours,$id_rh,$nom,$prenom);
                header('Location:index.php');
        }

        //on veut juste mettre un commentaire mais quand même permettre à la personne faisant l'horaire de quand même pouvoir encoder


        

        

}

?>
