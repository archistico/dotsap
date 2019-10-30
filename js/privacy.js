$('#modificaModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);


    let modalid = button.data('id');
    let modalcognome = button.data('cognome');
    let modalnome = button.data('nome');

    let modal = $(this);

    modal.find('#modalid').text(modalid);
    modal.find('#modalcognome').text(modalcognome);
    modal.find('#modalnome').text(modalnome);

    document.getElementById("input-id").value = modalid;
});

function isValidDate(d) {
    let timestamp = Date.parse(d);

    if (isNaN(timestamp) == false) {
        return true;
    } else {
        return false;
    }
}

function btn_modifica() {
    let d = document.getElementById("datafirma");
    let check = d.value;
    if(isValidDate(check)) {
        document.getElementById("form_modifica").submit();
    } else {
        console.log("Data non valida ", check);
        document.getElementById("datafirma").focus();
        return false;
    }
}

$(window).scroll(function () {
    sessionStorage.scrollTop = $(this).scrollTop();
});

$(document).ready(function () {
    if (sessionStorage.scrollTop != "undefined") {
        $(window).scrollTop(sessionStorage.scrollTop);
    }
});
