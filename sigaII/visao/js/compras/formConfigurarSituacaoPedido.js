$(document).ready(function () {
    var formConfigurarSituacaoPedido = $("#formConfigurarSituacaoPedido");
    var selectSituacaoPedido = $("#selectSituacaoPedido");

    var listarSituacaoPedido = function () {
        var url = $("#url").val();
        var parametros = {opcao: "listar"};
        requisicaoAjax(url, parametros, function (retornoListar) {
            montarSelect(retornoListar.dados);
        });
    };

    var montarSelect = function (listaSituacaoPedido) {
        var option0 = criarOption("", "Selecione uma opção", true);
        $(selectSituacaoPedido).append(option0);
        $(listaSituacaoPedido).each(function () {
            var situacaoPedido = $(this)[0];
            var option = criarOption(situacaoPedido.id, situacaoPedido.situacao, false);
            $(selectSituacaoPedido).append(option);
        });
    };

    var buscarPorId = function (id) {
        var url = $("#url").val();
        var parametros = {opcao: "buscarPorId", id: id};
        requisicaoAjax(url, parametros, function (retornoListar) {
            carregarDados(retornoListar.dados);
        });
    };

    var carregarDados = function (situacaoPedido) {
        console.log(situacaoPedido);
        $("#id").val(situacaoPedido.id);
        $("#codigo").val(situacaoPedido.codigo);
        $("#mensagem").val(situacaoPedido.mensagem);
        tinyMCE.get("mensagem").setContent(situacaoPedido.mensagem);
        $("#enviaEmail").prop({checked: (situacaoPedido.enviaEmail === "1") ? true : false});
    };

    var inicializar = function () {
        $(selectSituacaoPedido).children().remove();
        limparFormulario(formConfigurarSituacaoPedido);
        listarSituacaoPedido();
    };

    inicializar();

    $(formConfigurarSituacaoPedido).submit(function (event) {
        event.preventDefault();
        submeterFormulario(formConfigurarSituacaoPedido, function (retornoSubmit) {
            console.log(retornoSubmit);
            exibirAlerta("INFO", retornoSubmit.mensagem);
            if (retornoSubmit.estado === "sucesso") {
                inicializar();
            }
        });
    });

    $(selectSituacaoPedido).change(function () {
        buscarPorId($(this).val());
    });
});