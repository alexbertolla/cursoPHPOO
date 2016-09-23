

$(document).ready(function () {
    var formEmitirOrdemDeCompra = $("#formEmitirOrdemDeCompra");

    var tabelaFornecedores = $("#tabelaFornecedores");
    var tabelaItemOrdemDeCompra = $("#tabelaItemOrdemDeCompra");
    var tabelaEmpenho = $("#tabelaEmpenho");

    var divOrdemDeComprasCadastradas = $("#divOrdemDeComprasCadastradas");
    var divFormEmitirOrdemDeCompra = $("#divFormEmitirOrdemDeCompra");
    var divAssitaturaFornecedor = $("#divAssitaturaFornecedor");
    var divAlterarPrazo = $("#divAlterarPrazo");

    var arrayItemOrdemDeCompra = [];
    var arrayItemProcessoCompra = [];

    var limparArrayItemOrdemDeCompra = function () {
        arrayItemOrdemDeCompra.splice(0, arrayItemOrdemDeCompra.length);
    };


    var mostrarDivOrdemDeComprasCadastradas = function () {
        $(divOrdemDeComprasCadastradas).show();
        $(divFormEmitirOrdemDeCompra).hide();
        $(divAssitaturaFornecedor).hide();
        $(divAlterarPrazo).hide();
    };

    var mostrarFormularioEmissaoOrdemDeCompra = function () {
        $(divOrdemDeComprasCadastradas).hide();
        $(divFormEmitirOrdemDeCompra).show();
        $(divAssitaturaFornecedor).hide();
        $(divAlterarPrazo).hide();
    };

    var mostrarFormularioAssinaturaFornecedor = function () {
        $(divOrdemDeComprasCadastradas).hide();
        $(divFormEmitirOrdemDeCompra).hide();
        $(divAssitaturaFornecedor).show();
        $(divAlterarPrazo).hide();
    };

    var mostrarFormularioAlteracaoPrazo = function () {
        $(divOrdemDeComprasCadastradas).hide();
        $(divFormEmitirOrdemDeCompra).hide();
        $(divAssitaturaFornecedor).hide();
        $(divAlterarPrazo).show();
    };

    var inserirItemNoArrayItemOrdemDeCompra = function (itemProcessoCompra) {
        var dados = {ordemCompraId: $(formEmitirOrdemDeCompra).find("#id").val(), processoCompraId: itemProcessoCompra.processoCompraId, modalidadeId: itemProcessoCompra.modalidadeId,
            fornecedorId: itemProcessoCompra.fornecedorId, situacaoId: $(formEmitirOrdemDeCompra).find("#situacaoId").val(), loteId: itemProcessoCompra.loteId, pedidoId: itemProcessoCompra.pedidoId, grupoId: itemProcessoCompra.grupoId,
            naturezaDespesaId: itemProcessoCompra.naturezaDespesaId, itemId: itemProcessoCompra.itemId, quantidade: itemProcessoCompra.quantidade, valorUnitario: itemProcessoCompra.valorUnitario, valorTotal: itemProcessoCompra.valorTotal, item: null//itemProcessoCompra.item
        };
        arrayItemOrdemDeCompra.push(dados);
    };

    var atualizaArrayItemProcessoCompra = function (itemProcessoCompra, novaQuantidade) {
        var indice = arrayItemProcessoCompra.indexOf(itemProcessoCompra);
        itemProcessoCompra.quantidade = novaQuantidade;
        itemProcessoCompra.valorTotal = novaQuantidade * itemProcessoCompra.valorUnitario;


        arrayItemOrdemDeCompra[indice] = itemProcessoCompra;
//        montarTabelaItemOrdemDeCompra();
    };

    var listarFornecedores = function () {
        var url = $("#urlOrdemDeCompra").val();
        var opcao = "listarAgrupadasPorFornecedor";
        var processoCompraId = $(formEmitirOrdemDeCompra).find("#processoCompraId").val();

        var parametros = {opcao: opcao, processoCompraId: processoCompraId};
        requisicaoAjax(url, parametros, function (retornoListarFornecedores) {
            if (retornoListarFornecedores.estado === "sucesso") {
                montarTabelaFornecedores(retornoListarFornecedores.dados);
            }
        });

    };

    var montarTabelaFornecedores = function (listaFornecedores) {
        var tbody = $(tabelaFornecedores).children("tbody");
        limparTabela(tbody);
        $(listaFornecedores).each(function () {
            var fornecedor = $(this)[0].fornecedor;
            var tdDocumento = $("<td>").append(fornecedor.documento).addClass("tdDocumentoFornecedor");
            var tdNome = $("<td>").append(fornecedor.nome).addClass("tdNomeFornecedor");
            var trFornecedor = $("<tr>").append([tdDocumento, tdNome]);
            var tdOrdemCompra = $("<td>").addClass("tdOrdemCompra");
            $(tdOrdemCompra).attr({colspan: 2})
            var trOrdemCompra = $("<tr>").append(tdOrdemCompra);
            var tabelaOrdemDeCompra = listarOrdemDeCompraPorFornecedor(fornecedor.id);
            tdOrdemCompra.append(tabelaOrdemDeCompra);
            $(tbody).append([trFornecedor, trOrdemCompra]);
        });
    };

    var listarOrdemDeCompraPorFornecedor = function (fornecedorId) {
        var url = $("#urlOrdemDeCompra").val();
        var opcao = "listaPorFornecedor";
        var processoCompraId = $("#processoCompraId").val();

        var parametros = {opcao: opcao, processoCompraId: processoCompraId, fornecedorId: fornecedorId};
        var tabela;
        requisicaoAjax(url, parametros, function (retornoListarOrdemDeCompra) {
            if (retornoListarOrdemDeCompra.estado === "sucesso") {
                tabela = montarTabelaOrdemDeCompra(retornoListarOrdemDeCompra.dados);
            }
        });

        return tabela;
    };

    var montarTabelaOrdemDeCompra = function (listaOrdemDeCompra) {
        var tabela = $("<table>");
        var tbody = $("<tbody>");
        limparTabela(tbody);
        $(listaOrdemDeCompra).each(function () {
            var ordemDeCompra = $(this)[0];
            var tdNumero = $("<td>").append(ordemDeCompra.numero).addClass("tdNumeroOrdemDeCompra");
            var tdSequencia = $("<td>").append(ordemDeCompra.sequencia).addClass("tdSequenciaOrdemDeCompra");
            var tdValor = $("<td>").append(ordemDeCompra.valor).addClass("tdValorOrdemDeCompra");
            var tdEmissao = $("<td>").append(ordemDeCompra.dataEmissao).addClass("tdDataEmissaoOrdemDeCompra");
            var tdPrazo = $("<td>").append(ordemDeCompra.dataPrazoEntrega).addClass("tdPrazoOrdemDeCompra");
            var tdSituacao = $("<td>").append(ordemDeCompra.situacao.situacao).addClass("tdSituacaoOrdemDeCompra");



            var spanBotoes = criarSpanBotoes(ordemDeCompra);
            var tdBotoes = $("<td>").append(spanBotoes).addClass("tdBotoesOrdemCompra");
            var tr = $("<tr>").append([tdNumero, tdSequencia, tdValor, tdEmissao, tdPrazo, tdSituacao, tdBotoes]);
            $(tbody).append(tr);

        });
        $(tabela).append(tbody);
        $(tabela).append(cabechalhoTabelaOrdemDeCompra());
        return tabela;
    };

    var cabechalhoTabelaOrdemDeCompra = function () {
        var thead = $("<thead>");
        var thNumeroOrdemCompra = $("<th>").append("Número").addClass("thNumeroOrdemCompra");
        var thSequenciaOrdemCompra = $("<th>").append("Sequência").addClass("thSequenciaOrdemCompra");
        var thValorOrdemCompra = $("<th>").append("Valor").addClass("thValorOrdemCompra");
        var thDataEmissaoOrdemCompra = $("<th>").append("Data Emissão").addClass("thDataEmissaoOrdemCompra");
        var thDataEntregaOrdemCompra = $("<th>").append("Data Prevista").addClass("thDataEntregaOrdemCompra");
        var thSituacaoOrdemCompra = $("<th>").append("Situação").addClass("thSituacaoOrdemCompra");
        var thBotoesOrdemCompra = $("<th>").append("Ação").addClass("thBotoesOrdemCompra");
        var tr = $("<tr>").append([thNumeroOrdemCompra, thSequenciaOrdemCompra, thValorOrdemCompra, thDataEmissaoOrdemCompra, thDataEntregaOrdemCompra, thSituacaoOrdemCompra, thBotoesOrdemCompra]);
        $(thead).append(tr);
        return  thead;
    };



    var criarSpanBotoes = function (ordemDeCompra) {
        /*
         * EmEdicao = 0;
         const Emitida = 1;
         const RecebidaChefia = 2;
         const AssinadaChefia = 3;
         const NaoAssinadaChefia = 4;
         const EncaminhadaFornecedor = 5;
         const AssinadaFornecedor = 6;
         */
        var span;
        switch (ordemDeCompra.situacao.codigo) {
            case "0":
                span = spanOCAberta(ordemDeCompra);
                break;
            case "1":
                span = spanOCEmitida(ordemDeCompra);
                break;
            case "6":
                span = spanOCAssinada(ordemDeCompra);
                break;
        }
        return span;
    };

    var spanOCAberta = function (ordemDeCompra) {
        var botao = criarButton("", "Button", "EmitirOC", "Emitir Ordem de Compra", "EmitirOCS", function () {
            emitirOCS(ordemDeCompra);
            mostrarFormularioEmissaoOrdemDeCompra();
        });

        return  $("<span>").append(botao);
    };

    var spanOCEmitida = function (ordemDeCompra) {
        var botao = criarButton("", "Button", "AssFornecedorOC", "Ass. Fornecedor", "AssFornecedorOC", function () {
            var formAssinaturaFornecedor = $("#formAssinaturaFornecedor");
            $(formAssinaturaFornecedor).find(".ocsNumero").text(ordemDeCompra.numero);
            $(formAssinaturaFornecedor).find(".ocsFornecedor").text(ordemDeCompra.fornecedor.nome);
            $(formAssinaturaFornecedor).find("#dataAssinatura").datepicker(calendario());
            $("#id").val(ordemDeCompra.id);
            $("#prazo").val(ordemDeCompra.prazo);
            mostrarFormularioAssinaturaFornecedor();
        });

        return  $("<span>").append([botao, gerarBotaoImprimir(ordemDeCompra)]);
    };

    spanOCAssinada = function (ordemDeCompra) {
        var botao = criarButton("", "Button", "alterarPrazo", "Alterar prazo", "botaoAlterarPrazoOC", function () {
            var formAlterarPrazo = $("#formAlterarPrazo");
            $(formAlterarPrazo).find(".ocsNumero").text(ordemDeCompra.numero);
            $(formAlterarPrazo).find(".ocsFornecedor").text(ordemDeCompra.fornecedor.nome);
            $("#id").val(ordemDeCompra.id);
            mostrarFormularioAlteracaoPrazo();
        });

        return  $("<span>").append([botao, gerarBotaoImprimir(ordemDeCompra)]);
    };

    var gerarBotaoImprimir = function (ordemDeCompra) {
        var botaoImprimir = criarButton("", "Button", "Imprimir", "imprimir", "botaoImprimir", function () {
            imprimirOCS(ordemDeCompra.id);
        });
        return botaoImprimir;
    };

    var emitirOCS = function (ordemDeCompra) {
        $(".spanFormulario").text("");
        carregarDadosNaOCS(ordemDeCompra);
    };

    var imprimirOCS = function (id) {
        window.open("imprimirOC.php?id=" + id);
    };

    var registrarAssinaturaFornecedor = function () {
        var id = $("#id").val();
        var prazo = $("#prazo").val();
        var dataAssinatura = $("#dataAssinatura").val();

        var parametros = {opcao: "assinaturaFornecedor", id: id, dataAssinatura: dataAssinatura, prazo: prazo};
        var url = $("#urlOrdemDeCompra").val();
        requisicaoAjax(url, parametros, function (retornoAjax) {
            limparFormulariosInternos($("#formAssinaturaFornecedor"));
            inicializarEmissaoOCS();
        });
    };

    var alterarPrazo = function () {
        var id = $("#id").val();
        var novoPrazo = $("#novoPrazo").val();
        var parametros = {opcao: "atualizarPrazo", id: id, prazo: novoPrazo};
        var url = $("#urlOrdemDeCompra").val();
        requisicaoAjax(url, parametros, function (retornoAjax) {
            limparFormulariosInternos($("#formAlterarPrazo"));
            inicializarEmissaoOCS();
        });
    };

    var limparFormulariosInternos = function (formulario) {
        limparFormulario(formulario);
        $(formulario).find(".spanInfoOCS").text("");
    };

    var carregarDadosNaOCS = function (ordemDeCompra) {
        var fornecedor = ordemDeCompra.fornecedor;
        var endereco = fornecedor.endereco;
        var listaDadosBancario = fornecedor.dadosBancarios;

        $(formEmitirOrdemDeCompra).find("#id").val(ordemDeCompra.id);
        $(formEmitirOrdemDeCompra).find("#fornecedorId").val(ordemDeCompra.fornecedorId);
        $(formEmitirOrdemDeCompra).find("#modalidadeId").val(ordemDeCompra.modalidadeId);
        $(formEmitirOrdemDeCompra).find("#situacaoId").val(ordemDeCompra.situacaoId);
        $(formEmitirOrdemDeCompra).find("#tipoFornecedor").val(ordemDeCompra.tipoFornecedor);

        $("#spanFornecedorNome").text(fornecedor.nome);
        $("#spanFornecedorDocumento").text(fornecedor.documento);

        $("#spanEndereco").text(endereco.logradouro + ", " + endereco.numero);
        $("#spanEnderecoComplemento").text(endereco.complemento);
        $("#spanEnderecoBairro").text(endereco.bairro);
        $("#spanEnderecoCidade").text(endereco.cidade);
        $("#spanEnderecoEstado").text(endereco.estado);
        $("#spanEnderecoCEP").text(endereco.cep);
        $("#spanEnderecoPais").text(endereco.pais);

        montarSelecDadosBancario(listaDadosBancario);
        arrayItemProcessoCompra = ordemDeCompra.listaItemProcessoCompra;
        montarTabelaItemOrdemDeCompra();
        montarTabelaEmepenho(ordemDeCompra.listaEmpenho);

    };

    var montarSelecDadosBancario = function (listaDadosBancario) {
        var select = $("#selectDadosBancario");
        $(select).children().remove();
        $(listaDadosBancario).each(function () {
            var dadosBancario = $(this)[0];
            var texto = "Banco:" + dadosBancario.Banco.codigo + "-" + dadosBancario.Banco.nome + " - Agência:" + dadosBancario.agencia + " - Conta:" + dadosBancario.conta;
            var option = criarOption(dadosBancario.id, texto, false);
            $(select).append(option);
        });

    };

    var montarTabelaItemOrdemDeCompra = function () {

//        CONTINUAR A PARTIR DAQUI - ALEX
        var tbody = $(tabelaItemOrdemDeCompra).children("tbody");
        limparTabela(tbody);
        var itemAnterior = 0;
        $(arrayItemProcessoCompra).each(function () {
            var itemProcessoCompra = $(this)[0];
            
            var item = itemProcessoCompra.item;

//            var divItemIndividual = $('<div>').append(montarTabelaItemIndividual(itemProcessoCompra)).addClass('divItemIndividual');
//            var trItemIndividual = $('<tr>').append($('<td>').append(divItemIndividual));

            if (itemAnterior !== itemProcessoCompra.itemId) {

                var tdCodigo = $("<td>").append(item.codigo).addClass("tdCodigoItem");
                var tdDescricao = $("<td>").append(item.descricao).addClass("tdDescricaoItem");
                var inputQuantidadeTotal = criarText("quantidateTotal" + itemProcessoCompra.itemId, "", "Quantidade", "inputQuantidade");//id, nome, placeholder, classe

                $(inputQuantidadeTotal).val(itemProcessoCompra.quantidade);

                var tdQuantidadeTotal = $("<td>").append(inputQuantidadeTotal).addClass("tdQuantidadeTotal");
                var tdValorUnitario = $("<td>").append(itemProcessoCompra.valorUnitario).addClass("tdValorUnitarioItem").addClass("tdValorUnitarioItem" + itemProcessoCompra.itemId);
                var tdValorTotal = $("<td>").append(itemProcessoCompra.valorTotal).addClass("tdValorTotalItem").addClass("tdValorTotalItem" + itemProcessoCompra.itemId);
                var tr = $("<tr>").append([tdCodigo, tdDescricao, tdQuantidadeTotal, tdValorUnitario, tdValorTotal]);
                $(tbody).append(tr);
            }

            var divItemIndividual = $('<div>').addClass('divItemIndividual');

            $(divItemIndividual).append(montarTabelaItemIndividual(itemProcessoCompra));
            $(tbody).append((divItemIndividual));
            calcularTotalItem(itemProcessoCompra.itemId);

            itemAnterior = itemProcessoCompra.itemId;



//            $(inputQuantidadeTotal).blur(function () {
//                var novaQuantidade = parseFloat($(this).val());
//                var quantidadeAtual = parseFloat(itemProcessoCompra.quantidade);
//                var valorUnitario = parseFloat($(tdValorUnitario).text());
//
//                if (verificaQuantidade(quantidadeAtual, novaQuantidade)) {
//                    atualizarValorTotalItem(novaQuantidade, valorUnitario, tdValorTotal);
//                    atualizaArrayItemProcessoCompra(itemProcessoCompra, novaQuantidade);
//                } else {
//                    $(this).val(quantidadeAtual);
//                    atualizarValorTotalItem(quantidadeAtual, valorUnitario, tdValorTotal);
//                    atualizaArrayItemProcessoCompra(itemProcessoCompra, quantidadeAtual);
//                }
//
////                atualizaArrayItemProcessoCompra(itemProcessoCompra, $(inputQuantidade).val(), $(tdValorTotal).text());
//            });







//            $(inputQuantidadeTotal).val(itemProcessoCompra.quantidade);
        });

        $(tabelaItemOrdemDeCompra).append(tbody);

    };

    var calcularTotalItem = function (itemId) {
        var qtdTotal = 0;
        $('.inputQuantidadeItem' + itemId).each(function () {
            qtdTotal += parseFloat($(this).val());
        });
        $('#quantidateTotal' + itemId).val(qtdTotal);
        calcularValorTotalItem(itemId, qtdTotal);
    };

    var calcularValorTotalItem = function (itemId, quantidade) {
        var valorUnitario = parseFloat($('.tdValorUnitarioItem' + itemId).text());
        $('.tdValorTotalItem' + itemId).text(valorUnitario * quantidade);
    };

    var montarTabelaItemIndividual = function (itemProcesso) {
        var pedido = buscarInfoPedidoPorId(itemProcesso.pedidoId);
        var tbody;
        $(pedido.listaItemPedido).each(function () {
            var itemPedido = $(this)[0];
            var tdSolicitante = $('<td>').append(pedido.solicitante);
            var inputQuantidadeItem = criarText('', '', 'Quantidade', 'inputQuantidadeItem' + itemProcesso.itemId);
            $(inputQuantidadeItem).val(itemProcesso.quantidade);
            var tdQuantidade = $('<td>').append(inputQuantidadeItem);
            var tr = $('<tr>').append([tdSolicitante, tdQuantidade]);
            tbody = $('<tbody>').append(tr);
            $(inputQuantidadeItem).change(function () {
                if (verificaQuantidade(parseFloat(itemProcesso.quantidade), parseFloat($(inputQuantidadeItem).val()))) {
                    calcularTotalItem(itemProcesso.itemId);
                    atualizaArrayItemProcessoCompra(itemProcesso, parseFloat($(inputQuantidadeItem).val()));
                } else {
                    $(inputQuantidadeItem).val(itemProcesso.quantidade);
                }
            });
        });
        return $('<table>').append(tbody);

    };


    var buscarInfoPedidoPorId = function (pedidoId) {
        var parametros = {opcao: 'buscarPorId', id: pedidoId};
        var urlPedidoOCS = $('#urlPedidoOCS').val();
        var pedido;
        requisicaoAjax(urlPedidoOCS, parametros, function (retornoBuscarPorId) {
            pedido = retornoBuscarPorId.dados;
        });
        return {solicitante: pedido.solicitante.nome, listaItemPedido: pedido.listaItemPedido};

    };


    var verificaQuantidade = function (quantidadePedido, novaQuantidade) {
        if (isNaN(novaQuantidade)) {
            exibirAlerta("ERRO", "Quantidade inválida");
            return false;
        }


        if (novaQuantidade > quantidadePedido || novaQuantidade < 0) {
            exibirAlerta("ERRO", "Quantidade inválida! Quantidade não pode ser maior que solicitada no processo de compra nem negativa!");
            return false;
        }
        return true;
    };



    var montarTabelaEmepenho = function (listaEmpenho) {
        var tbody = $(tabelaEmpenho).children("tbody");
        limparTabela(tbody);
        $(listaEmpenho).each(function () {

            var emepenho = $(this)[0];
            var tdNumeto = $("<td>").append().addClass("tdNumeroEmpenho");
            var tdData = $("<td>").append().addClass("tdDataEmpenho");
            var tdUnidade = $("<td>").append(emepenho.unidadeOrcamentaria).addClass("tdUnidade");
            var tdFundo = $("<td>").append().addClass("tdFundoEmpenho");
            var tdPa = $("<td>").append(emepenho.pa.titulo).addClass("tdPaEmpenho");
            var tdvalor = $("<td>").append(emepenho.valor).addClass("tdvalorEmpenho");
            var tdND = $("<td>").append(emepenho.naturezaDespesa.nome).addClass("tdNDEmpenho");
            var tdResponsavel = $("<td>").append(emepenho.pedido.solicitante.nome).addClass("tdResponsavelEmpenho");
            var tr = $("<tr>").append([tdNumeto, tdData, tdUnidade, tdFundo, tdPa, tdvalor, tdND, tdResponsavel]);
            $(tbody).append(tr);
        });
        $(tabelaEmpenho).append(tbody);
    };

    var efetivarEmissaoOrdemDeCompra = function () {
        limparArrayItemOrdemDeCompra();
        $(arrayItemProcessoCompra).each(function () {
            var itemProcessoCompra = $(this)[0];
            if (itemProcessoCompra.quantidade > 0) {
                inserirItemNoArrayItemOrdemDeCompra(itemProcessoCompra);
            }
        });

        var id = $(formEmitirOrdemDeCompra).find("#id").val();
        var dadosBancarioId = $(formEmitirOrdemDeCompra).find("#selectDadosBancario").val();
        var prazo = $("#prazo").val();
        var parametros = {opcao: "efetivarEmissao", id: id, dadosBancarioId: dadosBancarioId, prazo: prazo, listaItemOrdemCompra: arrayItemOrdemDeCompra};
        
        var url = $("#urlOrdemDeCompra").val();
        requisicaoAjax(url, parametros, function (retornoEfetivarEmissao) {
//            imprimirOCS(id);
            inicializarEmissaoOCS();
        });

    };

    var limparSpamFormulario = function () {
        $(".spanFormulario").text("");
    };

    var inicializarEmissaoOCS = function () {
//        limparArrayItemOrdemDeCompra();
        limparFormulario(formEmitirOrdemDeCompra);
        limparTabela($(tabelaItemOrdemDeCompra).children("tbody"));
        limparSpamFormulario();
        listarFornecedores();
        mostrarDivOrdemDeComprasCadastradas();

    };

//    inicializarEmissaoOCS();

    $(formEmitirOrdemDeCompra).submit(function (event) {
        event.preventDefault();
        if (confirm("Confirma emissão da ordem de compra?")) {
            efetivarEmissaoOrdemDeCompra();
        }
    });

    $("#botaoCancelar").click(function () {
        inicializarEmissaoOCS();
    });

    $("#botaoFecharEmissaoOCS").click(function () {
        fecharDivAuxiliar();
        $(divEmitirOrdemDecompra).children().remove();
    });

    $("#botaoInicializar").click(function () {
        inicializarEmissaoOCS();
    });

    $("#salvarAssinatura").click(function () {
        registrarAssinaturaFornecedor();
    });

    $("#salvarNovoPrazo").click(function () {
        alterarPrazo();
    });

    $(".botaoVoltar").click(function () {
        inicializarEmissaoOCS();
    });
});