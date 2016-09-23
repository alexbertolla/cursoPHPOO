var formCadEnderecoFornecedor = $("#formCadEnderecoFornecedor");
var urlurlEndereco = $(formCadEnderecoFornecedor).find("#url").val();

var buscarPorCep = function () {
    var opcao = "buscarPorCep";
    var cep = $("#cep").val();
    var parametros = {opcao: opcao, cep: cep};
    requisicaoAjax(urlurlEndereco, parametros, retornoBuscarPorCep);
};

var retornoBuscarPorCep = function (retorno) {
    if (retorno.estado === "sucesso") {
        carregarDadosEnderecoNoFormulario(retorno.dados);
        $("#numero").focus();
    } else {
        alert(retorno.mensagem);
        limparCamposEndereco();
        $("#cep").focus();
    }
};

var carregarDadosEnderecoNoFormulario = function (endereco) {
    if (endereco !== null) {
        $(formCadEnderecoFornecedor).find("#fornecedorId").val(endereco.fornecedorId);
        $("#cep").val(endereco.cep);
        $("#logradouro").val(endereco.logradouro);
        $("#numero").val(endereco.numero);
        $("#complemento").val(endereco.complemento);
        $("#bairro").val(endereco.bairro);
        $("#cidade").val(endereco.cidade);
        $("#estado").val(endereco.estado);
        $("#pais").val(endereco.pais);
    }
};

var limparCamposEndereco = function () {
    $("#logradouro").val("");
    $("#numero").val("");
    $("#complemento").val("");
    $("#bairro").val("");
    $("#cidade").val("");
    $("#estado").val("");
    $("#pais").val("");
};

var salvarEndereco = function (fornecedorId) {
    $(formCadEnderecoFornecedor).find("#fornecedorId").val(fornecedorId);
    submeterFormulario(formCadEnderecoFornecedor, retornoSalvarEndereco);
};

var retornoSalvarEndereco = function (retornoSubmit) {
    if (retornoSubmit.estado === "sucesso") {
//        carregarDadosEnderecoNoFormulario(retornoSubmit.dados);
    }
};

$("#botaoBuscarCep").click(function () {
    buscarPorCep();
});