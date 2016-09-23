
$(document).ready(function () {
    var buscarInfoPedido = function () {
        var opcao = "pedidoDetalhado";
        var id = $("#idPedido").val();
        var parametros = {opcao: opcao, id: id};
        var url = $("#urlPedido").val();
        requisicaoAjax(url, parametros, function (retorno) {
            if (retorno.estado === "sucesso") {
                carregarDadosNoRelatorio(retorno.dados);
            }
        });
    };


    var carregarDadosNoRelatorio = function (pedido) {

        console.log(pedido);
        $("#spanNumero").append(pedido.numero).addClass("bold");
        $("#spanDataEnvio").append(pedido.dataEnvio).addClass("bold");
        $("#spanSolicitanteMatricula").append(pedido.solicitante.matricula).addClass("bold");
        $("#spanSolicitanteNome").append(pedido.solicitante.nome).addClass("bold");
        $("#spanSolicitanteEmail").append(pedido.solicitante.email).addClass("bold");
        $("#spanSolicitanteLotacao").append(pedido.solicitante.lotacao.nome).addClass("bold");
        $("#spanGrupo").append(pedido.grupo.nome).addClass("bold");
        $("#spanLotacao").append(pedido.lotacao.nome).addClass("bold");
        $("#spanPACodigo").append(pedido.pa.codigo).addClass("bold");
        $("#spanPATitulo").append(pedido.pa.titulo).addClass("bold");
        $("#spanPAResponsavel").append(pedido.pa.responsavel).addClass("bold");
        $("#spanPASaldoCusteio").append(pedido.pa.saldoCusteio).addClass("bold");
        $("#spanPASaldoInvestimento").append(pedido.pa.saldoInvestimento).addClass("bold");
        $("#spanJustificativa").append(pedido.justificativa).addClass("bold");
        carregarListaItensPedidoAutorizacao(pedido.listaItens);

    };

    var carregarListaItensPedidoAutorizacao = function (listaItensPedido) {
        var tabela = $("#tabelaListaIntesPedidoAutorizacao");
        var tbody = $(tabela).children("tbody");
        $(tbody).children().remove();
        $(listaItensPedido).each(function () {
            var itemPedido = $(this)[0];
            var tdCodigo = $("<td>").append(itemPedido.item.codigo).addClass("tdCodigoItem");
            var tdNomeItem = $("<td>").append(itemPedido.item.nome).addClass("tdNomeItem");
            var tdDescricaoItem = $("<td>").append(itemPedido.item.descricao).addClass("tdNomeDescricao");
            var tdQuantidadeItem = $("<td>").append(itemPedido.quantidade).addClass("tdQuantidadeItem");
            var tr = $("<tr>").append([tdCodigo, tdNomeItem, tdDescricaoItem, tdQuantidadeItem]);
            $(tbody).append(tr);
        });
    };


    buscarInfoPedido();

    $("#imprimirRelatório").click(function () {
        imprimirRelatorio();
    });

});


