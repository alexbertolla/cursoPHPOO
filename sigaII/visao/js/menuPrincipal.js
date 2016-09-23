$(document).ready(function () {

    var conteudoSistema = $("#conteudoSistema");


    var carregarCadastroFornecedor = function (tipo) {
        tipoFornecedor = tipo;
        $(conteudoSistema).find("#tipoFornecedor").val(tipo);
    };

    var carregarLinkMenu = function (link, funcao) {
        $(conteudoSistema).load(link, funcao);
    };

    $("a").click(function (event) {
        event.preventDefault();
        var href = $(this).prop("href");
        if ($(this).prop("id") === "pf" || $(this).prop("id") === "pj") {
            var tipo = $(this).prop("id");
            carregarLinkMenu(href, function () {
                carregarCadastroFornecedor(tipo);
            });
        } else if ($(this).hasClass("dropdown-toggle") ) {}
        else {
            carregarLinkMenu(href, null);
        }
    });
    
    $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
        event.preventDefault(); 
        event.stopPropagation(); 
        $(this).parent().siblings().removeClass('open');
        $(this).parent().toggleClass('open');
    });

});