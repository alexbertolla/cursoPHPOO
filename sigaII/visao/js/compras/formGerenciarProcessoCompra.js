var processoCompraGlobal;
var indiceOrdenador;

var tabelaProcessosCadastrados = $("#tabelaProcessosCadastrados");
var tabelaItemProcesso = $("#tabelaItemProcesso");
var tabelaListaIntesPedido = $("#tabelaListaIntesPedido");

var formGerenciarProcessoCompra = $("#formGerenciarProcessoCompra");
var formPesquisaPedido = $("#formPesquisaPedido");
var formGerenciarProcessoCompra = $("#formGerenciarProcessoCompra");

var divProcessoCompras = $("#divProcessoCompras");
var divListaProcessosCadastrados = $("#divListaProcessosCadastrados");
var divGerenciaProcessoCompra = $("#divGerenciaProcessoCompra");
var divPesquisaPedidos = $("#divPesquisaPedidos");
var divAuxiliar = $("#divAuxiliar");
var divGerenciarLote = $("#divGerenciarLote");
var divRegistrarProposta = $("#divRegistrarProposta");
var divEmitirOrdemDecompra = $("#divEmitirOrdemDecompra");

var selecModalidade = $("#selectModalidade");

var divTabelasLotes = $("#divTabelasLotes");

var arrayLoteProcessoCompra = [];
var arrayItemPedido = [];


var mostrarProcessosCadastrados = function () {
    $(divListaProcessosCadastrados).show();
    $(divGerenciaProcessoCompra).hide();
    $(divPesquisaPedidos).hide();
    $(divAuxiliar).hide();
};

var mostrarFormularioCadastroProcessos = function () {
    $(divListaProcessosCadastrados).hide();
    $(divGerenciaProcessoCompra).show();
    $(divPesquisaPedidos).hide();
    $(divAuxiliar).hide();
};

var mostrarFormularioPesquisaPedidos = function () {
    $(divListaProcessosCadastrados).hide();
    $(divGerenciaProcessoCompra).hide();
    $(divPesquisaPedidos).show();
    $(divAuxiliar).hide();
};

var mostrarDivAuxiliar = function () {
    $(divProcessoCompras).hide();
//    $(divGerenciaProcessoCompra).hide();
//    $(divPesquisaPedidos).hide();
    $(divAuxiliar).show();
};

var fecharDivAuxiliar = function () {
    $(divProcessoCompras).show();
    $(divAuxiliar).hide();
};



var montarArrayListaLotes = function (listaLotes) {
    arrayLoteProcessoCompra = [];
    $(listaLotes).each(function () {
        var loteProcessoCompra = $(this)[0];
        incluirLoteNoArrayLoteProcessoCompra(loteProcessoCompra);
    });
};

var montarArrayListaItensProcesso = function (listaItensProcesso) {
    var arrayItemProcesso = [];
    $(listaItensProcesso).each(function () {
        var itemProcesso = $(this)[0];
        arrayItemProcesso.push(incluirItemNoArrayItemProcesso(itemProcesso));

    });

    return arrayItemProcesso;
};

var incluirLoteNoArrayLoteProcessoCompra = function (loteProcdessoCompra) {
    var listaItemProcessoCompra = montarArrayListaItensProcesso(loteProcdessoCompra.listaItemProcessoCompra);
    var loteProcessoCompra = {id: loteProcdessoCompra.id, numero: loteProcdessoCompra.numero, processoCompraId: loteProcdessoCompra.processoCompraId, modalidadeId: loteProcdessoCompra.modalidadeId, listaItemProcessoCompra: listaItemProcessoCompra};
    arrayLoteProcessoCompra.push(loteProcessoCompra);

};

var incluirItemNoArrayItemPedido = function (itemPedido) {
    arrayItemPedido.push({pedidoId: itemPedido.pedidoId, itemId: itemPedido.itemId, item: itemPedido.item, grupoId: itemPedido.grupoId, naturezaDespesaId: itemPedido.naturezaDespesaId, quantidade: itemPedido.quantidade});
};

var formatarItemProcesso = function (itemPedido) {
    var itemProcesso = {processoCompraId: $("#id").val(), loteId: $("#loteId").val(), modalidadeId: $("#selectModalidade").val(), pedidoId: itemPedido.pedidoId, grupoId: itemPedido.grupoId, naturezaDespesaId: itemPedido.naturezaDespesaId, itemId: itemPedido.itemId, item: itemPedido.item, quantidade: itemPedido.quantidade};
    arrayLoteProcessoCompra[0].listaItemProcessoCompra.push(incluirItemNoArrayItemProcesso(itemProcesso));
};

var incluirItemNoArrayItemProcesso = function (itemProcesso) {
    return {processoCompraId: itemProcesso.processoCompraId, loteId: itemProcesso.loteId, modalidadeId: itemProcesso.modalidadeId, pedidoId: itemProcesso.pedidoId, grupoId: itemProcesso.grupoId, naturezaDespesaId: itemProcesso.naturezaDespesaId, itemId: itemProcesso.itemId, item: itemProcesso.item, quantidade: itemProcesso.quantidade};
};

var verificaSeJaExiste = function (processoCompraId, itemPedido) {
    var incluido = false;
    $(arrayLoteProcessoCompra[0].listaItemProcessoCompra).each(function () {
        var itemProcesso = $(this)[0];
        if (
                itemProcesso.processoCompraId === processoCompraId &&
                itemProcesso.itemId === itemPedido.itemId &&
                itemProcesso.pedidoId === itemPedido.pedidoId
                ) {
            incluido = true;
        }
    });
    return incluido;
};



//var limparTabela = function (tbody) {
//    $(tbody).children().remove();
//};

var listarModalidade = function () {
    var url = $("#urlModalidade").val();
    var parametros = {opcao: "listar"};
    requisicaoAjax(url, parametros, function (retornoListarModalidade) {
        if (retornoListarModalidade.estado === "sucesso") {
            montarSelectModalidade(retornoListarModalidade.dados)
        }
    });
};

var montarSelectModalidade = function (listaModalidade) {
    $(selecModalidade).children().remove();
    $(listaModalidade).each(function () {
        var modalidade = $(this)[0];
        var option = criarOption(modalidade.id, modalidade.nome, false);//valor, texto, selected
        $(selecModalidade).append(option);
    });
};

var listarProcessosCadastrados = function () {
    var url = $("#url").val();
    var parametros = {opcao: "listar"};
    requisicaoAjax(url, parametros, function (retornoListarProcessosCadastrados) {
        if (retornoListarProcessosCadastrados.estado === "sucesso") {
            montarTabelaProcessosCadastrados(retornoListarProcessosCadastrados.dados);
        }
    });
};



var montarTabelaProcessosCadastrados = function (listaProcessosCadastrados) {
    var listaProcessosCadastrados = listaProcessosCadastrados;
    var tbody = $(tabelaProcessosCadastrados).children("tbody");
    limparTabela(tbody);
    $(listaProcessosCadastrados).each(function () {
        var processoCadastrado = $(this)[0];
//        console.log(processoCadastrado);
        var tdNumeroProcesso = $("<td>").append(processoCadastrado.numero).addClass("tdNumeroProcesso");
        var tdDataProcesso = $("<td>").append(processoCadastrado.dataAbertura).addClass("tdDataProcesso");
        var tdResponsavelProcesso = $("<td>").append(processoCadastrado.responsavelClass.nome).addClass("tdResponsavelProcesso");
        var tdModalidadeProcesso = $("<td>").append(processoCadastrado.modalidade.nome).addClass("tdModalidadeProcesso");
        var tdSituacaoProcesso = $("<td>").append(processoCadastrado.situacao.situacao).addClass("tdSituacaoProcesso");

//      var spanSituacaoProcesso = (processoCadastrado.consolidado === "1") ? criarSpanProcessoConsolidado(processoCadastrado) : criarSpanProcessoAberto(processoCadastrado);
        var spanSituacaoProcesso = verificaSituacaoProcesso(processoCadastrado);

        var tdBotoesProcesso = $("<td>").append(spanSituacaoProcesso).addClass("tdBotoesProcesso");

        var tr = $("<tr>").append([tdNumeroProcesso, tdDataProcesso, tdResponsavelProcesso, tdModalidadeProcesso, tdSituacaoProcesso, tdBotoesProcesso]);
        $(tbody).append(tr);

        $(tdNumeroProcesso).click(function () {
            detalharProcessoCompra(processoCadastrado);
        });
    });

};

var verificaSituacaoProcesso = function (processo) {
    if (processo.bloqueado === "0") {
        return criarSpanProcessoAberto(processo);
    }

    if (processo.bloqueado === "1" && processo.consolidado === "0") {
        return criarSpanProcessoBloqueado(processo);
    }

    if (processo.consolidado === "1") {
        return criarSpanProcessoConsolidado(processo);
    }
};


var criarSpanProcessoAberto = function (processoCadastrado) {
    var span = $("<span>").addClass("spanProcessoAberto");

    var botaoExcluirProcesso = criarButton("", "button", "", "Excluir", "botaoExcluir", function () {
        excluirProcesso(processoCadastrado);
    });

    var botaoFecharItemProcesso = criarButton("", "button", "", "Fechar Item", "botaoFecharItem", function () {
        bloquearProcesso(processoCadastrado, 1);
        inicializar();
    });

    $(span).append([botaoFecharItemProcesso, botaoExcluirProcesso]);
    return span;
};

var criarSpanProcessoBloqueado = function (processoCadastrado) {
    var span = $("<span>").addClass("spanProcessoBloqueado");

    var botaoRegistrarProposta = criarButton("", "button", "", "Propostas", "botaoProposta", function () {
        registrarPropostas(processoCadastrado);
    });

    var botaoImprimirDocumentos = criarButton("", "button", "", "Documentos", "botaoImprimir", function () {
        imprimirDocumentosProcesso(processoCadastrado);
    });

    var botaoAbrirItem = criarButton("", "button", "", "Abrir Item", "botaoAbrirItem", function () {
        bloquearProcesso(processoCadastrado, 0);
        inicializar();
    });

    var botaoConsolidarProcesso = criarButton("", "button", "", "Consolidar", "botaoConsolidar", function () {
        consolidarProcesso(processoCadastrado);
        inicializar();
    });

    var botaoPreEmpenho = criarButton("", "button", "", "Pré-Empenho", "botaoImprimir", function () {
        imprimirPreEmpenho(processoCadastrado);
//        consolidarProcesso(processoCadastrado);
//        inicializar();
    });

    $(span).append([botaoConsolidarProcesso, botaoRegistrarProposta, botaoImprimirDocumentos, botaoAbrirItem, botaoPreEmpenho]);

    return span;
};

var criarSpanProcessoConsolidado = function (processoCadastrado) {
    var span = $("<span>").addClass("spanProcessoConsolidado");

    var botaoImprimirDocumentos = criarButton("", "button", "", "Documentos", "botaoImprimir", function () {
        imprimirDocumentosProcesso(processoCadastrado);
    });

    var botaoEmitirOrdemDeCompra = criarButton("", "button", "", "OCS", "", function () {
        emitirOrdemDeCompra(processoCadastrado);
    });
    
    var botaoExcluirProcesso = criarButton("", "button", "", "Excluir", "botaoExcluir", function () {
        excluirProcesso(processoCadastrado);
    });
    
    $(span).append([botaoImprimirDocumentos, botaoEmitirOrdemDeCompra, botaoExcluirProcesso]);

    return span;
};

var emitirOrdemDeCompra = function (processoCompra) {
    mostrarDivAuxiliar();
    processoCompraGlobal = processoCompra;
    $(divEmitirOrdemDecompra).load("formEmitirOrdemDeCompra.html", function () {
        $(this).before(function () {
            $(this).find("#processoCompraId").val(processoCompra.id);
            $(this).find("#botaoInicializar").click();
        });

    });
};

var imprimirDocumentosProcesso = function (processoCompra) {
    window.open("impressaoDocumentosProcessoCompra.php?processoCompraId=" + processoCompra.id);
};

var imprimirPreEmpenho = function (processoCompra) {
    window.open("imprimirPreEmpenho.php?processoCompraId=" + processoCompra.id);
};

var excluirProcesso = function (processoCompra) {
    var opcao = "excluir";
    var id = processoCompra.id;
    var parametros = {opcao: opcao, id: id};
    var url = $("#url").val();
    if (confirm("Deseja excluir o processo: " + processoCompra.numero)) {
        requisicaoAjax(url, parametros, function (retornoExcluirProcesso) {
            exibirMensagem(retornoExcluirProcesso.estado, retornoExcluirProcesso.mensagem);
            inicializar();
        });
    }
};

var bloquearProcesso = function (processoCompra, bloqueado) {
    var opcao = "bloquear";
    var id = processoCompra.id;
    var modalidadeId = processoCompra.modalidadeId;
    var responsavel = processoCompra.responsavel;
    var parametros = {opcao: opcao, id: id, bloqueado: bloqueado, modalidadeId: modalidadeId, responsavel: responsavel};
    var url = $("#url").val();

    requisicaoAjax(url, parametros, function (retornoBloquearProcesso) {
        exibirMensagem(retornoBloquearProcesso.estado, retornoBloquearProcesso.mensagem);
        if (retornoBloquearProcesso.estado === "sucesso") {
            detalharProcessoCompra(retornoBloquearProcesso.dados);
        }
    });
};

var consolidarProcesso = function (processoCompra) {
    var opcao = "consolidar";
    var id = processoCompra.id;
    var modalidadeId = processoCompra.modalidadeId;
    var responsavel = processoCompra.responsavel;
    var parametros = {opcao: opcao, id: id, modalidadeId: modalidadeId, responsavel: responsavel};
    var url = $("#url").val();
    if (confirm("Atenção!\nApós consolidar o processo não será mais possível alterá-lo!\nDeseja continuar?")) {
        requisicaoAjax(url, parametros, function (retornoConsolidarProcesso) {
            console.log(retornoConsolidarProcesso.mensagem);
            exibirMensagem(retornoConsolidarProcesso.estado, retornoConsolidarProcesso.mensagem);
            if (retornoConsolidarProcesso.estado === "sucesso") {
                detalharProcessoCompra(retornoConsolidarProcesso.dados);
            }
        });
    }
};

var detalharProcessoCompra = function (processoCompra) {
    processoCompraGlobal = processoCompra;
    prepararFormularioCadastroProcessoCompra();
    setOpcao(formGerenciarProcessoCompra, "alterar");
    $("#id").val(processoCompra.id);
    $("#matriculaResponsavel").val(processoCompra.responsavelClass.matricula);
    $("#numero").val(processoCompra.numero);
    $("#numeroModalidade").val(processoCompra.numeroModalidade);
    $("#objeto").val(processoCompra.objeto);
    $("#justificativa").val(processoCompra.justificativa);
    var loteId = processoCompra.listaLoteProcessoCompra[0].id;
    $("#loteId").val(loteId);
    $("#consolidado").val(processoCompra.consolidado);
    $("#bloqueado").val(processoCompra.bloqueado);
    $("#encerrado").val(processoCompra.encerrado);

    setSelected(selecModalidade.children(), processoCompra.modalidadeId);

    montarArrayListaLotes(processoCompra.listaLoteProcessoCompra);
    montarTabelasLotes();
    verificarProcessoAberto();
};

var montarTabelasLotes = function () {
    indiceOrdenador = 1;
    $(divTabelasLotes).children().remove();
    $(arrayLoteProcessoCompra).each(function () {
        var loteProcessoCompra = $(this)[0];
        var tabela = montarTabelaItemProcesso(loteProcessoCompra);
        $(divTabelasLotes).append(tabela);
    });
    verificarProcessoAberto();
};

var montarTabelaItemProcesso = function (loteProcessoCompra) {
    if (loteProcessoCompra.listaItemProcessoCompra.length > 0) {
        var tabela = $("<table>").addClass("tabelaItemProcesso table table-striped table-bordered");
        var thead = cabecalhoTabelaItemProcesso();
        if (loteProcessoCompra.numero > 0) {
            $(thead).children(".thTituloTabela").text("Grupo " + loteProcessoCompra.numero);
        }
        
        $(tabela.append(thead));
        var tbody = $("<tbody>").appendTo(tabela);
        limparTabela(tbody);
//        var numeroItemProcesso = 1;

        $(loteProcessoCompra.listaItemProcessoCompra).each(function () {


            var itemProcesso = $(this)[0];
            var tdNumeroItemProcesso = $("<td>").append(indiceOrdenador).addClass("tdNumeroItemProcesso text-center");
            var tdCodigoItemProcesso = $("<td>").append(itemProcesso.item.codigo).addClass("tdCodigoItemProcesso text-center");
            var tdDescricaoItemProcesso = $("<td>").append(itemProcesso.item.descricao).addClass("tdDescricaoItemProcesso");
            var tdQuantidadeItemProcesso = $("<td>").append(itemProcesso.quantidade).addClass("tdQuantidadeItemProcesso text-center");

            var botaoExcluir;
            if (loteProcessoCompra.numero > 0) {
                botaoExcluir = criarButton("", "button", "", "Remover", "botaoRemover botoesProcessoAberto", function () {
                    removerItemDoLote(itemProcesso, loteProcessoCompra.listaItemProcessoCompra);
                });
            } else {
                botaoExcluir = criarButton("", "button", "", "Remover", "botaoRemover botoesProcessoAberto", function () {
                    excluirItemProcesso(itemProcesso);
                });
            }

            var tdBotao = $("<td>").append(botaoExcluir).addClass("tdBotaoItemProcesso");

            var tr = $("<tr>").append([tdNumeroItemProcesso, tdCodigoItemProcesso, tdDescricaoItemProcesso, tdQuantidadeItemProcesso, tdBotao]);

            $(tbody).append(tr);

//            numeroItemProcesso++;
            indiceOrdenador++;
        });
        return tabela;
    }
};

var cabecalhoTabelaItemProcesso = function () {
    var thTituloTabela = $("<th>").addClass("thTituloTabela");
    $(thTituloTabela).attr({colspan: 2});
    var thNumeroItemProcesso = $("<th>").append("Item").addClass("thNumeroItemProcesso text-center");
    var thCodigoItem = $("<th>").append("Código").addClass("thCodigoItemProcesso text-center");
    var thDescricaoItem = $("<th>").append("Descrição").addClass("thDescricaoItemProcesso");
    var thQuantidadeItem = $("<th>").append("Quantidade").addClass("thQuantidadeItemProcesso text-center");
    var thBotoesItem = $("<th>").addClass("thBotoesItemProcesso");
    var thead = $("<thead>");
    $(thead).append("<tr>").append(thTituloTabela);
    $(thead).append("<tr>").append([thNumeroItemProcesso, thCodigoItem, thDescricaoItem, thQuantidadeItem, thBotoesItem]);

    return thead;
};


var verificarProcessoAberto = function () {
    if ($("#consolidado").val() === "0") { //PROCESSO ABERTO
        $(".botoesProcessoAberto").show();
        $(".botoesProcessoConsolidado").hide();
        $(".botoesProcessoBloqueado").hide();
    }

    if ($("#bloqueado").val() === "1" && $("#consolidado").val() === "0") { //PROCESSO BLOQUEADO
        $(".botoesProcessoAberto").hide();
        $(".botoesProcessoBloqueado").show();
        $(".botoesProcessoConsolidado").hide();
    }

    if ($("#consolidado").val() === "1") { //PROCESSO CONSOLIDADO
        $(".botoesProcessoAberto").hide();
        $(".botoesProcessoBloqueado").hide();
        $(".botoesProcessoConsolidado").show();
    }

};

var excluirItemProcesso = function (itemProcesso) {
    var indice = arrayLoteProcessoCompra[0].listaItemProcessoCompra.indexOf(itemProcesso);
    arrayLoteProcessoCompra[0].listaItemProcessoCompra.splice(indice, 1);
    salvarItemProcessoCompra(itemProcesso, "excluir");
};

var removerItemDoLote = function (itemProcesso, loteProcessoCompra) {
    var indice = loteProcessoCompra.indexOf(itemProcesso);
    loteProcessoCompra.splice(indice, 1);

    var parametros = {opcao: "removerItemDoLote", loteId: arrayLoteProcessoCompra[0].id, id: itemProcesso.processoCompraId, itemId: itemProcesso.itemId};
    requisicaoAjax($("#url").val(), parametros, function (retornoRemoverItemDoLote) {
        if (retornoRemoverItemDoLote.estado === "sucesso") {

            detalharProcessoCompra(retornoRemoverItemDoLote.dados);
        }
    });
};


var prepararFormularioCadastroProcessoCompra = function () {
    limparFormulario(formGerenciarProcessoCompra);
    limparFormulario(formPesquisaPedido);
    $(divTabelasLotes).children().remove();
    $("#matriculaResponsavel").val(UsusarioLogado.matricula);
    listarModalidade();
    mostrarFormularioCadastroProcessos();
};

var prepararFormularioPesquisaPedido = function () {
//    limparFormulario(formPesquisaPedido);
    $(formPesquisaPedido).find("#anoPedido").val(SistemaLogado.anoSistema);
    limparTabela($(tabelaListaIntesPedido).children("tbody"));
};




var inicializar = function () {
    prepararFormularioCadastroProcessoCompra();
    listarProcessosCadastrados();
    mostrarProcessosCadastrados();
};

var fecharFormularioCadastro = function () {
    limparTabela($(tabelaItemProcesso).children("tbody"));
    $(selecModalidade).children().remove();
};

var pesquisarPedido = function () {
    var opcao = "buscarPedidoRecebidoPorNumeroAno";
    var numeroPedido = $("#numeroPedido").val();
    var anoPedido = $("#anoPedido").val();
    var parametros = {opcao: opcao, numero: numeroPedido, ano: anoPedido};
    var url = $("#urlPedido").val();
    requisicaoAjax(url, parametros, function (retornoPesquisarPedido) {
        arrayItemPedido.splice(0, arrayItemPedido.length);
        if (retornoPesquisarPedido.estado === "sucesso") {
            montarTabelaItemPedido(retornoPesquisarPedido.dados.pedido);
        }
    });
};

var montarTabelaItemPedido = function (pedido) {
    var tbody = $(tabelaListaIntesPedido).children("tbody");
    var listaItemPedido = pedido.listaItemPedido;
    limparTabela(tbody);
    $(listaItemPedido).each(function () {
        var itemPedido = $(this)[0];
        incluirItemNoArrayItemPedido(itemPedido);

        var checkbox = criarCheckbox("", "", itemPedido.itemId, false);
        $(checkbox).addClass("itemPedidoSelecionado");
        var tdSelect = $("<td>").addClass("tdSelectItemPesquisa");
        var tdCodigoItemPedido = $("<td>").append(itemPedido.item.codigo).addClass("tdCodigoItemPesquisa");
        var tdDescricaoItemPedido = $("<td>").append(itemPedido.item.descricao).addClass("tdDescricaoItemPesquisa");
        var tdQuantidadeItemPedido = $("<td>").append(itemPedido.quantidade).addClass("tdQuantidadeItemPesquisa");

        if (!buscarItemJaCadastrado(itemPedido)) {
            $(tdSelect).append(checkbox);
            var botaoIncluirItem = criarButton("", "button", "", "Incluir", "botaoSelecionar", function () {
                incluirItemPedidoNoProcesso(itemPedido);
                exibirMensagem();
                $(tr).remove();
            });
        }
        var tdIncluirItem = $("<td>").append(botaoIncluirItem).addClass("tdBotoesItemPesquisa");

        var tr = $("<tr>").append([tdSelect, tdCodigoItemPedido, tdDescricaoItemPedido, tdQuantidadeItemPedido, tdIncluirItem]);
        $(tbody).append(tr);

    });
};

var buscarItemJaCadastrado = function (itemPedido) {
    var opcao = 'buscarItemJaCadastrado';
    var urlItemPedido = $("#urlItemProcessoCompra").val();
    var parametros = {opcao: opcao, pedidoId: itemPedido.pedidoId, itemId: itemPedido.itemId};
    var itemCadastrado = false;
    requisicaoAjax(urlItemPedido, parametros, function (retorno) {
        (retorno) ? itemCadastrado = true : itemCadastrado = false;
    });
    return itemCadastrado;
};

var incluirItemPedidoNoProcesso = function (itemPedido) {

    formatarItemProcesso(itemPedido);
    salvarItemProcessoCompra(itemPedido, "inserir");

    /*
     if (verificaSeJaExiste($("#id").val(), itemPedido)) {
     exibirAlerta("ERRO", "Item já incluso");
     return false;
     
     } else {
     formatarItemProcesso(itemPedido);
     salvarItemProcessoCompra(itemPedido, "inserir");
     exibirMensagem("sucesso", "Item incluído com sucesso");
     return true;
     
     }
     */

};

var selecionarTodosItensPedido = function () {
    var checked = $("#selecionarTodos").prop("checked");
    $(".itemPedidoSelecionado").prop({checked: checked});
};

var incluirItensSelecionados = function () {
    var itensSelecionados = $(".itemPedidoSelecionado:checked");
    $(itensSelecionados).each(function () {
        var botaoIncluir = $(this).parents("tr");
        $(botaoIncluir).find(".botaoSelecionar").click();
    });
};

//
//var limparTabela = function (tbody) {
//    $(tbody).children().remove();
//};

var voltar = function () {
    prepararFormularioPesquisaPedido();
//    montarTabelaItemProcesso();
    montarTabelasLotes();
    mostrarFormularioCadastroProcessos();
};

var salvarProcessoCompra = function () {
    submeterFormulario(formGerenciarProcessoCompra, function (retornoSalvarProcesso) {
        exibirMensagem(retornoSalvarProcesso.estado, retornoSalvarProcesso.mensagem);
        if (retornoSalvarProcesso.estado === "sucesso") {
            detalharProcessoCompra(retornoSalvarProcesso.dados);
//                salvarItemProcessoCompra();
        }

    });
};

var salvarItemProcessoCompra = function (itemProcesso, opcaoSalvar) {

    var processoCompraId = $("#id").val();
    var loteId = $("#loteId").val();
    var modalidadeId = $("#selectModalidade").val();
    var parametros = {opcao: opcaoSalvar, loteId: loteId, processoCompraId: processoCompraId, modalidadeId: modalidadeId, pedidoId: itemProcesso.pedidoId, grupoId: itemProcesso.grupoId, naturezaDespesaId: itemProcesso.naturezaDespesaId, itemId: itemProcesso.itemId, quantidade:itemProcesso.quantidade};
    var url = $("#urlItemProcessoCompra").val();
    requisicaoAjax(url, parametros, function (retornoSalvarItemProcesso) {
        montarTabelasLotes();
    });
};

var buscarProcessoConsolidado = function (processoCompraConsolidado) {
    var opcao = "buscarPorId";
    var id = processoCompraConsolidado.id;
    var url = $("#url").val();
    var parametros = {opcao: opcao, id: id};
    requisicaoAjax(url, parametros, function (retornoBuscaProcesso) {
        detalharProcessoCompra(retornoBuscaProcesso.dados);
    });
};

var fechar = function () {
    fecharFormularioCadastro();
    inicializar();
};

var registrarPropostas = function (processoCompra) {
    mostrarDivAuxiliar();
    processoCompraGlobal = processoCompra;
    $(divRegistrarProposta).load("formRegistrarProposta.html", function () {
        registrarNovaProposta(processoCompra.id, processoCompra.modalidadeId, processoCompra.listaLoteProcessoCompra);
    });
};


$(document).ready(function () {

    inicializar();

    $(formGerenciarProcessoCompra).submit(function (event) {
        event.preventDefault();
        salvarProcessoCompra();
    });

    $(formPesquisaPedido).submit(function (event) {
        event.preventDefault();
        pesquisarPedido();
    });


    $("#botaoNovoProcesso").click(function () {
        prepararFormularioCadastroProcessoCompra();
        verificarProcessoAberto();
        $("#numero").focus();
    });

    $("#botaoVoltar").click(function () {
        fechar();
    });

    $("#botaoAddItem").click(function () {
        prepararFormularioPesquisaPedido();
        salvarProcessoCompra();
        mostrarFormularioPesquisaPedidos();
    });

    $("#botaoFecharItem").click(function () {
        bloquearProcesso(processoCompraGlobal, 1);
    });

    $("#botaoAbrirItem").click(function () {
        bloquearProcesso(processoCompraGlobal, 0);
    });

    $("#botaoConsolidar").click(function () {
        consolidarProcesso(processoCompraGlobal);
    });

    $("#selecionarTodos").click(function () {
        selecionarTodosItensPedido();
    });

    $("#incluirSelecionados").click(function () {
        incluirItensSelecionados();
        $("#selecionarTodos").attr({checked: false});
    });

    $("#botaoFecharFormularioPesquisa").click(function () {
        voltar();
    });

    $("#botaoGerenciarLote").click(function () {
        mostrarDivAuxiliar();
        $(divGerenciarLote).load("formGerenciarLotes.html", function () {
            gerenciarLotes(processoCompraGlobal);
        });
    });

    $("#botaoExcluir").click(function () {
        excluirProcesso(processoCompraGlobal);
    });

    $("#botaoProposta").click(function () {
        registrarPropostas(processoCompraGlobal);
    });

    $(".botaoImprimir").click(function () {
        imprimirDocumentosProcesso(processoCompraGlobal);
    });

    $("#dataInicio").datepicker(calendario());
    $("#dataFim").datepicker(calendario());
});