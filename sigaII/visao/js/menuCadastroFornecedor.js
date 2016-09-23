var removerLinkBloqueado = function () {
    var linksBloqueados = $("#menuCadastroFornecedor").children().find(".linkBloqueado");
    $(linksBloqueados).addClass("bloquearLink");
    $(linksBloqueados).removeClass("linkBloqueado");
};

var bloquearLink = function () {
    var linksBloqueados = $("#menuCadastroFornecedor").children().find(".bloquearLink");
    $(linksBloqueados).addClass("linkBloqueado");
    $(linksBloqueados).removeClass("bloquearLink");
};

$(document).ready(function () {
    
    $("a").click(function (event) {
        event.preventDefault();
        switch ($(this).prop("id")) {
            case "cadastroFornecedor":
                carregarFormularioCadastroFornecedor();
                break;
            case "dadosBancario":
                console.log("dados bancarios");
                carregarCadastroDadosBancarioFornecedor($(this).prop("href"));
                console.log("db");
                break;
            case "grupo":
                carregarCadastroGruposFronecedor($(this).prop("href"));
                break;
            case "fecharFormulario":
                fecharFormularioCadastroFornecedor();
                break;

        }
//        if ($(this).prop("id") === "fecharFormulario") {
//            $(divFormCadastroFornecedor).children().remove();
//            limparFormulario(formCadFornecedor);
//            $(formCadFornecedor).find("#fornecedorId").val("");
//            inicializarFormularioFornecedor();
//        } else {
//            var link = $(this).prop("href");
//            carregarDiviAuxiliarFornecedor(link);
//
//        }

    });
});