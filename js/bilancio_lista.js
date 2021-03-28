$(document).ready(function() {
    $('.js-select2').select2();
});

$(function () {
    $('#bilancio').DataTable({
      "columns": [
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        { "width": "5%" },
      ],
      paging: true,
      lengthMenu: [[100, -1], [100, "Tutti"]],
      searching: true,
      ordering: true,
      order: [[0, 'asc']],
      info: true,
      autoWidth: false,
      language: {
        processing:     "Caricamento in corso...",
        search:         "Cerca&nbsp;:",
        lengthMenu:     "Mostra _MENU_ elementi",
        info:           "Elemento da _START_ a _END_ su _TOTAL_",
        infoEmpty:      "Nessuno",
        infoFiltered:   "(filtro con _MAX_ elementi)",
        infoPostFix:    "",
        loadingRecords: "Caricamento in corso...",
        zeroRecords:    "Nessun elemento da mostrare",
        emptyTable:     "Nessun dato disponibile nella tabella",
        paginate: {
            first:      "Primo",
            previous:   "Precedente",
            next:       "Seguente",
            last:       "Ultimo"
        },
        aria: {
            sortAscending:  ": attivare per ordinare in modo crescente",
            sortDescending: ": attivare per ordinare in modo decrescente"
        }
    }
    });
  })