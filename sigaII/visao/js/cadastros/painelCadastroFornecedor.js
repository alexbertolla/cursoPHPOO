var tipoFornecedor;
var painelCadastroFornecedor = $("#painelCadastroFornecedor");
var divFormCadastroFornecedor = $("#divFormCadastroFornecedor");
var divMenuCadastroFornecedor = $("#divMenuCadastroFornecedor");
var divPainelCadastroFornecedor = $("#divPainelCadastroFornecedor");
var divFornecedoresCadastrados = $("#divFornecedoresCadastrados");


var listarFornecedorCadastrado = function () {
    var opcao = "listar";
    var url = $(painelCadastroFornecedor).find("#url").val();
    var parametros = {opcao: opcao, tipoFornecedor: tipoFornecedor};
    requisicaoAjax(url, parametros, function (retornoListarFornecedorCadastrado) {
        if (retornoListarFornecedorCadastrado.estado === "sucesso") {
//            montarListaFornecedor(retornoListarFornecedorCadastrado.dados);
            montarTabelaFornecedoresCadastrados(retornoListarFornecedorCadastrado.dados);
        }
    });
};

var alterarF = function (fornecedor) {
    $(painelCadastroFornecedor).find("#fornecedorId").val(fornecedor.id);
    alterarFornecedor(fornecedor);
    mostrarPainelCadastroFornecedor();
};

var mostrarListaFornecedoresCadastrados = function () {
    $(divFornecedoresCadastrados).show();
    $(divPainelCadastroFornecedor).hide();
};

var mostrarPainelCadastroFornecedor = function () {
    $(divFornecedoresCadastrados).hide();
    $(divPainelCadastroFornecedor).show();
};

var carregarFormularioFornecedor = function () {
    
    var formularioCadastro;
    
    if (tipoFornecedor === "pj") {
        formularioCadastro = "formCadFornecedorPJ.html";
        $(".panel-head-cad-mat h3").text("PESSOA JURIDICA");
    } else {
        formularioCadastro = "formCadFornecedorPF.html";
        $(".panel-head-cad-mat h3").text("PESSOA FISICA");
    }

    $(divFormCadastroFornecedor).children().remove();
    $(divFormCadastroFornecedor).load(formularioCadastro);
    
};

var inicializarPainelFornecedor = function () {
    listarFornecedorCadastrado();
    carregarFormularioFornecedor();
    mostrarListaFornecedoresCadastrados();
};

var montarTabelaFornecedoresCadastrados = function (listaFornecedor) {
    var tabela = $("#tabelaFornecedoresCadastrados");
    $(tabela).addClass("table");
    var tbdoy = $(tabela).children("tbody");
    $(tbdoy).children().remove();
    $(listaFornecedor).each(function () {
        var fornecedor = $(this)[0];
        var tdDocumento = $("<td>").append(fornecedor.documento).addClass("tdDocumentoFornecedor");
        var tdNome = $("<td>").append(fornecedor.nome).addClass("tdNomeFornecedor");
        var tdBotoes = $("<td>").addClass("tdBotoesFornecedor");

        var classeBotao = "btn btn-warning";
        var tituloBotao = "Desativar";
        if (fornecedor.situacao === "0") {
            setItemInativo(tdNome);
            classeBotao = "btn btn-info";
            tituloBotao = "Ativar";
        }

        var buttonExcluir = criarButton("", "", "", "Excluir", "btn btn-danger", function () {
            excluirFornecedor(fornecedor);
        });

        var buttonSituacao = criarButton("", "", "", tituloBotao, classeBotao, function () {
            situacaoFornecedor(fornecedor);
        });

        $(tdNome).click(function () {
            alterarF(fornecedor);
        });

        $(tdBotoes).append([buttonSituacao, buttonExcluir])

        var tr = $("<tr>").append([tdDocumento, tdNome, tdBotoes]);
        $(tbdoy).append(tr);
    });
};

$(document).ready(function () {
    tipoFornecedor = $(painelCadastroFornecedor).find("#tipoFornecedor").val();
    inicializarPainelFornecedor();

    $("#botaoNovoFornecedor").click(function () {
        novoFornecedor();
        mostrarPainelCadastroFornecedor();
    });
});