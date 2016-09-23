$(document).ready(function () {
    var formRegistrarEntradaMaterial = $("#formRegistrarEntradaMaterial");
    var formPesquisaItem = $("#formPesquisaItem");
    var tabelaItemEntrada = $("#tabelaItemEntrada");

    var checkboxOCS = $("#checkboxOCS");
    var tabelaItemEntrada = $("#tabelaItemEntrada");

    var arrayItemEntrada = [];
    var arrayItensSelecionados = [];

    var limparArrayItemEntrada = function () {
        arrayItemEntrada.splice(0, arrayItemEntrada.length);
    };

    var incluirItemOCSArrayItemEntrada = function (itemOCS) {
        formatarArrayItemEntrada(itemOCS.item, itemOCS.quantidade, itemOCS.valorUnitario, itemOCS.valorTotal, itemOCS.fornecedorId)
    };

    var incluirMaterialConsumoArrayItemEntrada = function (materialConsumo) {
        formatarArrayItemEntrada(materialConsumo, 1, 0, 0, $("#fornecedorId").val());
    };

    var formatarArrayItemEntrada = function (item, quantidade, valorUnitario, valorTotal, fornecedorId) {
        var incluirItem = 1;
        var itemEntrada = {
            entradaId: null, fornecedorId: fornecedorId, itemId: item.id,
            grupoId: item.grupoId, quantidade: quantidade, valorUnitario: valorUnitario,
            valorTotal: valorTotal, item: item
        };
        $("#tabelaItemEntrada td.tdCodigoItemEntrada").each(function () {
            if ($(this).text() !== item.codigo) {
                console.log("diferente");
            } else {
                alert("O item " + item.codigo + " - " + item.descricao + " já foi adicionado!");
                incluirItem = 0;
            }
        });
        if (incluirItem === 1) {
            arrayItemEntrada.push(itemEntrada);
        }
        
    };

    var formatarNotaFiscal = function () {
        var notaFiscal = {numero: $("#numeroNotaFiscal").val(), chaveAcesso: $("#chaveAcesso").val(), fornecedorId: $("#fornecedorId").val()};
        return notaFiscal;
    };

    var verificaTipoEntrada = function () {
        bloqueado = $(checkboxOCS).prop("checked");
        bloquearDadosOCS(bloqueado);
        bloquearDadosFornecedor(bloqueado);
    };

    var listarNaturezaOperacao = function () {
        var urlNaturezaOperacao = $("#urlNaturezaOperacao").val();
        var opcao = "listar";
        var parametros = {opcao: opcao};
        requisicaoAjax(urlNaturezaOperacao, parametros, function (retornoListarNO) {
            montarSelectNaturezaOperacao(retornoListarNO.dados);
        });
    };

    var montarSelectNaturezaOperacao = function (listaNaturezaOperacao) {
        var select = $("#selectNaturezaOperacao");
        $(select).children().remove();
        $(listaNaturezaOperacao).each(function () {
            var naturezaOperacao = $(this)[0];
            console.log(naturezaOperacao);
            var option = criarOption(naturezaOperacao.id, naturezaOperacao.numero+" - "+naturezaOperacao.nome, false);
            $(select).append(option);
        });
    };

    var bloquearDadosOCS = function (bloqueado) {
        limparDadosOCS();
        $("#pesquisarOCS").prop({disabled: !bloqueado});
        $("#botaoAddItem").prop({disabled: bloqueado});
        $(".dadosOCS").prop({disabled: !bloqueado});
    };

    var bloquearDadosFornecedor = function (bloqueado) {
        limparDadosFornecedor();
        $("#buscarFornecedor").prop({disabled: bloqueado});
        $(".dadosFornecedor").prop({disabled: bloqueado});
        $(".tipoFornecedor").prop({disabled: bloqueado});

    };

    var pesquisarFornecedor = function () {
        var documento = $("#documento").val();
        var tipoFornecedor = $(".tipoFornecedor:checked").val();
        var parametros = {opcao: "buscarPorDocumento", documento: documento, tipoFornecedor: tipoFornecedor};
        var url = $("#urlFornecedor").val();
        requisicaoAjax(url, parametros, function (retorno) {
            limparDadosFornecedor();
            if (retorno.estado === "sucesso") {
                carregarDadosFornecedor(retorno.dados);
            } else {
                exibirAlerta(retorno.estado, "Fornecedor não encontrado!");
            }
        });
    };

    var pesquisarDadosOCS = function () {
        var urlOrdemDeCompra = $("#urlOrdemDeCompra").val();
        var numero = $("#numeroOCS").val();
        var sequencia = $("#sequenciaOCS").val();
        var opcao = "buscarPorNumeroESequencia";
        var parametros = {opcao: opcao, numero: numero, sequencia: sequencia};
        requisicaoAjax(urlOrdemDeCompra, parametros, function (retornoPesquisarOCS) {
            limparDadosOCS();
            if (retornoPesquisarOCS.estado === "sucesso") {
                carregarDadosOCS(retornoPesquisarOCS.dados);
                carregarDadosFornecedor(retornoPesquisarOCS.dados.fornecedor);
                $(retornoPesquisarOCS.dados.listaItemOrdemDeCompra).each(function () {
                    var itemOCS = $(this)[0];
                    incluirItemOCSArrayItemEntrada(itemOCS);
                });
                montarTabelaItemEntrada();
            }
        });
    };

    var limparDadosOCS = function () {
        $(".dadosOCS").val("");
        limparArrayItemEntrada();
        limparTabela($(tabelaItemEntrada).children("tbody"));
    };

    var limparDadosFornecedor = function () {
        $(".dadosFornecedor").val("");
        $("#nome").val("");
    };

    var carregarDadosOCS = function (ordemDeCompra) {
        $("#numeroOCS").val(ordemDeCompra.numero);
        $("#sequenciaOCS").val(ordemDeCompra.sequencia);
        $("#ordemCompraId").val(ordemDeCompra.id);
    };

    var carregarDadosFornecedor = function (fornecedor) {
        $("#documento").val(fornecedor.documento);
        $("#nome").val(fornecedor.nome);
        $("#fornecedorId").val(fornecedor.id);
    };

    var montarTabelaItemEntrada = function () {
        var tbody = $(tabelaItemEntrada).children("tbody");
        limparTabela(tbody);
        $(arrayItemEntrada).each(function () {
            var itemEntrada = $(this)[0];
            var checkboxItemEntrada = criarCheckbox();
            $(checkboxItemEntrada).addClass("checkboxItemEntrada");
            $(checkboxItemEntrada).attr('id', arrayItemEntrada.indexOf(itemEntrada));
            var tdCheckbox = $("<td>").append(checkboxItemEntrada);
            var tdCodigoItemEntrada = $("<td>").append(itemEntrada.item.codigo).addClass("tdCodigoItemEntrada");
            var tdDescricaoItemEntrada = $("<td>").append(itemEntrada.item.descricao).addClass("tdDescricaoItemEntrada");
            var tdQauntidadeItemEntrada = $("<td>").append($('<input/>',{value: itemEntrada.quantidade})).addClass("tdQauntidadeItemEntrada");
            var tdValorUnitarioItemEntrada = $("<td>").append(itemEntrada.valorUnitario).addClass("tdValorUnitarioItemEntrada");
            var tdValorTotalItemEntrada = $("<td>").append(itemEntrada.valorTotal).addClass("tdValorTotalItemEntrada");
            var tr = $("<tr>").append([tdCheckbox, tdCodigoItemEntrada, tdDescricaoItemEntrada, tdQauntidadeItemEntrada, tdValorUnitarioItemEntrada, tdValorTotalItemEntrada]);
            $(tbody).append(tr);
        });
    };


    var pesquisarMaterialConsumo = function () {
        var opcao = "listarPorNomeDescricaoOuCodigo";
        var nome = $("#txtPesquisaItem").val();
        var url = $("#urlItem").val();
        var parametros = {opcao: opcao, nome: nome};
        requisicaoAjax(url, parametros, function (retornoPesquisarItem) {
            montarTabelaMaterialConsumo(retornoPesquisarItem.dados);
        });
    };

    var montarTabelaMaterialConsumo = function (listaMaterialConsumo) {
        var tbody = $("#tabelaMaterialConsumo").children("tbody");
        limparTabela(tbody);
        $(listaMaterialConsumo).each(function () {
            var materialConsumo = $(this)[0];
            
            var checkboxMaterialConsumo = criarCheckbox();
            $(checkboxMaterialConsumo).addClass("checkboxMaterialConsumo");
            var tdCheckboxMaterialConsumo = $("<td>").append(checkboxMaterialConsumo).addClass("tdCheckboxMaterialConsumo");
            
            var tdCodigoMaterialConsumo = $("<td>").append(materialConsumo.codigo).addClass("tdCodigoMaterialConsumo");
            var tdDescricaoMaterialConsumo = $("<td>").append(materialConsumo.descricao).addClass("tdDescricaMaterialConsumo");
            var tdBotoesMaterialConsumo = $("<td>").append(criarButton("", "button", "", "Incluir", "botaoIncluir", function () {
                incluirMaterialConsumo(materialConsumo);
            })).addClass("tdBotoesMaterialConsumo");
            var tr = $("<tr>").append([tdCheckboxMaterialConsumo, tdCodigoMaterialConsumo, tdDescricaoMaterialConsumo, tdBotoesMaterialConsumo]);
            $(tbody).append(tr);
        });

    };

    var incluirMaterialConsumo = function (materialConsumo) {
        incluirMaterialConsumoArrayItemEntrada(materialConsumo);
        
        montarTabelaItemEntrada();
        $("#divListaItemEntrada").show();
        console.log(arrayItemEntrada);
    };

    var inicializar = function () {
        $("#ano").val();
        verificaTipoEntrada();
        listarNaturezaOperacao();
    };

    inicializar();

    $(checkboxOCS).click(function () {
        limparDadosOCS();
        limparDadosFornecedor();
        verificaTipoEntrada();
    });

    $(formRegistrarEntradaMaterial).submit(function (event) {
        event.preventDefault();
        formatarItensSelecionados();
        var url = $("#url").val();
        var notaFiscal = formatarNotaFiscal();
        
        console.log('arrayItensSelecionados');
        console.log(arrayItensSelecionados);

        var parametos = {opcao: $("#opcao").val(), ano: SistemaLogado.anoSistema, fornecedorId: $("#fornecedorId").val(), ordemCompraId: $("#ordemCompraId").val(),
            tipoFornecedor: $(".tipoFornecedor:checked").val(), naturezaOperacaoId: $("#selectNaturezaOperacao").val(), notaFiscal: notaFiscal, listaItemEntrada: arrayItensSelecionados};
        console.log('parametos');
        console.log(parametos);
        requisicaoAjax(url, parametos, function (retornoSubmuit) {
            console.log("retorno");
            console.log(retornoSubmuit);
            alert(retornoSubmuit.mensagem);
        });
    });

    var formatarItensSelecionados = function () {
        var itensSelecionados = $(".checkboxItemEntrada:checked");
        arrayItensSelecionados.splice(0, arrayItensSelecionados.length);
        $(itensSelecionados).each(function () {
            var indice = $(this).attr('id');
            var itemId = arrayItemEntrada[indice].item.id;
            var grupoId = arrayItemEntrada[indice].item.grupoId;
            var fornecedorId = arrayItemEntrada[indice].fornecedorId;
            var quantidade = arrayItemEntrada[indice].quantidade;
            var valorUnitario = arrayItemEntrada[indice].valorUnitario;
            var valorTotal = arrayItemEntrada[indice].valorTotal;

            var itemEntrada = {
                entradaId: null, itemId: itemId,
                grupoId: grupoId, fornecedorId: fornecedorId, quantidade: quantidade, valorUnitario: valorUnitario,
                valorTotal: valorTotal
            };
            arrayItensSelecionados.push(itemEntrada);
        });
    };
    

    $("#pesquisarOCS").click(function () {
        if ($("#numeroOCS").val().length > 0 && $("#sequenciaOCS").val().length > 0) {
            $("#divListaItemEntrada").show();
            pesquisarDadosOCS();
        }
    });

    $("#buscarFornecedor").click(function () {
        if ($("#documento").val().length > 0) {
            pesquisarFornecedor();
        }
    });

    $("#botaoAddItem").click(function () {
        if ($("#fornecedorId").val() === "") {
            exibirAlerta("ERRO", "Primeiro escolha o fornecedor!");
            return false;
        } else {
            $("#modalItensPesquisa").modal('show');
        }
    });

    $("#botaoPesquisarItem").click(function (event) {
        event.preventDefault();
        $("#divItensPesquisa .panel-body").show();
        pesquisarMaterialConsumo();
    });

    $("#checkboxSelecionarTodosItemEntrada").click(function () {
        var selecionado = $(this).prop("checked");
        $(".checkboxItemEntrada").prop({checked: selecionado});
    });
    
    $("#checkboxSelecionarTodosMaterialConsumo").click(function () {
        var selecionado = $(this).prop("checked");
        $(".checkboxMaterialConsumo").prop({checked: selecionado});
    });
    
    $("#selecionarItens").click(function () {
        var itensSelecionados = $(".checkboxMaterialConsumo:checked");
        $(itensSelecionados).each(function () {
            var botaoIncluir = $(this).parents("tr");
            $(botaoIncluir).find(".botaoIncluir").click();
        });
        $("#divListaItemEntrada").show();
        $("#modalItensPesquisa").modal('hide');
        
    });


});