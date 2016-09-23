$(document).ready(function () {
    var formPedidoChefiaAutorizacao = $("#formPedidoChefiaAutorizacao");
    var divJustificativa = $("#divJustificativa");
    var divListaPedidosAberto = $("#divListaPedidosAberto");

    var listarPedidosAberto = function () {
        var opcao = "listarPedidos";
        var url = $("#url").val();
        var parametros = {opcao: opcao};
        requisicaoAjax(url, parametros, retornoListarPedidosAberto);
    };

    var retornoListarPedidosAberto = function (retornoLista) {
        if (retornoLista.dados.length === 0) {
            $(".panel-autorizar-pedido .panel-body h4").text("Sem pedidos pendentes de autorização.");
            divListaPedidosAberto.hide();
        } else {
            montarListaPedidosAberto(retornoLista.dados);
        }
    };

    var montarListaPedidosAberto = function (listaPedidosAberto) {
        var tabela = $("#tabelaPedidosAbertos");
        var tbody = $(tabela).children("tbody");
        $(tbody).children().remove();
        $(listaPedidosAberto).each(function () {
            var pedido = $(this)[0];

            var buttonReceber = criarButton("", "button", "", "Receber", "botaoReceberPedido", function () {
                receberPedido(pedido.pedido);
            });//id, tipo, nome, titulo, classes, acao


            var buttonAutorizar = criarButton("", "button", "", "Autorizar", "botaoAutorizarPedido", function () {
                autorizarPedido(pedido.pedido, 1);
            });

            var buttonNaoAutorizar = criarButton("", "button", "", "Não Autorizar", "botaoNaoAutorizarPedidio", function () {
                autorizarPedido(pedido, 0);
            });

            var buttonDevolver = criarButton("", "button", "", "Devolver ao solicitante", "botaoDevolverPedido", function () {
                devolverPedido(pedido);
            });

            if (pedido.recebido === "0") {
                $(buttonReceber).prop({disabled: false});
                $(buttonAutorizar).prop({disabled: true});
                $(buttonNaoAutorizar).prop({disabled: true});
                $(buttonDevolver).prop({disabled: true});
            } else {
                $(buttonReceber).prop({disabled: true});
                $(buttonAutorizar).prop({disabled: false});
                $(buttonNaoAutorizar).prop({disabled: false});
                $(buttonDevolver).prop({disabled: false});
            }

            var tdNumeroPedido = $("<td>").append(pedido.pedido.numero).addClass("tdNumeroPedido");
            var tdDataPedido = $("<td>").append(pedido.pedido.dataCriacao).addClass("tdDataPedido");
            var tdSolicitantePedido = $("<td>").append(pedido.pedido.solicitante.nome).addClass("tdSolicitantePedido");
            var tdBotoesPedido = $("<td>").append([buttonReceber, buttonAutorizar, buttonNaoAutorizar, buttonDevolver]).addClass("tdBotoesPedido");

            var tr = $("<tr>").append([tdNumeroPedido, tdDataPedido, tdSolicitantePedido, tdBotoesPedido]);
            $(tbody).append(tr);
        });
    };

    var autorizarPedido = function (pedido, autorizado) {
        limparFormulario(formPedidoChefiaAutorizacao);
        setOpcao(formPedidoChefiaAutorizacao, "autorizarPedido");
        $("#id").val(pedido.id);
        $("#matriculaResponsavel").val(UsusarioLogado.matricula);
        $("#autorizado").val(autorizado);
        $(divJustificativa).show();
        divListaPedidosAberto.hide();
    };

    var enviarAutorizacao = function () {
        submeterFormulario(formPedidoChefiaAutorizacao, function (retorno) {
            exibirMensagem(retorno.estado, retorno.mensagem);
            inicializar();
        });
    };



    var receberPedido = function (pedido) {
        var opcao = "receberPedido";
        var url = $("#url").val();
        var matriculaResponsavel = UsusarioLogado.matricula;
        var parametros = {opcao: opcao, id: pedido.id, matriculaResponsavel: matriculaResponsavel};
        console.log(parametros);
        requisicaoAjax(url, parametros, function (retorno) {
            exibirMensagem(retorno.estado, retorno.mensagem);
            listarPedidosAberto();
        });
    };

    var devolverPedido = function (pedido) {
        var opcao = "devolverPedido";
        var url = $("#url").val();
        var matriculaResponsavel = UsusarioLogado.matricula;
        var parametros = {opcao: opcao, id: pedido.id, matriculaResponsavel: matriculaResponsavel};
        
        requisicaoAjax(url, parametros, function (retorno) {
            exibirMensagem(retorno.estado, retorno.mensagem);
            listarPedidosAberto();
        });
    };

    var inicializar = function () {
        $(divJustificativa).hide();
        divListaPedidosAberto.show();
        limparFormulario(formPedidoChefiaAutorizacao);
        listarPedidosAberto();
    };

    $(formPedidoChefiaAutorizacao).submit(function (event) {
        event.preventDefault();
        enviarAutorizacao();
    });

    inicializar();

    $("#botaoCancelar").click(function () {
        inicializar();
    });
});