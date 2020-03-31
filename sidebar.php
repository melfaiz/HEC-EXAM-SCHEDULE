<h2> Recherche: </h2>
<form action="" method="POST">
   <div class="form-group">
      <h6>Année scolaire</h6>
      <div class="form-check">
         <input class="form-check-input" type="radio" name="annee" value="20182019">
         <label class="form-check-label" for="exampleRadios1">
         2018-2019
         </label>
      </div>
      <div class="form-check">
         <input class="form-check-input" type="radio" name="annee" value="20192020" checked>
         <label class="form-check-label" for="exampleRadios2">
         2019-2020
         </label>
      </div>
   </div>
   <div class="form-group">
      <h6>Niveau</h6>
      <div class="form-check">
         <input class="form-check-input" type="radio" name="niveau"  value="doctorate" checked>
         <label class="form-check-label" for="exampleRadios1">
         Doctorat
         </label>
      </div>
      <div class="form-check">
         <input class="form-check-input" type="radio" name="niveau" value="master">
         <label class="form-check-label" for="exampleRadios2">
         Master
         </label>
      </div>
      <div class="form-check">
         <input class="form-check-input" type="radio" name="niveau" value="bac">
         <label class="form-check-label" for="exampleRadios2">
         Bachelor
         </label>
      </div>
   </div>
   <button type="submit" class="btn btn-secondary btn-sm">Rechercher</button>
</form>
<?php 
   if(isset($_POST['niveau']) && !empty($_POST['niveau'])){
   
       echo "<div class='liste_programmes'>";
   
       echo "<h6>Programmes</h6>";
   
       $niveau = $_POST['niveau'];
       $annee = $_POST['annee'];
   
       liste_programme_aa($bdd,$niveau,$annee);
   
       
       echo "</div>";
   
   }
   
?>