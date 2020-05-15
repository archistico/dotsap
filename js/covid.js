$(document).ready(function() {
    $('.js-select2').select2();

    document.getElementById("btnModifica").addEventListener("click", function(){
        let sel = document.getElementById("selectModifica");
        let link = "{{@BASE}}/covid/modifica/" + sel.options[sel.selectedIndex].value;
        window.location.href = link;
    });
});

