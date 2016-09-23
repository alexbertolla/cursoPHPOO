$(document).ready(function () {
    // $("#conteudoSistema").load("formGerenciarProcessoCompra.html");
    $("#conteudoSistema").load("quickAccess.html");
    
    window.onhashchange = function() {
        if (window.innerDocClick) {
            alert("1");
        } else {
            alert("2");
        }
    };

});

