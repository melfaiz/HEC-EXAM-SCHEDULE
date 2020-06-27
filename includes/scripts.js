function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("id", ev.target.id);
    ev.dataTransfer.setData("partim", ev.target.dataset.partim);
    ev.dataTransfer.setData("liaison", ev.target.dataset.liaison);


}

// change data-partim to true in partim courses
function trPartim(code) {
    var tr = document.getElementById(code);
    tr.dataset.partim = true

}

// change data-partim to true in Liaison courses
function trLiaison(code) {
    var tr = document.getElementById(code);
    tr.dataset.liaison = true

}


// function when dropping course on calender
function drop(ev, date) {

    ev.preventDefault();
    var data = ev.dataTransfer.getData("id");


    var partim = ev.dataTransfer.getData("partim");
    var liaison = ev.dataTransfer.getData("liaison");



    var tr = document.getElementById(data);

    var com = document.createElement('td');
    var del = document.createElement('td');

    del.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 16" width="12" height="16"><path fill-rule="evenodd" d="M11 2H9c0-.55-.45-1-1-1H5c-.55 0-1 .45-1 1H2c-.55 0-1 .45-1 1v1c0 .55.45 1 1 1v9c0 .55.45 1 1 1h7c.55 0 1-.45 1-1V5c.55 0 1-.45 1-1V3c0-.55-.45-1-1-1zm-1 12H3V5h1v8h1V5h1v8h1V5h1v8h1V5h1v9zm1-10H2V3h9v1z"></path></svg>';
    com.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 16" width="12" height="16"><path fill-rule="evenodd" d="M6 5H2V4h4v1zM2 8h7V7H2v1zm0 2h7V9H2v1zm0 2h7v-1H2v1zm10-7.5V14c0 .55-.45 1-1 1H1c-.55 0-1-.45-1-1V2c0-.55.45-1 1-1h7.5L12 4.5zM11 5L8 2H1v12h10V5z"></path></svg>';

    tr.appendChild(com)
    tr.appendChild(del)

    var top = ev.target.children[1].children[0]


    // append tr to calender when dropping
    top.appendChild(tr);

    // edit popup while insetion
    if (partim == "true") {

        var div = document.getElementById('insertModalAlert');
        div.innerHTML = '<div  class="alert alert-warning" role="alert">Pensez a preciser les partims dans le commentaire !</div>';

    }
    if (liaison == "true") {

        var div = document.getElementById('insertModalAlert');
        div.innerHTML = '<div  class="alert alert-warning" role="alert">Ce cours a des liaisons !</div>';

    }

    $('#insertModaltitle').text("Code du cours: " + data);
    $('#insertModalDate').val(date);
    $('#insertModalCours').val(data);

    $('#insertModal').on('hidden.bs.modal', function() {
        location.reload();
    })


    $('#insertModal').modal('show');


}