


var formGerenciarLotes = $("#formGerenciarLotes");
var tabelaLoteZero = $("#tabelaLoteZero");
var selectLote = $("#selectLote");

var gerarNovoLote = function () {
    var opcao = "gerarNovoLote";
    var processoCompraId = processoCompraGlobal.id;
    var modalidadeId = processoCompraGlobal.modalidadeId;
    var url = $("#urlLote").val();
    var parametros = {opcao: opcao, processoCompraId: processoCompraId, modalidadeId: modalidadeId};

    requisicaoAjax(url, parametros, function (retornoGerarNovoLote) {
        console.log(retornoGerarNovoLote);
        montarSelectLote(retornoGerarNovoLote.dados);
    });
};

var gerenciarLotes = function () {
    montarSelectLote(processoCompraGlobal.listaLoteProcessoCompra);
    montarTabelaLoteZero();
};

var montarSelectLote = function (listaLoteProcessoCompra) {
    $(selectLote).children().remove();
    $(listaLoteProcessoCompra).each(function () {
        var lote = $(this)[0];
        if (lote.numero > 0) {
            var option = criarOption(lote.id, "LOTE " + lote.numero, false);
            $(selectLote).append(option);
        }
    });
};


var montarTabelaLoteZero = function () {
    var tbody = $(tabelaLoteZero).children("tbody");
    limparTabela(tbody);
    $(arrayLoteProcessoCompra[0].listaItemProcessoCompra).each(function () {
        var itemProcesso = $(this)[0];
        var checkbox = criarCheckbox("", "", itemProcesso.itemId, false);
        $(checkbox).addClass("itemLoteZeroSelecionado");
        var tdSelect = $("<td>").append(checkbox).addClass("tdSelectItemLoteZero");
        var tdCodigoItemPedido = $("<td>").append(itemProcesso.item.codigo).addClass("tdCodigoItemLoteZero");
        var tdDescricaoItemPedido = $("<td>").append(itemProcesso.item.descricao).addClass("tdDescricaoItemLoteZero");
        var tdQuantidadeItemPedido = $("<td>").append(itemProcesso.quantidade).addClass("tdQuantidadeItemLoteZero");


        var botaoIncluirItem = criarButton("", "button", "", "Incluir", "botaoSelecionar botaoSelecionarItemProcesso", function () {
            if (incluirItemNoLote(itemProcesso)) {
                $(tr).remove();
            }
        });

        var tdIncluirItem = $("<td>").append(botaoIncluirItem).addClass("tdIncluirItemLoteZero");

        var tr = $("<tr>").append([tdSelect, tdCodigoItemPedido, tdDescricaoItemPedido, tdQuantidadeItemPedido, tdIncluirItem]);
        $(tbody).append(tr);
    });
};

var selecionarTodosItensProcesso = function () {
    var checked = $("#selecionarTodosItemProcesso").prop("checked");
    $(".itemLoteZeroSelecionado").prop({checked: checked});
};

var incluirItensProcessoSelecionados = function () {
    var itensSelecionados = $(".itemLoteZeroSelecionado:checked");
    console.log(itensSelecionados.length);
    if ($("#selectLote").val() !== null) {
        $(itensSelecionados).each(function () {
            var botaoIncluir = $(this).parents("tr");
            $(botaoIncluir).find(".botaoSelecionarItemProcesso").click();
        });
    } else {
        exibirAlerta("ERRO", "Inclua um novo lote");
    }

};

var incluirItemNoLote = function (itemProcesso) {
    var opcao = "incluirItem";
    var processoCompraId = itemProcesso.processoCompraId;
    var loteId = $(selectLote).val();
    var itemId = itemProcesso.itemId;
    var url = $("#urlLote").val();
    var parametros = {opcao: opcao, loteId: loteId, processoCompraId: processoCompraId, itemId: itemId};
    if (loteId !== null) {
        console.log(loteId);
        requisicaoAjax(url, parametros, function (retornoGerarNovoLote) {
            if (retornoGerarNovoLote.estado === "sucesso") {
                montarArrayListaLotes(retornoGerarNovoLote.dados);
            }
            console.log(retornoGerarNovoLote);
        });
        return true;
    } else {
        exibirAlerta("ERRO", "Inclua um novo lote");
        return false;
    }
};

$(document).ready(function () {
    $("#novoLote").click(function () {
        gerarNovoLote();
    });

    $("#botaoFecharFormlote").click(function () {
        fecharDivAuxiliar();
//        mostrarFormularioCadastroProcessos();
        montarTabelasLotes();
        $(divGerenciarLote).children().remove();
    });

    $("#selecionarTodosItemProcesso").click(function () {
        selecionarTodosItensProcesso();
    });

    $("#botaoIncluirTodosItemProcesso").click(function () {
        incluirItensProcessoSelecionados();
    });

});
