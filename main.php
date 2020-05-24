
<?php

// echo "<ul>";

// foreach ($_SESSION as $key => $value) {
//     echo "<li>";
//     echo $key . " => " .$value;
//     echo "</li>";
// }

// echo "</ul>";



?>
<?php



//  session_destroy();

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

  if ( isset($_POST['action']) && $_POST['action'] == 'append') {

      echo " <h1> holiaa  </h1> ";
    
  }
    

}

if ( isset( $_SESSION['month']) && isset( $_SESSION['year'])) {


    $year = $_SESSION['year'];
    $month = $_SESSION['month'];

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


<div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="insertModaltitle"></h5>
      </div>

      <div class="modal-body">
      

      <form action="append.php" method='GET'>

        <input type="hidden" class="form-control" id="insertModalDate" name="date" value="">
        <input type="hidden" class="form-control" id="insertModalCours" name="cours" value="">
        <div class="form-group">
            <label for="exampleInputEmail1">Heure</label>
            <input type="time" class="form-control" id="insertModalHeure" value="08:00" name="heure">
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
    

<?php

echo draw_calendar($bdd,$month,$year);

?>




<script>
function allowDrop(ev) {
  ev.preventDefault();
}

function drag(ev) {
  ev.dataTransfer.setData("text", ev.target.id);
  
}

function drop(ev,date) {

  ev.preventDefault();
  var data = ev.dataTransfer.getData("text");

  var x = document.createElement("A");
  x.appendChild(document.getElementById(data))


  ev.target.children[1].appendChild(x);
  
  $('#insertModaltitle').text(data);
  $('#insertModalDate').val(date); 
  $('#insertModalCours').val(data); 
  $('#insertModal').modal('show'); 

  // window.open("append.php?class="+data+"&time="+date,"_self");

}

// function sendData(data) {

//   // sendData({ class : data , time : date ,action:'addcourse' });

//   var XHR = new XMLHttpRequest();
//   var FD  = new FormData();

//   // Mettez les données dans l'objet FormData
//   for(name in data) {
//     FD.append(name, data[name]);
//   }


//   // Definissez ce qui se passe en cas d'erreur
//   XHR.addEventListener('error', function(event) {
//     alert('Oups! Quelque chose s\'est mal passé.');
//   });

//   // Configurez la requête
//   XHR.open('POST', 'append.php');

//   // Expédiez l'objet FormData ; les en-têtes HTTP sont automatiquement définies
//   XHR.send(FD);
//   // location.reload();
// }


</script>









