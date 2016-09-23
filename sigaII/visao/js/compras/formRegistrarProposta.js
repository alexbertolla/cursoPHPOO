var formRegistrarProposta = $("#formRegistrarProposta");
var formPesquisarFornecedor = $("#formPesquisarFornecedor");
var divFormRegistrarProposta = $("#divFormRegistrarProposta");
var valorTotalProposta = 0;
var arrayItemProposta = [];

var incluirItemPropostaNoArray = function (itemProcesso, quantidade, valorUnitario, valorTotal) {
    var propostaId = $("#processoCompraId").val();
    var modalidadeId = $("#modalidadeId").val();
    var fornecedorId = $("#fornecedorId").val();
    var tipoFornecedor = $("#tipoFornecedor").val();
    arrayItemProposta.push({propostaId: propostaId, fornecedorId: fornecedorId, processoCompraId: itemProcesso.processoCompraId, modalidadeId: modalidadeId, loteId: itemProcesso.loteId,
        pedidoId: itemProcesso.pedidoId, grupoId: itemProcesso.grupoId, naturezaDespesaId: itemProcesso.naturezaDespesaId, itemId: itemProcesso.itemId, quantidade: quantidade,
        valorUnitario: valorUnitario, valorTotal: valorTotal, tipoFornecedor: tipoFornecedor});
};

var removerItemPropostaDoArray = function (itemProcesso) {
    $(arrayItemProposta).each(function () {
        var itemProposta = $(this)[0];
        var indice = arrayItemProposta.indexOf(itemProposta);
        if (itemProcesso.itemId === itemProposta.itemId) {
            arrayItemProposta.splice(indice, 1);
            return false;
        }
    });

};

var registrarNovaProposta = function (processoCompraId, modalidadeid, listaLoteProcesso) {
//    carregarCalendario($("#data"));
    limparFormulario(formPesquisarFornecedor);
    limparFormulario(formRegistrarProposta);
    valorTotalProposta = 0;
    arrayItemProposta = [];
    $(formRegistrarProposta).find("#processoCompraId").val(processoCompraId);
    $(formRegistrarProposta).find("#modalidadeId").val(modalidadeid);
    montarTabelaLotesProcesso(listaLoteProcesso);
};

var montarTabelaLotesProcesso = function (listaLoteProcesso) {
    $("#divTabelaPropostaLotes").children().remove();
    $(listaLoteProcesso).each(function () {
        var loteProcessoCompra = $(this)[0];
        var tabela = montarTabelaPropostaItemProcesso(loteProcessoCompra);
        $("#divTabelaPropostaLotes").append(tabela);
    });
    atualizarValorProposta();
};

var montarTabelaPropostaItemProcesso = function (loteProcessoCompra) {

    var tabela = $("<table>").addClass("tabelaItemProposta");
    tabela.addClass("table table-striped table-condensed");
    var thead = criarCabecalhoTabelaItemProposta();
    var tfoot = criarRodaPeTabelaItemProposta();

    $(thead).children(".thTituloTabelaProposta").text(loteProcessoCompra.numero);
    $(tabela.append(thead));
    $(tabela).append(tfoot);

    var tbody = $("<tbody>").appendTo(tabela);
    limparTabela(tbody);
    var numeroItemProcesso = 1;
    var quantidadeTotal = 0;

    $(loteProcessoCompra.listaItemProcessoCompra).each(function () {

        var itemProcesso = $(this)[0];
        var tdNumeroItemProposta = $("<td>").append(numeroItemProcesso).addClass("tdNumeroItemProposta");
        var tdCodigoItemProposta = $("<td>").append(itemProcesso.item.codigo).addClass("tdCodigoItemProposta");
        var tdDescricaoItemProposta = $("<td>").append(itemProcesso.item.descricao).addClass("tdDescricaoItemv");
        var tdQuantidadeItemProposta = $("<td>").append(itemProcesso.quantidade).addClass("tdQuantidadeItemProposta text-center");

        var txtValorUnitario = criarText("", "", "", "textValorUnitario");//id, nome, placeholder, classe
        $(txtValorUnitario).val(0);

        var tdValorUnitarioItemProposta = $("<td>").append(txtValorUnitario).addClass("tdValorUnitarioItemProposta text-right");

        var txtValorTotal = criarText("", "", "", "textValorTotal");//id, nome, placeholder, classe
        $(txtValorTotal).val(0);

        var tdValorTotalItemProposta = $("<td>").append(txtValorTotal).addClass("tdValorTotalItemProposta text-right");

        var botaoIncluir = criarButton("", "button", "", "Incluir", "botaoIncluirItemProposta botaoSelecionar", function () {
            var valorTotal = incluirItemProposta($(txtValorUnitario).val(), itemProcesso.quantidade, itemProcesso);
            if (valorTotal) {
                $(txtValorTotal).val(valorTotal);
                $(this).hide();
                $(botaoRemover).show();
                var valorTotalLote = atualizarValorLote(tabela);
                $(tabela).find(".spanValorLote").text(valorTotalLote);
                atualizarValorProposta();
            }
        });//id, tipo, nome, titulo, classes, acao

        var botaoRemover = criarButton("", "button", "", "Remover", "botaoRemoverItemProposta botaoRemover", function () {

            var valorLoteAtualizado = removerItemProposta($(txtValorTotal).val(), $(tabela).find(".tdFootValorTotal").text(), itemProcesso);
            $(tabela).find(".spanValorLote").text(valorLoteAtualizado);
            $(txtValorUnitario).val(0);
            $(txtValorTotal).val(0);
            $(this).hide();
            $(tdBotoesItemProposta).find(".botaoIncluirItemProposta").show();
            atualizarValorProposta();
        });

        $(botaoRemover).hide();

        var tdBotoesItemProposta = $("<td>").append([botaoIncluir, botaoRemover]).addClass("tdBotoesItemProposta");
        var tr = $("<tr>").append([tdNumeroItemProposta, tdCodigoItemProposta, tdDescricaoItemProposta, tdQuantidadeItemProposta, tdValorUnitarioItemProposta, tdValorTotalItemProposta, tdBotoesItemProposta]);

        $(tbody).append(tr);
        numeroItemProcesso++;
        quantidadeTotal += parseInt(itemProcesso.quantidade);
    });
    $(tabela).find(".tdFootQuantidade").text(quantidadeTotal);
    return tabela;
};

var criarCabecalhoTabelaItemProposta = function () {
    var thTituloTabela = $("<th>").addClass("thTituloTabelaProposta");
    $(thTituloTabela).attr({colspan: 5});
    var thNumeroItemProposta = $("<th>").append("Item").addClass("thNumeroItemProposta");
    var thCodigoItem = $("<th>").append("Código").addClass("thCodigoItemProposta");
    var thDescricaoItem = $("<th>").append("Descrição").addClass("thDescricaoItemProposta");
    var thQuantidadeItem = $("<th>").append("Quantidade").addClass("thQuantidadeItemProposta");
    var thValorUnitarioItem = $("<th>").append("Valor Unitário").addClass("thValorUnitarioItemProposta text-right");
    var thValorTotalItem = $("<th>").append("Valor Total").addClass("thValorTotalItem text-right");
    var thBotoesItem = $("<th>").addClass("thBotoesItemProposta");
    var thead = $("<thead>").append("<tr>");
    $(thead).append("<tr>").append(thTituloTabela);
    $(thead).append("<tr>").append([thNumeroItemProposta, thCodigoItem, thDescricaoItem, thQuantidadeItem, thValorUnitarioItem, thValorTotalItem, thBotoesItem]);

    return thead;
};

var criarRodaPeTabelaItemProposta = function () {
    var td = $("<td>").attr({colspan: 3});
    var tdQuantidade = $("<td>").addClass("tdFootQuantidade");
    var tdValorTotal = $("<td>").addClass("tdFootValorTotal").attr({colspan: 2});
    var spanValorLote = $("<span>").text(0).addClass("spanValorLote");
    $(tdValorTotal).append(spanValorLote);
    return  $("<tfoot>").append("<tr>").append([td, tdQuantidade, tdValorTotal]);
};

var incluirItemProposta = function (valorUnitario, quantidade, itemProcesso) {
    if (!isNaN(valorUnitario) && valorUnitario > 0) {
        var valorTotal = calcularValorTotal(parseFloat(valorUnitario), quantidade);
        incluirItemPropostaNoArray(itemProcesso, quantidade, valorUnitario, valorTotal);
        return valorTotal;
    } else {
        exibirAlerta("ERRO", "Valor inválido");
        return false;
    }
};

var removerItemProposta = function (valorTotalItem, valorLote, itemProcesso) {
    var valorLoteAtualizado = parseFloat(valorLote) - parseFloat(valorTotalItem);
    removerItemPropostaDoArray(itemProcesso);
    return valorLoteAtualizado;
};

var calcularValorTotal = function (valorUnitario, quantidade) {
    return valorUnitario * parseFloat(quantidade);
};

var atualizarValorLote = function (tabela) {
    var valoresTotal = $(tabela).find(".textValorTotal");
    var valorLote = 0;
    $(valoresTotal).each(function () {
        valorLote += (parseFloat($(this).val()));
    });
    return valorLote;
};

var atualizarValorProposta = function () {
    var valoresLotes = $(".tdFootValorTotal");
    var valorProposta = 0;
    $(valoresLotes).each(function () {
        var valorLote = $(this).children(".spanValorLote").text();
        valorProposta += parseFloat(valorLote);
    });

    $("#valor").val(valorProposta);
};


var fecharFormularioPropostas = function () {
    limparFormulario(formPesquisarFornecedor);
    limparFormulario(formRegistrarProposta);
    $(divRegistrarProposta).children().remove();
    fecharDivAuxiliar();
};

$(document).ready(function () {

    var salvarProposta = function () {
        var fornecedorId = $("#fornecedorId").val();
        var tipoFornecedor = $(".tipoFornecedor:checked").val();
        var processoCompraId = $("#processoCompraId").val();
        var modalidadeId = $("#modalidadeId").val();
        var numero = $("#numeroProposta").val();
        var valor = $("#valor").val();
        var data = $("#data").val();
        var parametros = {opcao: "inserir", fornecedorId: fornecedorId, tipoFornecedor: tipoFornecedor, processoCompraId: processoCompraId,
            modalidadeId: modalidadeId, numero: numero, valor: valor, data: data, listaItemProposta: arrayItemProposta};
        var url = $("#urlProposta").val();
        requisicaoAjax(url, parametros, function (retornoSalvarProposta) {
            if (retornoSalvarProposta.estado === "sucesso") {
                $(".spanText").children().remove();
                if (confirm("Proposta foi registrada com sucesso!\nDeseja registrar outra proposta?")) {
                    registrarNovaProposta(retornoSalvarProposta.dados.processoCompraId, retornoSalvarProposta.dados.modalidadeId, processoCompraGlobal.listaLoteProcessoCompra);
                } else {
                    fecharFormularioPropostas();
                }
            }
        });
    };

    var abrirCadastroFornecedor = function () {
        $(divFormRegistrarProposta).hide();
        $("#divCadastroFornecedor").show();

        tipoFornecedor = $(".tipoFornecedor:checked").val();

        $("#divPainelCadastroFornecedores").load("painelCadastroFornecedor.html", function () {
            $(this).find("#tipoFornecedor").val(tipoFornecedor);
        });
    };


    $(formPesquisarFornecedor).submit(function (event) {
        event.preventDefault();
        var documento = $("#documentoFornecedor").val();
        var tipoFornecedor = $(".tipoFornecedor:checked").val();
        var parametros = {opcao: "buscarPorDocumento", documento: documento, tipoFornecedor: tipoFornecedor};
        var url = $("#urlFornecedor").val();
        requisicaoAjax(url, parametros, function (retorno) {
            $(".spanText").children().remove();
            if (retorno.estado === "sucesso") {
                $("#fornecedorId").val("");
                $("#tipoFornecedor").val("");
                detalharFornecedor(retorno.dados);
            } else {

                exibirAlerta(retorno.estado, "Fornecedor não encontrado!");
            }
        });
    });

    var detalharFornecedor = function (fornecedor) {
        $("#spanDocumentoFornecedor").text(fornecedor.documento);
        $("#spanNomeFornecedor").text(fornecedor.nome);
        $("#fornecedorId").val(fornecedor.id);
        $("#tipoFornecedor").val(fornecedor.tipo);
    };



    $(formRegistrarProposta).submit(function (event) {
        event.preventDefault();
        if (arrayItemProposta.length > 0) {
            if ($("#fornecedorId").val() === "") {
                exibirAlerta("ERRO", "Indique um fornecedor!");
                return false;
            }

        } else {
            exibirAlerta("ERRO", "Nenhum item foi incluido na proposta!");
            return false;
        }
        salvarProposta();
    });


    $("#botaoAbriCadastroFornecedor").click(function () {
        abrirCadastroFornecedor();
    });

    $("#botaoCancelarProposta").click(function () {
        fecharFormularioPropostas();
    });

    $("#botaoFechardivCadastroFornecedor").click(function () {
        $(divFormRegistrarProposta).show();
        $("#divCadastroFornecedor").hide();
        $("#divPainelCadastroFornecedores").children().remove();
    });

    carregarCalendario($("#data"));


});