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
    
    document.getElementById("tipologia").value=0;
    document.getElementById("data").value=data;
    document.getElementById("ora").value=ora;
});

function btn_annullo() {
    document.getElementById("tipologia").value='annullo';
    document.getElementById("form_rimuovi").submit();
}

function btn_fatto() {
    document.getElementById("tipologia").value='fatto';
    document.getElementById("form_rimuovi").submit();
}

function btn_nonpresentato() {
    document.getElementById("tipologia").value='nonpresentato';
    document.getElementById("form_rimuovi").submit();
}