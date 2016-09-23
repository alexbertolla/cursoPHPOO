var formCadFornecedor = $("#formCadFornecedorPJ");
var divEnderecoFornecedor = $("#divEnderecoFornecedor");
var divFormCadastroFornecedorPJ = $("#divFormCadastroFornecedorPJ");
var divCadastroAuxiliarDadosBancarios = $("#divCadastroAuxiliarDadosBancarios");
var divCadastroAuxiliarGrupos = $("#divCadastroAuxiliarGrupos");



var carregarDadosFornecedor = function (fornecedor) {
    $(formCadFornecedor).find("#id").val(fornecedor.id);
    $(formCadFornecedor).find("#documento").val(fornecedor.documento);
    $(formCadFornecedor).find("#nome").val(fornecedor.nome);
    $(formCadFornecedor).find("#nomeFantasia").val(fornecedor.nomeFantasia);
    $(formCadFornecedor).find("#site").val(fornecedor.site);
    $(formCadFornecedor).find("#situacao").prop({checked: (fornecedor.situacao === "1") ? true : false});
    $(formCadFornecedor).find("#microEmpresa").prop({checked: (fornecedor.microEmpresa === "1") ? true : false});
    carregarDadosEnderecoNoFormulario(fornecedor.endereco);
    carregarDadosTelefoneNoFormulario(fornecedor.id);
    carregarDadosEmailNoFormulario(fornecedor.id);

};

var carregarFormularioCadastroFornecedor = function () {
    $(divCadastroAuxiliarDadosBancarios).children().remove();
    $(divCadastroAuxiliarGrupos).children().remove();
    $(divFormCadastroFornecedorPJ).show();
};

var carregarCadastroDadosBancarioFornecedor = function (linkDadosBancario) {
    $(divCadastroAuxiliarDadosBancarios).children().remove();
    $(divCadastroAuxiliarDadosBancarios).load(linkDadosBancario);
    $(divCadastroAuxiliarGrupos).children().remove();
    $(divFormCadastroFornecedorPJ).hide();
};

var carregarCadastroGruposFronecedor = function (linkGrupo) {
    $(divCadastroAuxiliarDadosBancarios).children().remove();
    $(divCadastroAuxiliarGrupos).children().remove();
    $(divCadastroAuxiliarGrupos).load(linkGrupo);
    $(divFormCadastroFornecedorPJ).hide();
};

var fecharFormularioCadastroFornecedor = function () {
    $(divFormCadastroFornecedor).children().remove();
    carregarFormularioFornecedor();
    inicializarPainelFornecedor();
};


var novoFornecedor = function () {
    setOpcao(formCadFornecedor, "inserir");
    bloquearSalvar(true);
    bloquearCNPJ(false);
};

var alterarFornecedor = function (fornecedor) {
    limparFormulario(formCadFornecedor);
    setOpcao(formCadFornecedor, "alterar");
    carregarDadosFornecedor(fornecedor);
    bloquearSalvar(false);
    bloquearCNPJ(true);
    removerLinkBloqueado();
};

var bloquearCNPJ = function (opcao) {
    $(formCadFornecedor).find("#documento").prop({readonly: opcao});
    $(formCadFornecedor).find("#buttonCNPJ").prop({disabled: opcao});
};

var bloquearSalvar = function (opcao) {
    $(formCadFornecedor).find("#botaoSalvar").prop({disabled: opcao});
};

var validarDocumento = function (retornoAjax) {
    if (retornoAjax.estado === "sucesso") {
        bloquearCNPJ(true);
        bloquearSalvar(false);
        $(formCadFornecedor).find("#nome").focus();
        if (retornoAjax.dados) {
            if (confirm("CNPJ válido e já cadastrado! \n Deseja carregar os dados?")) {
                alterarFornecedor(retornoAjax.dados);
                removerLinkBloqueado();
            } else {
                bloquearCNPJ(false);
                bloquearSalvar(true);
                $(formCadFornecedor).find("#documento").focus();
            }
        }
    } else {
        exibirAlerta(retornoAjax.estado, retornoAjax.estado + " - " + retornoAjax.mensagem)
        bloquearCNPJ(false);
        $(formCadFornecedor).find("#documento").focus();
    }
};

var salvarFornecedor = function () {
    submeterFormulario(formCadFornecedor, function (retornoSalvarFornecedor) {
        alert(retornoSalvarFornecedor.estado + " - " + retornoSalvarFornecedor.mensagem);
        if (retornoSalvarFornecedor.estado === "sucesso") {
            salvarEndereco(retornoSalvarFornecedor.dados.id);
            salvarTelefones(retornoSalvarFornecedor.dados.id);
            salvarEmails(retornoSalvarFornecedor.dados.id);
            alterarFornecedor(retornoSalvarFornecedor.dados)
        }
    });
};

var excluirFornecedor = function (fornecedor) {
    setOpcao(formCadFornecedor, "excluir");
    carregarDadosFornecedor(fornecedor);
    if (confirm("Confirma exclusão do fornecedor: " + fornecedor.nome + " ?")) {
        submeterFormulario(formCadFornecedor, inicializarPainelFornecedor);
    }
};

var situacaoFornecedor = function (fornecedor) {
    alterarFornecedor(fornecedor);
    $(formCadFornecedor).find("#situacao").prop({checked: (fornecedor.situacao === "0") ? true : false});
    submeterFormulario(formCadFornecedor, inicializarPainelFornecedor);
};


$(document).ready(function () {
    /*** carregar outros formularios ***/
    $("#divEnderecoFornecedor").load("formCadEnderecoFornecedor.html", function () {
        $("#divTelefoneFornecedor").load("formCadTelefoneFornecedor.html", function () {
            $("#divEmailFornecedor").load("formCadEmailFornecedor.html", function () {
                $("#documento").focus();
            });
        });
    });


    $("#buttonCNPJ").click(function () {
        var url = $(formCadFornecedor).find("#url").val();
        var cnpj = $(formCadFornecedor).find("#documento").val();
        var parametros = {opcao: "validarDocumento", documento: cnpj, tipoFornecedor: tipoFornecedor};
        requisicaoAjax(url, parametros, validarDocumento);
    });


    $(formCadFornecedor).submit(function (event) {
        event.preventDefault();
        salvarFornecedor();
    });

});