<?php


   $year = "2020";
   $month = "05";
   
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
     if ( isset($_POST['action']) && $_POST['action'] == 'date') {
       if (isset( $_POST['date'])) {
   
   
         list($year,$month) = explode('-', $_POST['date']);
   
         $_SESSION['year'] = strval($year);
         $_SESSION['month'] = strval($month);
   
   
       }
   
     }     
   
   }
   
   if ( isset( $_SESSION['month']) && isset( $_SESSION['year'])) {
   
   
       $year = $_SESSION['year'];
       $month = $_SESSION['month'];
   
   }


   if (isset($_SESSION['messages'])) {

      echo '<div class="alert alert-warning">'.$_SESSION['messages'].'</div>';
      unset($_SESSION['messages']);
   }

   ?>



<h3>Choisir le mois:</h3>
<form method="POST" action="">
   <div class="input-group mb-3">
      <input type="month" name="date" min="2018-01" value="<?php echo $year."-".$month; ?>" class="form-control"  aria-describedby="button-addon2">
      <div class="input-group-append">
         <button class="btn btn-outline-secondary" type="submit" id="button-addon2" name="action" value="date">Choisir</button>
      </div>
   </div>
</form>

<!-- popup lors de l'insertion d'un cours  -->

<div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="insertModaltitle"></h5>
         </div>
         <div class="modal-body">

         <div id="insertModalAlert"></div>

            <form action="append.php" method='GET'>
               <input type="hidden" class="form-control" id="insertModalDate" name="date" value="">
               <input type="hidden" class="form-control" id="insertModalCours" name="cours" value="">
               <div class="form-group">
                  <label for="exampleInputEmail1">Heure</label>
                  <input type="time" class="form-control" id="insertModalHeure" value="08:00" name="heure" required>
               </div>
               <div class="form-group">
                  <label for="exampleInputEmail1">Durée</label>
                  <input type="time" class="form-control without_ampm" id="insertModalDuree" value="02:00" name="duree" min='01:00' max= '04:00' required>
               </div>
               <div class="form-group">
                  <label for="exampleInputPassword1">Rentrer votre commentaire</label>
                  <textarea class="form-control" name="comment" id="insertModalComment" rows="3"></textarea>
               </div>

         </div>
         <div class="modal-footer">
         <button type="submit" class="btn btn-primary">Save</button>
         </div>
         </form>
      </div>
   </div>
</div>




<?php echo draw_calendar($bdd,$month,$year); ?>