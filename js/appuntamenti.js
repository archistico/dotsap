$('#rimuoviModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var data = button.data('data');
    var ora = button.data('ora');
    var persona = button.data('persona');
    var modal = $(this)
    modal.find('.modal-title').text('Attenzione');
    modal.find('#modal-info').text('Rimuovo appuntamento del: ' + data + ' delle ore ' + ora + '?');
    modal.find('#modal-persona').text('Prenotato: ' + persona);

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

    setTimeout(function () {
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

$('.parti').on("click", function (event) {
    var button = $(event.currentTarget);
    var data = button.data('data');
    var ora = button.data('ora');

    var form = document.createElement("form");
    var datainput = document.createElement("input");
    var orainput = document.createElement("input");
    var lunediinput = document.createElement("input");

    form.method = "POST";
    form.action = "{{@BASE}}{{ 'appuntamentoparti' | alias }}";

    datainput.value = data;
    datainput.name = "data";
    form.appendChild(datainput);

    orainput.value = ora;
    orainput.name = "ora";
    form.appendChild(orainput);

    lunediinput.value = '{{ @lunedi }}';
    lunediinput.name = "tabelladata";
    form.appendChild(lunediinput);

    document.body.appendChild(form);
    form.submit();
});