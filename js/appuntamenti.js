$('#rimuoviModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var data = button.data('data'); // Extract info from data-* attributes
    var ora = button.data('ora'); // Extract info from data-* attributes
    var persona = button.data('persona'); // Extract info from data-* attributes
    var modal = $(this)
    modal.find('.modal-title').text('Attenzione');
    modal.find('#modal-info').text('Rimuovo appuntamento del: ' + data + ' delle ore ' + ora + '?');
    modal.find('#modal-persona').text('Prenotato: ' + persona);
});
