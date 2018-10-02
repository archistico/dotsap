$('#rimuoviModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var data = button.data('data'); // Extract info from data-* attributes
    var ora = button.data('ora'); // Extract info from data-* attributes
    var persona = button.data('persona'); // Extract info from data-* attributes
    var modal = $(this)
    modal.find('.modal-title').text('Attenzione');
    modal.find('#modal-info').text('Rimuovo appuntamento del: ' + data + ' delle ore ' + ora + '?');
    modal.find('#modal-persona').text('Prenotato: ' + persona);
    
    /*
    <input type="hidden" name="tipologia" value="" id="tipologia">
    <input type="hidden" name="data" value="" id="data">
    <input type="hidden" name="ora" value="" id="ora">
    */

    document.getElementById("tipologia").value = 0;
    document.getElementById("data").value = data;
    document.getElementById("ora").value = ora;
});

function btn_annullo() {
    document.getElementById("tipologia").value = 'annullato';
    document.getElementById("form_rimuovi").submit();
}

function btn_fatto() {
    document.getElementById("tipologia").value = 'fatto';
    document.getElementById("form_rimuovi").submit();
}

function btn_nonpresentato() {
    document.getElementById("tipologia").value = 'assente';
    document.getElementById("form_rimuovi").submit();
}

function btn_cancella() {
    document.getElementById("tipologia").value = 'cancella';
    document.getElementById("form_rimuovi").submit();
}

$('#aggiungiModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);

    var data = button.data('adddata');
    var ora = button.data('addora');
    var giorno = button.data('addgiorno');
    var ambulatorio = button.data('addambulatorio');

    var modal = $(this)

    modal.find('#modal-add-data').text(giorno + " " + data);
    modal.find('#modal-add-ora').text('Ore: ' + ora);
    modal.find('#modal-add-ambulatorio').text('Ambulatorio: ' + ambulatorio);

    document.getElementById("add-ora").value = ora;
    document.getElementById("add-data").value = data;

    setTimeout(function (){
        document.getElementById("persona").focus();
    }, 500);
});

function btn_aggiungi() {
    // controllare che il nome e cognome siano inseriti
    document.getElementById("form_aggiungi").submit();
}

$(window).scroll(function () {
    sessionStorage.scrollTop = $(this).scrollTop();
});

$(document).ready(function () {
    if (sessionStorage.scrollTop != "undefined") {
        $(window).scrollTop(sessionStorage.scrollTop);
    }
});