var listarAtividadePorPedido = function (pedidoId) {
    var url = $("#urlPedidoAtividade").val();
    var opcao = "listarPorPedido";
    var parametros = {opcao: opcao, pedidoId: pedidoId};
    requisicaoAjax(url, parametros, function (retornoListtarPorPedido) {
        if (retornoListtarPorPedido.estado === "sucesso") {
            montarTabelaPedidoAtividade(retornoListtarPorPedido.dados);
        }
    });
};

var montarTabelaPedidoAtividade = function (listaPedidoAtividade) {
    var tbody = $("#tabelaPedidoAtividade").children("tbody");
    limparTabela(tbody);
    $(listaPedidoAtividade).each(function () {
        var pedidoAtividade = $(this)[0];
        var tdDataAtividade = $("<td>").append(pedidoAtividade.data).addClass("tdDataAtividade text-center");
        var tdHoraAtividade = $("<td>").append(pedidoAtividade.hora).addClass("tdHoraAtividade text-center");
        var tdResponsavleAtividade = $("<td>").append(pedidoAtividade.atividade).addClass("tdDataAtividade");
        var tdAtividadeAtividade = $("<td>").append(pedidoAtividade.responsavelClass.nome).addClass("tdDataAtividade");

        var tr = $("<tr>").append([tdDataAtividade, tdHoraAtividade, tdResponsavleAtividade, tdAtividadeAtividade]);
        tbody.append(tr);
    });
};


var listarSituacaoItemPorPedido = function (pedidoId, tipo) {
    var url = $("#urlItemPedido").val();
    var opcao = "listarItemPedidoPorPedido";
    var parametros = {opcao: opcao, pedidoId: pedidoId, tipo: tipo};
    console.log(parametros);
    requisicaoAjax(url, parametros, function (retornoSituacaoItem) {
        if (retornoSituacaoItem.estado === "sucesso") {
            montarTabelaItemSituacao(retornoSituacaoItem.dados);

        }
    });
};

var montarTabelaItemSituacao = function (listaItem) {
    var tbody = $("#tabelaItemSituacao").children("tbody");
    limparTabela(tbody);
    $(listaItem).each(function () {
        var itemPedido = $(this)[0];
        console.log(itemPedido);
        var tdCodigoItem = $("<td>").append(itemPedido.item.codigo).addClass("tdCodigoItem text-center");
        var tdDescricaoItem = $("<td>").append(itemPedido.item.descricao).addClass("tdDescricaoItem");
        var tdSituacaoItem = $("<td>").append(itemPedido.situacao.situacao).addClass("tdSituacaoId");

        var tr = $("<tr>").append([tdCodigoItem, tdDescricaoItem, tdSituacaoItem]);
        tbody.append(tr);
    });
};