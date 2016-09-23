$(document).ready(function () {
    var divListaPedidosAReceber = $("#divListaPedidosAReceber");


    var listarPedidosAReceber = function () {
        var opcao = "listarPedidosAReceber";
        var url = $("#url").val();
        var parametros = {opcao: opcao};
        requisicaoAjax(url, parametros, retornoListarPedidos);
    };

    var retornoListarPedidos = function (retornoLista) {
        if (retornoLista.estado === "sucesso") {
            montarListaPedidos(retornoLista.dados);
        }
    };

    var montarListaPedidos = function (listaPedidos) {
        var tabela = $("#tabelaPedidosAbertos");
        var tbody = $(tabela).children("tbody");
        $(tbody).children().remove();
        $(listaPedidos).each(function () {
            var pedido = $(this)[0];
            console.log(pedido);
            var buttonReceber = criarButton("", "button", "", "Receber", "botaoReceberPedido", function () {
                receberPedido(pedido.pedido);
            });//id, tipo, nome, titulo, classes, acao


            var tdNumeroPedido = $("<td>").append(pedido.pedido.numero).addClass("tdNumeroPedido");
            var tdDataPedido = $("<td>").append(pedido.pedido.dataCriacao).addClass("tdDataPedido");
            var tdSolicitantePedido = $("<td>").append(pedido.pedido.solicitante.nome).addClass("tdSolicitantePedido");
            var tdJustificativaPedido = $("<td>").append(pedido.pedido.justificativa).addClass("tdJustificativaPedido");
            var tdBotoesPedido = $("<td>").append(buttonReceber).addClass("tdBotoesPedido");

            var tr = $("<tr>").append([tdNumeroPedido, tdDataPedido, tdSolicitantePedido, tdJustificativaPedido, tdBotoesPedido]);
            $(tbody).append(tr);
        });
    };


    var receberPedido = function (pedido) {
        var opcao = "receberPedido";
        var url = $("#url").val();
        var matriculaResponsavel = UsusarioLogado.matricula;
        var parametros = {opcao: opcao, id: pedido.id, matriculaResponsavel: matriculaResponsavel};
        requisicaoAjax(url, parametros, function (retorno) {
            exibirMensagem(retorno.estado, retorno.mensagem);
            listarPedidosAReceber();
        });
    };

    listarPedidosAReceber();

});