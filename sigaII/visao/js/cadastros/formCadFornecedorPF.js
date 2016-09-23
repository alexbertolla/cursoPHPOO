var formCadFornecedor = $("#formCadFornecedorPF");
var divEnderecoFornecedor = $("#divEnderecoFornecedor");
var divFormCadastroFornecedorPF = $("#divFormCadastroFornecedorPF");
var divCadastroAuxiliarDadosBancarios = $("#divCadastroAuxiliarDadosBancarios");
var divCadastroAuxiliarGrupos = $("#divCadastroAuxiliarGrupos");
var formCadDadosBancariosFornecedor = $("#formCadDadosBancariosFornecedor");
var formCadGrupoFornecedor = $("#formCadGrupoFornecedor");




var carregarDadosFornecedor = function (fornecedor) {
    $(formCadFornecedor).find("#id").val(fornecedor.id);
    $(formCadFornecedor).find("#documento").val(fornecedor.documento);
    $(formCadFornecedor).find("#nome").val(fornecedor.nome);
    $(formCadFornecedor).find("#site").val(fornecedor.site);
    $(formCadFornecedor).find("#pis").val(fornecedor.pis);
    $(formCadFornecedor).find("#rg").val(fornecedor.rg);
    $(formCadFornecedor).find("#orgaoExpeditor").val(fornecedor.orgaoExpeditor);
    $(formCadFornecedor).find("#dataExpedicao").val(fornecedor.dataExpedicao);
    $(formCadFornecedor).find("#situacao").prop({checked: (fornecedor.situacao === "1") ? true : false});

    carregarDadosEnderecoNoFormulario(fornecedor.endereco);
    carregarDadosTelefoneNoFormulario(fornecedor.id);
    carregarDadosEmailNoFormulario(fornecedor.id);
    carregarDadosBancariosNoFormulario(fornecedor.id);

};

var carregarFormularioCadastroFornecedor = function () {
    $(divCadastroAuxiliarDadosBancarios).children().remove();
    $(divCadastroAuxiliarGrupos).children().remove();
    $(divFormCadastroFornecedorPF).show();
};

var carregarCadastroDadosBancarioFornecedor = function (linkDadosBancario) {
    $(divCadastroAuxiliarDadosBancarios).children().remove();
    $(divCadastroAuxiliarDadosBancarios).load(linkDadosBancario);
    $(divCadastroAuxiliarGrupos).children().remove();
    $(divFormCadastroFornecedorPF).hide();
};

var carregarCadastroGruposFronecedor = function (linkGrupo) {
    $(divCadastroAuxiliarDadosBancarios).children().remove();
    $(divCadastroAuxiliarGrupos).children().remove();
    $(divCadastroAuxiliarGrupos).load(linkGrupo);
    $(divFormCadastroFornecedorPF).hide();
};

var fecharFormularioCadastroFornecedor = function () {
    $(divFormCadastroFornecedor).children().remove();
    carregarFormularioFornecedor();
    inicializarPainelFornecedor();
};


var novoFornecedor = function () {
    setOpcao(formCadFornecedor, "inserir");
    bloquearSalvar(true);
//    bloquearCNPJ(false);
};

var alterarFornecedor = function (fornecedor) {
    limparFormulario(formCadFornecedor);
    setOpcao(formCadFornecedor, "alterar");
    carregarDadosFornecedor(fornecedor);
    bloquearSalvar(false);
    bloquearCPF(true);
};

var bloquearCPF = function (opcao) {
    $(formCadFornecedor).find("#documento").prop({readonly: opcao});
    $(formCadFornecedor).find("#buttonCPF").prop({disabled: opcao});
};

var bloquearSalvar = function (opcao) {
    $(formCadFornecedor).find("#botaoSalvar").prop({disabled: opcao});
};

var validarDocumento = function (retornoAjax) {
    if (retornoAjax.estado === "sucesso") {
        bloquearCPF(true);
        bloquearSalvar(false);
        $(formCadFornecedor).find("#nome").focus();
        if (retornoAjax.dados) {
            if (confirm("CPF válido e já cadastrado! \n Deseja carregar os dados?")) {
                alterarFornecedor(retornoAjax.dados);
            } else {
                bloquearCPF(false);
                bloquearSalvar(true);
                $(formCadFornecedor).find("#documento").focus();
            }
        }
    } else {
        exibirAlerta(retornoAjax.estado, retornoAjax.estado + " - " + retornoAjax.mensagem)
        bloquearCPF(false);
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


    $("#buttonCPF").click(function () {
        var url = $(formCadFornecedor).find("#url").val();
        var cpf = $(formCadFornecedor).find("#documento").val();
        var parametros = {opcao: "validarDocumento", documento: cpf, tipoFornecedor: tipoFornecedor};
        requisicaoAjax(url, parametros, validarDocumento);
    });


    $(formCadFornecedor).submit(function (event) {
        event.preventDefault();
        salvarFornecedor();
    });
    
    $(formCadDadosBancariosFornecedor).submit(function (event) {
        event.preventDefault();
        submeter();
    });
    
    $(formCadGrupoFornecedor).submit(function (event) {
        event.preventDefault();
        submeterGrupo();
    });
    
});