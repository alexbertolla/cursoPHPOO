$(document).ready(function () {
    
    $(document).on("click", ".alert", function(e) {
        bootbox.dialog({
            message: "I am a custom dialog",
            title: "Custom title",
            buttons: {
              success: {
                label: "Success!",
                className: "btn-success",
                callback: function() {
                  alert("success:");
                  console.log(e);
                }
              },
              main: {
                label: "Click ME!",
                className: "btn-primary",
                callback: function() {
                  alert("main:");
                  console.log(e);
                }
              }
            }
          });
    });
    
    var divPedidosCadastrados = $("#divPedidosCadastrados");
    var formPedidoCompra = $("#formPedidoCompra");
    var formPesquisaItem = $("#formPesquisaItem");
    var divInfoPedido = $("#divInfoPedido");
    var divItens = $("#divItens");
    var divAuxiliarPedido = $("#divAuxiliarPedido");
    var divPedidoAtividade = $("#divPedidoAtividade");

    var tabelaItensPedido = $("#tabelaItensPedido");

    var spanPedidoAberto = $(".spanPedidoAberto");
    var spanPedidoFechado = $(".spanPedidoFechado");

    var grupoId = 0;
    var lotacaoId = 0;
    var pedidoBloqueado;

    var arrayItensCadastrados = [];
    var arrayItensPedido = [];
    var listaGrupo = [];

    var pedidoSalvo = false;

    var incluirItemCadastrado = function (item) {
        arrayItensCadastrados.push({id: item.id, codigo: item.codigo, nome: item.nome, descricao: item.descricao, grupoId: item.grupoId});
    };
    var incluirItemPedido = function (item, quantidade, pedidoId, naturezaDespesaId) {
        arrayItensPedido.push({itemId: item.id, codigo: item.codigo, nome: item.nome, descricao: item.descricao, grupoId: item.grupoId, quantidade: quantidade, pedidoId: pedidoId, naturezaDespesaId: naturezaDespesaId});
    };


    var limparListaItensCadastrados = function () {
        arrayItensCadastrados.splice(0, arrayItensCadastrados.length);

        montarListaItensCadastrados(arrayItensCadastrados);
    };

    var limparListaItensPedido = function () {
        arrayItensPedido.splice(0, arrayItensPedido.length);
        montarTabelaItensPedido()
    };

    var listarPA = function () {
        var parametros = {opcao: "listarPA", ano: $("#ano").val()};
        var url = $("#urlPA").val();
        return requisicaoAjax(url, parametros, function (retornoListarPA) {
            if (retornoListarPA.estado === "sucesso") {
                montarListaPA(retornoListarPA.dados);
            }
        });
    };

    var montarListaPA = function (listaPA) {
        var dataListPA = $("#dataListPA");
        dataListPA.children().remove();
        $(listaPA).each(function () {
            var pa = $(this)[0];
            var options = criarOption(pa.codigo, pa.codigo + " -> " + pa.titulo, false);
            $(options).attr({id: pa.id});
            $(dataListPA).append(options);
        });
    };

    var buscarPaSaldoPorId = function (paId) {
        var opcao = "buscarPaSaldoPorId";
        var parametro = {opcao: opcao, id: paId, ano: $("#ano").val()};
        var url = $("#urlPA").val();
        requisicaoAjax(url, parametro, function (retornoDadosPA) {
            $("#codigoPA").val(retornoDadosPA.dados.codigo);
//            buscarInfoPA(retornoDadosPA.dados.codigo);
            retornoBuscaInfoPA(retornoDadosPA);
        });
    };

    var buscarInfoPA = function () {
        var opcao = "buscarInfoPA";
        var ano = $("#ano").val();
        var codigoPA = $("#codigoPA").val();
        var parametro = {opcao: opcao, codigoPA: codigoPA, ano: ano};
        var url = $("#urlPA").val();
        requisicaoAjax(url, parametro, retornoBuscaInfoPA);
    };

    var retornoBuscaInfoPA = function (retornoPA) {
        if (retornoPA.estado === "sucesso") {
            if (retornoPA.dados.id === null) {
                bootbox.alert("Plano de Ação " + $("#codigoPA").val() + " não encontrado.", function() {});
                mostraInfoPA(retornoPA.dados);
            } else {
                mostraInfoPA(retornoPA.dados);
            }
        }
    };

    var mostraInfoPA = function (pa) {
        $("#idPa").val(pa.id);
        $("#spanCodigo").text(pa.codigo);
        $("#spanTitulo").text(pa.titulo);
        $("#spanResponsavel").text(pa.responsavel);
        $("#spanSaldoCusteio").text(pa.saldoCusteio);
        $("#spanSaldoInvestimento").text(pa.saldoInvestimento);
        $("#infoPA table tbody").show();
    };
    
    var removerInfoPA = function () {
        $("#idPa").val("");
        $("#spanCodigo").text("");
        $("#spanTitulo").text("");
        $("#spanResponsavel").text("");
        $("#spanSaldoCusteio").text("");
        $("#spanSaldoInvestimento").text("");
        $("#infoPA table tbody").hide();
    };

    var listarGrupo = function () {
        var opcao = "listarAtivos";
        var parametros = {opcao: opcao};
        var url = $("#urlGrupo").val();
        requisicaoAjax(url, parametros, retornoListarGrupo);
    };

    var retornoListarGrupo = function (retornoAjax) {
        if (retornoAjax.estado === "sucesso") {
            listaGrupo = retornoAjax.dados;
            montarSelectGrupo();
        }
    };

    var montarSelectGrupo = function () {
        var select = $("#selectGrupo");
        $(select).children().remove();
        $(select).append(criarOption("", "Selecione um grupo", true));
        $(listaGrupo).each(function () {
            var grupo = $(this)[0];
            var option = criarOption(grupo.id, grupo.codigo + " - " + grupo.nome, false);//valor, texto, selected
            $(select).append(option);
        });
        setSelected($(select).children(), grupoId);
    };


    var listarLotacao = function () {
        var opcao = "listar";
        var parametros = {opcao: opcao};
        var url = $("#urlLotacao").val();
        requisicaoAjax(url, parametros, function (retornoAjax) {
            if (retornoAjax.estado === "sucesso") {
                montarSelectLotacao(retornoAjax.dados);
            }
        });
    };


    var montarSelectLotacao = function (listaLotacao) {
        var select = $("#selectLotacao");
        $(select).children().remove();
        $(listaLotacao).each(function () {
            var lotacao = $(this)[0];
            var option = criarOption(lotacao.id, lotacao.nome + " - " + lotacao.sigla, false);//valor, texto, selected
            $(select).append(option);
        });
        setSelected($(select).children(), lotacaoId);
    };


    var limparArraysItens = function () {
        limparListaItensCadastrados();
        limparListaItensPedido();
    };

    var prepararFormulario = function () {
        limparArraysItens();
        limparFormulario(formPedidoCompra);
        $("#matriculaSolicitante").val(UsusarioLogado.matricula);
        $("#ano").val(SistemaLogado.anoSistema);
        listarPA();
        listarGrupo();
        listarLotacao();
        bloquearSelectGrupo(false);

    };

    var verificaPedidoBloqueado = function (pedidoBloqueado) {
//        var pedidoBloqueado = $("#pedidoBloqueado").val();
        if (pedidoBloqueado === "0") {
            $(spanPedidoAberto).show();
            $(spanPedidoFechado).hide();
        } else {
            $(spanPedidoAberto).hide();
            $(spanPedidoFechado).show();
        }

    };
    var mostrarPedidosCadastrados = function () {
        $(divPedidosCadastrados).show();
        $(divInfoPedido).hide();
        $(divItens).hide();
        $(divAuxiliarPedido).hide();
    };

    var mostrarInfoPedido = function () {
        $(divPedidosCadastrados).hide();
        $(divInfoPedido).show();
        $(divItens).hide();
        $(divAuxiliarPedido).hide();
    };



    var mostrarItensPedido = function () {
        $(divItens).show();
        $(divInfoPedido).hide();
        $(divAuxiliarPedido).hide();
    };

    var mostrarDivAuxiliarPedido = function () {
        $("#divPedidoDeCompra").hide();
        $(divAuxiliarPedido).show();
    };

    var fecharDivAuxiliarPedido = function () {
        $("#divPedidoDeCompra").show();
        $(divAuxiliarPedido).hide();
    };


    var novoPedido = function () {
        prepararFormulario();
    };

    var getTipoGrupo = function () {
        var selecionado = $("#selectGrupo :selected");
        var index = $(selecionado).index() - 1;
        var grupo = listaGrupo[index];
        $("#tipo").val(grupo.tipo);
        $("#naturezaDespesaId").val(grupo.naturezaDespesaId);
        $("#grupoId").val(grupo.id);
        setUrlItem(grupo.tipo);
    };


    var setUrlItem = function (tipo) {
        var urlItem;
        switch (tipo) {
            case "materialConsumo":
                urlItem = "../servlets/cadastros/ServletMaterialConsumo.php";
                break;
            case "materialPermanente":
                urlItem = "../servlets/cadastros/ServletMaterialPermanente.php";
                break;
            case "servico":
                urlItem = "../servlets/cadastros/ServletServico.php";
                break;
            case "obra":
                urlItem = "../servlets/cadastros/ServletObra.php";
                break;
        }
        $("#urlItem").val(urlItem);
    };


    var pesquisarItensCompra = function () {
        var tipo = $("#tipo").val();

        var parametros = {opcao: "listarPorNomeDescricaoOuCodigoEGrupoAtivo", nome: $("#txtPesquisaItem").val(), tipo: tipo, grupoId: grupoId};
        var url = $("#urlItem").val();
        return requisicaoAjax(url, parametros, function (retornoLista) {
            if (retornoLista.estado === "sucesso" && $(retornoLista.dados).length > 0) {
                montarListaItensCadastrados(retornoLista.dados);
//                console.log(retornoLista.dados);
            } else {
                exibirAlerta("ERRO", "Nenhum item encontrado para este grupo");
            }

        });
    };

    var montarListaItensCadastrados = function (listaItens) {
        var tabela = $("#tabelaListaIntesCadastrados");
        var tbody = $(tabela).children("tbody");
        $(tbody).children().remove();
        arrayItensCadastrados.splice(0, arrayItensCadastrados.length);
        $(listaItens).each(function () {
            var item = $(this)[0];
            console.log(item);
            incluirItemCadastrado(item);

            var check = criarCheckbox("", "", item.id, false);//id, nome, valor, checked
            $(check).addClass("checkBoxItens");

            var tdSelecionar = $("<td>").append(check).addClass("tdSelecionarItemPesquisa");
            var tdCodigo = $("<td>").append(item.codigo).addClass("tdCodigoItemPesquisa");
//            var tdNomeItem = $("<td>").append(item.nome).addClass("tdNomeItem");
            var tdDescricaoItem = $("<td>").append(item.descricao).addClass("tdNomeDescricaoItemPesquisa");

            var botaoIncluirItem = criarButton("", "button", "", "Incluir", "botaoSelecionar btn btn-default", function () {
                incluirItemNoPedido(item);
                $(tr).remove();
            });

            var tdIncluirItem = $("<td>").append(botaoIncluirItem).addClass("tdBotoesItemPesquisa");

            var tr = $("<tr>").append([tdSelecionar, tdCodigo, tdDescricaoItem, tdIncluirItem]);

            $(tbody).append(tr);
        });
    };

    var incluirItemNoPedido = function (item) {
        incluirItemPedido(item, 1, $("#id").val(), $("#naturezaDespesaId").val());
        salvarItemPedido();
        montarTabelaItensPedido();
    };

    var salvarItemPedido = function () {
        var opcao = "inserir";
        var tipo = $("#tipo").val();
        var pedidoId = $("#id").val();
        var parametro = {opcao: opcao, listaItemPedido: arrayItensPedido, tipo: tipo, pedidoId: pedidoId};
        var url = $("#urlItemPedido").val();
        requisicaoAjax(url, parametro, function (retornoItensPedido) {
        });
    };


    var salvarPedido = function () {
        submeterFormulario(formPedidoCompra, function (retornoSalvarPedido) {
            console.log(retornoSalvarPedido);
            if (retornoSalvarPedido.estado === "sucesso") {
                pedidoSalvo = true;
                setOpcao(formPedidoCompra, "alterar");
                carregarDadosFormulario(retornoSalvarPedido.dados);

            } else {
                exibirAlerta(retornoSalvarPedido.estado, retornoSalvarPedido.mensagem);
                pedidoSalvo = false;
            }
        });

    };



    var bloquearSelectGrupo = function (bloqueado) {
        $("#selectGrupo").prop({disabled: bloqueado});
    };

    var carregarDadosFormulario = function (pedido) {
        $("#id").val(pedido.id);
        $("#numero").val(pedido.numero);
        $("#grupoId").val(pedido.grupoId);
        $("#justificativa").val(pedido.justificativa);
        $("#tipo").val(pedido.tipo);
        $("#naturezaDespesaId").val(pedido.naturezaDespesaId);
        $("#pedidoBloqueado").val(pedido.bloqueado);
        pedidoBloqueado = pedido.bloqueado;


    };

    var montarTabelaItensPedido = function () {
        $("#divItensPedido").show();
        var tbody = $(tabelaItensPedido).children("tbody");
        limparTabela(tbody);
        var numero = 1;
        $(arrayItensPedido).each(function () {
            var itemPedido = $(this)[0];
            console.log(itemPedido);


            var buttonExcluir = criarButton("", "button", "", "Remover", "botaoExcluir", function () {
                removerItemPedido(arrayItensPedido.indexOf(itemPedido));
            });


            var tdNumero = $("<td>").append(numero).addClass("tdNumeroItem");
            numero++;

            var tdCodigo = $("<td>").append(itemPedido.codigo).addClass("tdCodigoItem");
            var tdDescricaoItem = $("<td>").append(itemPedido.descricao).addClass("tdDescricaoItem");
//            var spanQtd = $("<span>").append([buttonRmv, itemPedido.quantidade, buttonAdd]);

            var inputQuantidade = criarText("", "", "", "inputQuantidadeItem");
            $(inputQuantidade).val(itemPedido.quantidade);
            $(inputQuantidade).blur(function () {
                var atualizar = autalizarQuantidade(itemPedido, $(this).val());
                if (!atualizar) {
                    $(this).val(itemPedido.quantidade);
                }
            });

            var labelQuantidade = criarLabel("", "", itemPedido.quantidade, "");

            var tdQuantidadeItem = $("<td>").append(inputQuantidade).append(labelQuantidade).addClass("tdQuantidadeItem");

            var tdBotoes = $("<td>").append(buttonExcluir).addClass("tdBotoesItem");
            var tr = $("<tr>").append([tdNumero, tdCodigo, tdDescricaoItem, tdQuantidadeItem, tdBotoes]);

            if (pedidoBloqueado === "1") {
                $(inputQuantidade).hide();
                $(labelQuantidade).show();
                $(buttonExcluir).hide();
            } else {
                $(inputQuantidade).show();
                $(labelQuantidade).hide();
                $(buttonExcluir).show();
            }



            $(tbody).append(tr);
        });
        $(tabelaItensPedido).append(tbody);

    };

    var removerItemPedido = function (itemPedido) {

        arrayItensPedido.splice(itemPedido, 1);

        salvarItemPedido();
        montarTabelaItensPedido();
    };

    var autalizarQuantidade = function (itemPedido, quantidade) {
        if (isNaN(quantidade)) {
            exibirAlerta("ERRO", "Quantidade inválida");
            return  false;
        }

        if (quantidade === "0") {
            if (confirm("Quantidade igual a zero!\nDeseja remover o item?")) {
                removerItemPedido(itemPedido);
                return false;
            }
        }

        var indice = arrayItensPedido.indexOf(itemPedido);
        arrayItensPedido[indice].quantidade = quantidade;
        salvarItemPedido();
        return true;
    };



    var listarPedidosCadastrados = function () {
        var opcao = "listarPorSolicitante";
        var matriculaSolicitante = $("#usuarioLogadoMatricula").val();
        var parametro = {opcao: opcao, matriculaSolicitante: matriculaSolicitante};
        var url = $("#url").val();
        requisicaoAjax(url, parametro, function (retornoListaPedidos) {
            if (retornoListaPedidos.estado === "sucesso") {
                montarTabelaPedidosCadastrados(retornoListaPedidos.dados);
            }
        });
    };


    var montarTabelaPedidosCadastrados = function (listaPedidos) {
        var tabela = $("#tabelaPedidosCadastrados");
        var tbody = $(tabela).children("tbody");
        $(tbody).children().remove();
        $(listaPedidos).each(function () {
            var pedido = $(this)[0];
            console.log(pedido);
            var tdDataPedido = $("<td>").append(pedido.dataCriacao).addClass("tdDataPedido");
            var tdNumeroPedido = $("<td>").append(pedido.numero).addClass("tdNumeroPedido");
            var tdJustificativa = $("<td>").append(pedido.justificativa).addClass("tdJustificativaPedido");
            var tdSituacao = $("<td>").append(pedido.situacao.situacao).addClass("tdSituacaoPedido");

            $(tdNumeroPedido).click(function () {
                setAlterar(pedido);
            });

            var buttonDetalhar = criarButton("", "button", "", "Detalhar", "botaoDetalhar btn btn-default", function () {
                setAlterar(pedido);
            });

            var buttonImprimir = criarButton("", "button", "", "Imprimir", "botaoImprimir btn btn-default", function () {
                imprimirPedido(pedido.id);
            });//id, tipo, nome, titulo, classes, acao

            var buttonExcluir = criarButton("", "button", "", "Excluir", "botaoExcluir btn btn-default", function () {
                excluirPedido(pedido);
            });

            var buttonAtividade = criarButton("", "button", "", "Histórico", "botaoAtividade btn btn-default", function () {
                pedidoAtividade(pedido);
            });

            (pedido.bloqueado === "1") ? esconder(buttonExcluir) : mostrar(buttonExcluir);

            var tdBotoesPedido = $("<td>").append([buttonDetalhar, buttonImprimir, buttonExcluir, buttonAtividade]).addClass("tdBotoesPedido");
            var tr = $("<tr>").append([tdNumeroPedido, tdDataPedido, tdJustificativa, tdSituacao, tdBotoesPedido]);
            $(tbody).append(tr);
        });

    };

    var excluirPedido = function (pedido) {
        if (confirm("Deseja excluir o pedido: " + pedido.numero + "?")) {
            requisicaoAjax($("#url").val(), {opcao: "excluir", id: pedido.id}, inicializar);
        }
    };


    var setAlterar = function (pedido) {
        prepararFormulario();
        bloquearSelectGrupo(true);
        setOpcao(formPedidoCompra, "alterar");
        carregarDadosFormulario(pedido);
        setUrlItem(pedido.tipo);
        setSelected($("#selectGrupo").children(), pedido.grupoId);
        setSelected($("#selectLotacao").children(), pedido.lotacaoId);
        buscarPaSaldoPorId(pedido.paId);
        getTipoGrupo();

        verificaPedidoBloqueado(pedido.bloqueado);

        $(pedido.listaItemPedido).each(function () {
            var item = $(this)[0];
            incluirItemPedido(item.item, item.quantidade, item.pedidoId, item.naturezaDespesaId);
        });
        montarTabelaItensPedido();
        mostrarInfoPedido();
    };

    var imprimirPedido = function (id) {
        window.open("imprimirPedidoCompra.php?id=" + id, "_blank");
    };

    var pedidoAtividade = function (pedido) {
        $(divPedidoAtividade).children().remove();
        $(divPedidoAtividade).load("pedidoAtividade.html", function () {
            $(this).find("#pedidoId").val(pedido.id);
            listarAtividadePorPedido(pedido.id);
            listarSituacaoItemPorPedido(pedido.id, pedido.tipo);
        });
        mostrarDivAuxiliarPedido();
    };

    var verificaArrayItemPedido = function () {
        return (arrayItensPedido.length === 0) ? false : true;
    };

    function enviarPedido() {
        if (verificaArrayItemPedido()) {
            if (!pedidoSalvo) {
                salvarPedido();
            }
            encaminharParaChefia();
        } else {
            exibirAlerta("ERRO", "Não há itens nesse pedido!");
        }

    }

    var encaminharParaChefia = function () {
        var opcao = "encaminharParaChefia";
        var id = $("#id").val();
        var parametro = {opcao: opcao, id: id};
        var url = $("#url").val();
        requisicaoAjax(url, parametro, function (retornoBloquearPedido) {
            if (retornoBloquearPedido.estado === "sucesso") {
                exibirAlerta("OK", "O pedido foi enviado! \n Imprima o pedido e encaminhe para a chefia");
                imprimirPedido(id);
            }
            inicializar();

        });
    };

    var inicializar = function () {
        grupoId = 0;
        lotacaoId = 0;
        limparArraysItens();
        limparFormulario(formPedidoCompra);
        limparFormulario(formPesquisaItem);
        listarPedidosCadastrados();
        mostrarPedidosCadastrados();
        carregarCalendario($(".calendario"));

    };


    inicializar();

    $(formPedidoCompra).submit(function (event) {
        event.preventDefault();
        salvarPedido();

        if (pedidoSalvo) {
            if (confirm("O pedido foi salvo. \n Deseja enviar o pedido para a chefia? (Cancelar)NÃO | (OK)SIM")) {
                enviarPedido();
            } else {
                exibirAlerta("OK", "O pedido foi salvo, mas não enviado!");
            }
        }

    });

    $(formPesquisaItem).submit(function (event) {
        event.preventDefault();
        pesquisarItensCompra();
        $("#divItensPesquisa .panel .panel-body").show();
        $("#divItensPesquisa .panel .panel-footer").show();
    });


    $("#novoPedido").click(function () {
        mostrarInfoPedido();
        novoPedido();
        $("#pedidoBloqueado").val("0");
        verificaPedidoBloqueado("0");
        $("#divItensPedido").hide();
    });

    $("#buscaPA").click(function () {
        buscarInfoPA();
    });

    $("#codigoPA").on("change keyup paste click input", function () {
        if ($(this).val().length === 13) {
            var codigoPA = $(this).val();
            $("#dataListPA").children().each(function () {
                var option = $(this)[0];
                if (option.value === codigoPA) {
                    buscarPaSaldoPorId(option.id);
                }
            });
            buscarInfoPA();
        } else {
            removerInfoPA();
        }
        ;
    });

    $("#botaoAddItem").click(function () {
        salvarPedido();
        var tipo = $("#tipo").val();
        if (tipo.length === 0) {
            exibirAlerta("ERRO", "Selecione um grupo");
            $("#selectGrupo").focus();
        } else {
            grupoId = $("#selectGrupo").val();
            $("#modalItensPesquisa").modal('show');
        }
    });

    $("#selectGrupo").change(function () {
        getTipoGrupo();
    });

    $("#checkboxSelecionarTodos").click(function () {
        var check = $(this).prop("checked");
        $(".checkBoxItens").prop({checked: check});
    });

    $("#selecionarItens").click(function () {
        var itensSelecionados = $(".checkBoxItens:checked");
        $(itensSelecionados).each(function () {
            var botaoIncluir = $(this).parents("tr");
            $(botaoIncluir).find(".botaoSelecionar").click();
        });

        if (!confirm("Itens inseridos com sucesso!\nDeseja continuar inserindo itens? (Cancelar)NÃO | (Ok)SIM")) {
            mostrarInfoPedido();
            bloquearSelectGrupo((arrayItensPedido.length > 0) ? true : false);
            limparListaItensCadastrados();
            $("#modalItensPesquisa").modal('toggle');
        }
    });

    $("#cancelar").click(function () {
        inicializar();
    });

    $("#botaoVoltar").click(function () {
//        FECHA A TELA DE PESQUISA DE ITENS CADASTRADOS PARA INSERIR NO PEDIDO
//        CASO O USUÁRIO TENHA SELECIONADO ALGUM ITEM, O SELECT GRUPO É BLOQUEADO
        montarTabelaItensPedido();
        mostrarInfoPedido();
        bloquearSelectGrupo((arrayItensPedido.length > 0) ? true : false);
        limparListaItensCadastrados();
        $(divPedidoAtividade).children().remove();
        fecharDivAuxiliarPedido();
    });
    
    $("#voltarHistorico").click(function () {
        fecharDivAuxiliarPedido();
    });

    $("#botaoImprimir").click(function () {
        imprimirPedido($("#id").val());
    });

    $("#botaoEnviar").click(function () {
        enviarPedido();
    });

//    carregarCalendario($(".calendario"));

});
