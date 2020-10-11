$('#rimuoviModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var data = button.data('data');
    var ora = button.data('ora');
    var fkpersona = button.data('fkpersona');
    var antinfluenzale = button.data('antinfluenzale');
    var antipneumococco = button.data('antipneumococco');
    var idprenotazione = button.data('idprenotazione');

    var modal = $(this)

    modal.find('#modal-info').text('Modifico visita del: ' + data + ' delle ore ' + ora + ' ?');
    modal.find('#modal-mod-vaccinabile').val(fkpersona);
    modal.find('#modal-mod-antinfluenzale').val(antinfluenzale);
    modal.find('#modal-mod-antipneumococco').val(antipneumococco);
    modal.find('#modal-mod-idprenotazione').val(idprenotazione);

    document.getElementById("tipologia").value = 0;
    document.getElementById("data").value = data;
    document.getElementById("ora").value = ora;
});

function btn_fatto() {
    document.getElementById("tipologia").value = 'fatto';
    document.getElementById("form_rimuovi").submit();
}

function btn_cancella() {
    document.getElementById("tipologia").value = 'cancella';
    document.getElementById("form_rimuovi").submit();
}

function btn_modifica() {
    document.getElementById("tipologia").value = 'modifica';
    document.getElementById("form_rimuovi").submit();
}

$('#aggiungiModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);

    var data = button.data('adddata');
    var ora = button.data('addora');
    var giorno = button.data('addgiorno');

    var modal = $(this)

    modal.find('#modal-add-data').text(giorno + " " + data);
    modal.find('#modal-add-ora').text('Ore: ' + ora);

    document.getElementById("add-ora").value = ora;
    document.getElementById("add-data").value = data;
});

function btn_aggiungi() {
    document.getElementById("form_aggiungi").submit();
}

$(window).scroll(function () {
    sessionStorage.scrollTop = $(this).scrollTop();
});

$(document).ready(function () {
    if (sessionStorage.scrollTop != "undefined") {
        $(window).scrollTop(sessionStorage.scrollTop);
    }

    // $('#InputVaccinabile').select2({
    //     dropdownParent: $('#aggiungiModal')
    // });
});
