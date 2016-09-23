$(document).ready(function () {
    var formConfigurarSistema = $("#formConfigurarSistema");

    var buscarConfiguracao = function () {
        var url = $("#url").val();
        var opcao = "buscar";
        var parametros = {opcao: opcao};
        requisicaoAjax(url, parametros, retornoBuscarCongiguracao);
    };

    var retornoBuscarCongiguracao = function (retorno) {
        if (retorno.estado === "sucesso") {
            carregarDadosNoFormulario(retorno.dados);
        }
    };

    var carregarDadosNoFormulario = function (configuracao) {
        $(formConfigurarSistema).find("#anoSistema").val(configuracao.anoSistema);
        $("#liberado").prop({checked: (configuracao.liberado === "1") ? true : false});
    };

    var submit = function () {
        submeterFormulario($(formConfigurarSistema), retornoSubmit);
    };

    var retornoSubmit = function (retornoSubmit) {
        exibirMensagem(retornoSubmit.estado, retornoSubmit.mensagem);
        if (retornoSubmit.estado) {
            exibirAlerta(retornoSubmit.estado,"Configuração do Sistema Alterada! \n Faça novamente o login!");
            inicializar();
        }
    };

    var inicializar = function () {
        buscarConfiguracao();
    };

    inicializar();

    $(formConfigurarSistema).submit(function (event) {
        event.preventDefault();
        submit();
    });
});

