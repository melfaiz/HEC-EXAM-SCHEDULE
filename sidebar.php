<?php 


if(isset($_POST['annee']) && !empty($_POST['annee']) && isset($_POST['bloc']) && !empty($_POST['bloc']) && isset($_POST['session']) && !empty($_POST['session']) && isset($_POST['programme']) && !empty($_POST['programme'])){

   $annee = $_POST['annee'];
   $bloc = $_POST['bloc'];
   $quadri = $_POST['session'];
   $programme = $_POST['programme'];

   $_SESSION['annee'] = $annee;
   $_SESSION['bloc'] = $bloc ;
   $_SESSION['session'] = $quadri;
   $_SESSION['programme'] = $programme ;


}

if(isset($_SESSION['annee']) && isset($_SESSION['bloc']) && isset($_SESSION['session']) && isset($_SESSION['programme']) ){

  $annee = $_SESSION['annee'];
  $bloc = $_SESSION['bloc'];
  $quadri = $_SESSION['session'];
  $programme = $_SESSION['programme'];
  
  
  }else{

    $_SESSION['annee'] = "20192020";
    $_SESSION['session'] = "Janvier";
    $_SESSION['bloc'] = 1;
    $_SESSION['programme'] = "Bachelier en sciences économiques et de gestion";

    $annee = $_SESSION['annee'];
    $bloc = $_SESSION['bloc'];
    $quadri = $_SESSION['session'];
    $programme = $_SESSION['programme'];
      
  }




if (isset($_POST['version'])) {
  $_SESSION['version'] = $_POST['version'];
  $version = $_SESSION['version'];
}



?>


<form action="" method="POST">

<div class="form-group">

       <select name='annee' class="form-control">
           <option value='20182019' <?php if ($annee == "20182019")echo "selected" ?>>2018-2019</option>
           <option value='20192020' <?php if ($annee == "20192020")echo "selected" ?>>2019-2020</option>
       </select>
      

</div>

<div class="form-group">

        <select name='programme' class="form-control">
            <option value='Bachelier en sciences économiques et de gestion' <?php if ($programme == "Bachelier en sciences économiques et de gestion") echo "selected" ?>>Bac. sc. éco. et gest.</option>
            
            <option value='Bachelier en ingénieur de gestion' <?php if ($programme == "Bachelier en ingénieur de gestion") echo "selected" ?>>Bac. ingé. gestion</option>
            
            <option value='Master en ingénieur de gestion, à finalité' <?php if ($programme == "Master en ingénieur de gestion, à finalité") echo "selected" ?>>Master ingé. gest., à fin.</option>
            
            <option value='Master en sciences de gestion, à finalité' <?php if ($programme == "Master en sciences de gestion, à finalité") echo "selected" ?>>Master sc. gest., à fin.</option>
            
             <option value='Master en sciences économiques, orientation générale, à finalité' <?php if ($programme == "Master en sciences économiques, orientation générale, à finalité") echo "selected" ?>>Master sc. éco., or. gén., à fin.</option>
            
            <option value='Master en sciences de gestion, à finalité spécialisée en droit' <?php if ($programme == "Master en sciences de gestion, à finalité spécialisée en droit") echo "selected" ?>>Master sc. gest., fin. spéc. droit</option>
            
            <option value='Master en sciences de gestion' <?php if ($programme == "Master en sciences de gestion") echo "selected" ?>>Master sc. gest.</option>
            
            <option value='Master en sciences économiques, orientation générale' <?php if ($programme == "Master en sciences économiques, orientation générale") echo "selected" ?>>Master. sc. éco., or. gén.</option>
            
            <option value='Master en sciences de gestion, à finalité spécialisée en droit et gestion' <?php if ($programme == "Master en sciences de gestion, à finalité spécialisée en droit et gestion") echo "selected" ?>>Master sc. gest., fin. spéc. droit et gest.</option>
            
            <option value='Formation doctorale en sciences économiques et de gestion (sciences de gestion)' <?php if ($programme == "Formation doctorale en sciences économiques et de gestion (sciences de gestion)") echo "selected" ?>>Form. doct. sc. éco. et gest. (sc. gestion)</option>
        </select>
</div>


<div class="form-group">
        <select name='bloc' class="form-control">
            <option value='0' <?php if ($bloc == "0")echo "selected" ?>>Bloc 0</option>
            <option value='1' <?php if ($bloc == "1")echo "selected" ?>>Bloc 1</option>
            <option value='2' <?php if ($bloc == "2")echo "selected" ?>>Bloc 2</option>
            <option value='3' <?php if ($bloc == "3")echo "selected" ?>>Bloc 3</option>
        </select>
</div>

<div class="form-group">
     
        <select name='session' class="form-control">
            <option value='Janvier' <?php if ($quadri == "Janvier")echo "selected" ?>>Janvier</option>
            <option value='Juin' <?php if ($quadri == "Juin")echo "selected" ?>>Juin</option>
            <option value='Septembre' <?php if ($quadri == "Septembre")echo "selected" ?>>Septembre</option>
        </select>
</div>

<div class="form-group">

       <select name='version' class="form-control">
           <option value='schedule1' <?php if ($version == "schedule1")echo "selected" ?>>Version 1</option>
           <option value='schedule2' <?php if ($version == "schedule2")echo "selected" ?>>Version 2</option>
           <option value='schedule3' <?php if ($version == "schedule3")echo "selected" ?>>Version 3</option>
       </select>
      

</div>

   <button type="submit" class="btn btn-primary btn-lg btn-block">Rechercher</button>
   <a href="logout.php" class="btn btn-danger btn-lg btn-block ">Se deconnecter</a>

</form>





<?php 

   
       echo "<div class='liste_programmes'>";
   
      liste_programme_aa($bdd,$annee,$bloc,$quadri,$programme);
       
       echo "</div>";
   
?>



