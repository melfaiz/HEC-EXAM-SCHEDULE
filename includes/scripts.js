
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

  $('#insertModal').on('hidden.bs.modal', function () {
    location.reload();
  })
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

