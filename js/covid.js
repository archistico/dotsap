$(document).ready(function() {
    $('.js-select2').select2();

    document.getElementById("btnModifica").addEventListener("click", function(){
        let sel = document.getElementById("selectModifica");
        let link = "{{@BASE}}/covid/scheda/" + sel.options[sel.selectedIndex].value;
        window.location.href = link;
    });

    document.getElementById("btnVisualizza").addEventListener("click", function(){
        let sel = document.getElementById("selectModifica");
        let link = "{{@BASE}}/covid/lista/" + sel.options[sel.selectedIndex].value;
        window.location.href = link;
    });    
});

