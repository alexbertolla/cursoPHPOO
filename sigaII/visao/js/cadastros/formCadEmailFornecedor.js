var formCadEmailFornecedor = $("#formCadEmailFornecedor");
var urlEmail = $(formCadEmailFornecedor).find("#url").val();
var listaEmail = [];

var limparFormularioEmail = function () {
    limparFormulario(formCadEmailFornecedor);
    $(formCadEmailFornecedor).find("#fornecedorId").val($(document).find("#fornecedorId").val());
};

var carregarDadosEmailNoFormulario = function (fornecedorId) {
    var parametros = {"opcao": "listarPorFornecedorId", "fornecedorId": fornecedorId};
    requisicaoAjax(urlEmail, parametros, montarListaEmailsCadastrados);
};

var montarListaEmailsCadastrados = function (retornoEmailsCadastrados) {
    var listaEmailsCadastrados = retornoEmailsCadastrados.dados;
    listaEmail.splice(0, listaEmail.length);
    $(listaEmailsCadastrados).each(function () {
        var email = $(this)[0];
        incluirEmail(email.email);
    });
    listarEmailsCadastrados();
};

var listarEmailsCadastrados = function () {
    var tabela = $("#tabelaEmails");
    var tbody = $(tabela).children("tbody");
    $(tbody).children().remove();

    $(listaEmail).each(function () {
        var item = $(this)[0];
        var email = $(this)[0].email;

        var tdEmail = $("<td>").append(email);

        var button = criarButton("", "button", "excluir", "Excluir", "", function () {
            excluirEmail(listaEmail.indexOf(email));
        });

        var tdExcluirEmail = $("<td>").append(button);

        var tr = $("<tr>").append([tdEmail, tdExcluirEmail]);

        $(tbody).append(tr);
    });
};

var excluirEmail = function (email) {
    listaEmail.splice(email, 1);
    listarEmailsCadastrados();
};

var incluirEmail = function (email) {
    listaEmail.push({"email": email});
    limparFormularioEmail();

};

var setToArray = function () {
    var array = [];
    var i = 0;
    $(listaEmail).each(function () {
        array[i] = $(this)[0]; //{"email": $(this)[0].email};
        i++;
    });
    return array;
};

var salvarEmails = function (fornecedorId) {
    var novoArray = setToArray();
    var parametros = {"opcao": $(formCadEmailFornecedor).find("#opcao").val(), "listaEmail": novoArray, "fornecedorId": fornecedorId};
    console.log(parametros);
    requisicaoAjax(urlEmail, parametros, retornoSalvarEmails);
};

var retornoSalvarEmails = function (retorno) {
    console.log(retorno);
    if (retorno.estado === "sucesso") {
        montarListaEmailsCadastrados(retorno.dados);
    }
};


$("#incluirEmail").click(function () {
    var email = $("#email").val();
    if (email !== "") {
        incluirEmail(email);
        listarEmailsCadastrados();
    } else {
        exibirAlerta("Erro", "Campos e-mail obrigatório!");
        $("#email").focus();
    }
});
