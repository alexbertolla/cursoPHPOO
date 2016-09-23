var formCadTelefoneFornecedor = $("#formCadTelefoneFornecedor");
var urlTelefone = $(formCadTelefoneFornecedor).find("#url").val();
var listaTelefone = [];



var limparFormularioTelefone = function () {
    limparFormulario(formCadTelefoneFornecedor);
    $(formCadTelefoneFornecedor).find("#fornecedorId").val($(document).find("#fornecedorId").val());
};

var carregarDadosTelefoneNoFormulario = function (fornecedorId) {
    var parametros = {"opcao": "listarPorFornecedorId", "fornecedorId": fornecedorId};
    requisicaoAjax(urlTelefone, parametros, montarListaTelefonesCadastrados);
};

var montarListaTelefonesCadastrados = function (retornoTelefonesCadastrados) {
    var listaTelefones = retornoTelefonesCadastrados.dados;

    listaTelefone.splice(0, listaTelefone.length);
    $(listaTelefones).each(function () {
        var telefone = $(this)[0];
        incluirTelefone(telefone.ddi, telefone.ddd, telefone.numero);
    });
    listarTelefonesCadastrados();
};

var incluirTelefone = function (ddi, ddd, numeroTelefone) {
    listaTelefone.push({"ddi": ddi, "ddd": ddd, "numeroTelefone": numeroTelefone});
    limparFormularioTelefone();

};

var listarTelefonesCadastrados = function () {
    var tabela = $("#tabelaTelefones");
    var tbody = $(tabela).children("tbody");
    $(tbody).children().remove();

    $(listaTelefone).each(function () {
        var item = $(this)[0];
        var texto = "+" + item.ddi + " (" + item.ddd + ") " + item.numeroTelefone;

        var tdTelefone = $("<td>").append(texto);

        var button = criarButton("", "button", "excluir", "Excluir", "botaoExcluir", function () {
            excluirTelefone(listaTelefone.indexOf(item));
        });

        var tdExcluirTelefone = $("<td>").append(button);

        var tr = $("<tr>").append([tdTelefone, tdExcluirTelefone]);

        $(tbody).append(tr);
    });
};

var excluirTelefone = function (telefone) {
    listaTelefone.splice(telefone, 1);
    listarTelefonesCadastrados();
};

var setToArrayTelefone = function () {
    var array = [];
    var i = 0;
    $(listaTelefone).each(function () {
        array[i] = $(this)[0]; //{"ddi": $(this)[0].ddi, "ddd": $(this)[0].ddd, "numeroTelefone": $(this)[0].numeroTelefone, "fornecedorId": fornecedorId};
        i++;
    });
    return array;
};

var salvarTelefones = function (fornecedorId) {
    var novoArray = setToArrayTelefone(fornecedorId);
    listaTelefone = [];
    var parametros = {"opcao": $(formCadTelefoneFornecedor).find("#opcao").val(), "listaTelefone": novoArray, "fornecedorId": fornecedorId};
    requisicaoAjax(urlTelefone, parametros, montarListaTelefonesCadastrados);
};

var retornoSalvarTelefones = function (retorno) {
    if (retorno.estado === "sucesso") {
        montarListaTelefonesCadastrados(retorno.dados);
    }
};


$("#incluirTelefone").click(function () {
    var ddi = $("#ddi").val();
    var ddd = $("#ddd").val();
    var numeroTelefone = $("#numeroTelefone").val();
    if (ddi !== "" && ddd !== "" && numeroTelefone !== "") {

        incluirTelefone(ddi, ddd, numeroTelefone);
        listarTelefonesCadastrados();

    } else {
        exibirAlerta("Erro", "Campos ddi ddd e número do telefone obrigatórios!");
    }
});
