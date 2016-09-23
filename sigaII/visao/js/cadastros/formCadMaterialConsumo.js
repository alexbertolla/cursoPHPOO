var apresentacaoComercialId = 0;
var orgaoControladorId = 0;
var itemControladoId = 0;

$(document).ready(function () {
    var formCadMaterialConsumo = $("#formCadMaterialConsumo");
    var spanSituacao = $("#situacao").parents(".form-inline").find("span");

    var retornoSubmit = function (retornoSubmit) {
        console.log(retornoSubmit);
        if (retornoSubmit.estado === "sucesso") {
            inicializar();
        }
    };

    var listar = function () {
        var opcao = "listar";
        var parametros = {opcao: opcao};
        var url = $("#url").val();
        requisicaoAjax(url, parametros, retornoListar);
    };

    var retornoListar = function (retornoAjax) {
        montarLista(retornoAjax.dados);
    };

    var montarLista = function (listaMaterialConsumo) {
        var spanListaMaterialConsumoCadastrados = $("#spanListaMaterialConsumoCadastrados");
        var ul = criarUl();
        $(spanListaMaterialConsumoCadastrados).children().remove();

        $(listaMaterialConsumo).each(function () {
            var materialConsumo = $(this)[0];
            var codigo = materialConsumo.codigo;
            var nome = materialConsumo.nome;
            var texto = codigo + " - " + nome;


            var labelMaterialConsumo = criarLabel("", "", texto, "");//id, nome, texto, classes

            var classeBotao = "btn btn-warning";
            var tituloBotao = "Desativar";
            if (materialConsumo.situacao === "0") {
                setItemInativo($(labelMaterialConsumo));
                classeBotao = "btn btn-primary";
                tituloBotao = "Ativar";
            }

            var buttonSituacao = criarButton("", "button", "sitruacao", tituloBotao, classeBotao, function () {
                situacao(materialConsumo);
            });


            var buttonExcluir = criarButton("", "button", "excluir", "Excluir", "btn btn-danger", function () {
                excluir(materialConsumo);
            });

            var spanLabel = $("<span>").append(labelMaterialConsumo).addClass("spanLiCadastradosLabel");

            $(spanLabel).click(function () {
                alterar(materialConsumo);
            });

            var spanBotao = $("<span>").append([buttonSituacao, buttonExcluir]).addClass("spanLiCadastradosButton");

            var li = criarLi("", "liListaCadastrados", [spanLabel, spanBotao]); //id, classe, conteudo
            $(ul).append(li);
        });
        $(spanListaMaterialConsumoCadastrados).append(ul);

    };

    var situacao = function (materialConsumo) {
        alterar(materialConsumo);
        $("#situacao").prop({checked: (materialConsumo.situacao === "1") ? false : true});
        submit();
    };

    var excluir = function (materialConsumo) {
        prepararFormularioParaCadastro();
        setOpcao(formCadMaterialConsumo, "excluir");
        carregarDadosNoFormulario(materialConsumo);
        hidden = "";
        if (confirm("Confirma exclusão?")) {
            submit();
        }
    };

    var alterar = function (materialConsumo) {
        prepararFormularioParaCadastro();
        mostrarFormularioCadastro();
        setOpcao(formCadMaterialConsumo, "alterar");
        carregarDadosNoFormulario(materialConsumo);
    };

    var carregarDadosNoFormulario = function (materialConsumo) {
        $("#id").val(materialConsumo.id);
        $("#codigo").val(materialConsumo.codigo);
        $("#nome").val(materialConsumo.nome);
        $("#descricao").val(materialConsumo.descricao);
        $("#sustentavel").prop({checked: (materialConsumo.sustentavel === "1") ? true : false});
        $("#situacao").prop({checked: (materialConsumo.situacao === "1") ? true : false});
        

        $("#marca").val(materialConsumo.marca);
        $("#modelo").val(materialConsumo.modelo);
        $("#partNumber").val(materialConsumo.partNumber);
        $("#estoqueMaximo").val(materialConsumo.estoqueMaximo);
        $("#estoqueMinimo").val(materialConsumo.estoqueMinimo);
        $("#estoqueAtual").val(materialConsumo.estoqueAtual);
        $("#codigoSinap").val(materialConsumo.codigoSinap);


        setSelected($("#selectAlmoxarifadoVirtual").children(), materialConsumo.almoxarifadoVirtualId);
        setSelected($("#selectGrupo").children(), materialConsumo.grupoId);

        grupoId = materialConsumo.grupoId;
        almoxarifadoId = materialConsumo.almoxarifadoVirtualId;

        apresentacaoComercialId = materialConsumo.apresentacaoComercialId;
        listarApresentacaoComercialPorGrupo();

        setSelected($("#selectApresentacaoComercial").children(), apresentacaoComercialId);

        $("#controlado").prop({checked: (materialConsumo.controlado === "1") ? true : false});

        if (materialConsumo.controlado === "1") {
            orgaoControladorId = materialConsumo.orgaoControladorId;
            itemControladoId = materialConsumo.itemControladoId;
            listarOrgaoControlador();
            listarItemControlado(orgaoControladorId);
            exibirDivControlado(materialConsumo.controlado);

        }

        var listaCentroDeCusto = materialConsumo.centroDeCusto;
        var checkCentroDeCustos = $("#divCentroDeCustos").children().find("input");
        $(listaCentroDeCusto).each(function () {
            var centroDeCusto = $(this)[0];
            $(checkCentroDeCustos).each(function () {
                var checkBox = $(this);
                if (centroDeCusto.id === $(checkBox).val()) {
                    $(checkBox).prop({checked: true});
                }
            });
        });
        
        spanSituacao.css("color", ($("#situacao").is(":checked")) ? "black" : "red");
    };

    var mostraListaMaterialConsumoCadastrados = function () {
        $("div.panel-head-cad-mat").show();
        $("#divCadastroAuxiliarMaterialConsumo").hide();
        $("#spanCadastroAuxiliarMaterialConsumo").children().remove();
        $("#divFormCadMaterialConsumo").hide();
    };

    var mostrarFormularioCadastro = function () {
        $("div.panel-head-cad-mat").hide();
        $("#divCadastroAuxiliarMaterialConsumo").hide();
        $("#spanCadastroAuxiliarMaterialConsumo").children().remove();
        $("#divFormCadMaterialConsumo").show();
        listarApresentacaoComercialPorGrupo($("#selectGrupo").val());
    };

    var mostrarCadastroAuxiliar = function (formCadastroAuxiliar) {
        $("div.panel-head-cad-mat").hide();
        $("#divCadastroAuxiliarMaterialConsumo").show();
        $("#spanCadastroAuxiliarMaterialConsumo").children().remove();
        $("#spanCadastroAuxiliarMaterialConsumo").load(formCadastroAuxiliar);
        $("#divFormCadMaterialConsumo").hide();

    };

    var listarCentroDeCustos = function () {
        var opcao = "listarAtivos";
        var parametros = {opcao: opcao};
        var url = $("#urlCentroDeCusto").val();
        requisicaoAjax(url, parametros, retornoListarCentroDeCustos);
    };

    var retornoListarCentroDeCustos = function (retorno) {
        if (retorno.estado === "sucesso") {
            montarListaCentroDeCustos(retorno.dados);
        }
    };

    var montarListaCentroDeCustos = function (listaCentroDeCustos) {
        var divCentroDeCustos = $("#divCentroDeCustos");
        $(divCentroDeCustos).children().remove();
        var ul = criarUl();
        $(listaCentroDeCustos).each(function () {
            var li = criarLi();
            var centroDeCustos = $(this)[0];
            var label = criarLabel("", "", centroDeCustos.nome, "");//id, nome, texto, classes
            var checkBox = criarCheckbox("", "centroDeCustosId[]", centroDeCustos.id, false);//id, nome, valor, checked
            var span = $("<span>").append([checkBox, label]);
            $(li).append(span);
            $(ul).append(li);
        });
        $(divCentroDeCustos).append(ul);
    };


    var listarItemControlado = function () {
        var opcao = "listarPorGrupoEOrgaoControlador";
        var grupoId = $("#selectGrupo").val();
        var orgaoControladorId = $("#selectOrgaoControlador").val();
        var parametros = {opcao: opcao, grupoId: grupoId, orgaoControladorId: orgaoControladorId};
        var url = $("#urlItemControlado").val();
        requisicaoAjax(url, parametros, retornoListarItemControlado);
    };

    var retornoListarItemControlado = function (retornoAjax) {
        if (retornoAjax.estado === "sucesso") {
            montarSelectItemControlado(retornoAjax.dados);
        }
    };

    var montarSelectItemControlado = function (listaItemControlado) {
        var select = $("#selectItemControlado");
        $(select).children().remove();
        $(listaItemControlado).each(function () {
            var itemControlado = $(this)[0];
            var textoOption = itemControlado.nome + " " + itemControlado.quantidade + itemControlado.apresentacaoComercial + " - " + itemControlado.fonte;
            var option = criarOption(itemControlado.id, textoOption, false);//valor, texto, selected
            $(select).append(option);
        });

        setSelected($(select).children(), itemControladoId);
    };


    var listarOrgaoControlador = function () {
        var opcao = "listarAtivos";
        var parametros = {opcao: opcao};
        var url = $("#urlOrgaoControlador").val();
        requisicaoAjax(url, parametros, retornListarOrgaoControlador);
    };

    var retornListarOrgaoControlador = function (retornoAjax) {
        if ((retornoAjax.estado === "sucesso") && $(retornoAjax.dados).length > 0) {
            montarSelectOrgaoControlador(retornoAjax.dados);
        }
    };

    var montarSelectOrgaoControlador = function (listaOrgaoControlador) {
        var select = $("#selectOrgaoControlador");
        $(select).children().remove();
        $(listaOrgaoControlador).each(function () {
            var orgaoControlador = $(this)[0];
            var option = criarOption(orgaoControlador.id, orgaoControlador.nome, false);
            $(select).append(option);
        });
        setSelected($(select).children(), orgaoControladorId);
        listarItemControlado();
    };



    var exibirDivControlado = function (controlado) {
        var div = $(".divItenControlado");
        if (controlado) {
            $(div).show("slow");
        } else {
            $(div).hide("slow");
        }
    };

    var submit = function () {
        submeterFormulario(formCadMaterialConsumo, retornoSubmit);
    };

    var prepararFormularioParaCadastro = function () {
        limparFormulario(formCadMaterialConsumo);
        listarGrupoPorNaturezaDeDespesa();
        listarAlmoxarifadoVirtual();
        listarCentroDeCustos();
        listarOrgaoControlador();
    };


    var inicializar = function () {
        //mostraListaMaterialConsumoCadastrados();
        setNaturezaDespesa();
        //listar();
        $("#divFormCadMaterialConsumo").hide();


        exibirDivControlado($("#controlado").prop("checked"));
        $("#selectOrgaoControlador").children().remove();
        $("#selectItemControlado").children().remove();
    };

    inicializar();

    $("#selectGrupo").change(function () {
        listarApresentacaoComercialPorGrupo();
        if ($("#selectItemControlado").val() !== null) {
            listarItemControlado();
        }
        
        if ($(this).val() === "230") {
            $(".cod-sinapi").hide("slow");
            $(".cod-cas").show("slow");
        } else {
            $(".cod-cas").hide();
        }
        
        if ($(this).val() === "243") {
            $(".cod-cas").hide("slow");
            $(".cod-sinapi").show("slow");
        } else {
            $(".cod-sinapi").hide("slow");
        }
        
        if (!$(this).val() !== "Obras") {
            
        }
    });


    $("#botaoNovoMC").click(function () {
        prepararFormularioParaCadastro();
        mostrarFormularioCadastro();
        setOpcao(formCadMaterialConsumo, "inserir");
        // spanSituacao.css("color","green");
    });

    $("#botaoCancelar").click(function () {
        $("div.panel-head-cad-mat").show();
        inicializar();
        //pesquisar(retornoListar);
    });


    $("#fecharCadastroAuxiliar").click(function () {
        listarGrupoPorNaturezaDeDespesa();
        listarAlmoxarifadoVirtual();
        mostrarFormularioCadastro();
        listarOrgaoControlador();
    });

    $("#botaoAddGrupo").click(function () {
        mostrarCadastroAuxiliar("formCadGrupo.html");
    });

    $("#botaoAddAV").click(function () {
        mostrarCadastroAuxiliar("formCadAlmoxarifadoVirtual.html");
    });

    $("#botaoAddAC").click(function () {
        mostrarCadastroAuxiliar("formCadApresentacaoComercial.html");
    });

    $("#botaoAddOC").click(function () {
        mostrarCadastroAuxiliar("formCadOrgaoControlador.html");
    });

    $("#botaoAddIC").click(function () {
        mostrarCadastroAuxiliar("formCadItemControlado.html");
    });


    $("#selectOrgaoControlador").change(function () {
        listarItemControlado();
    });


    $("#controlado").click(function () {
        listarOrgaoControlador();
        exibirDivControlado($(this).prop("checked"));
    });


    $(formCadMaterialConsumo).submit(function (event) {
        event.preventDefault();
        submit();
    });

    $("#botaoPesquisarMC").click(function () {
        pesquisar(retornoListar);
    });
    
    $("#situacao").change(function () {
        if ($(this).is(":not(:checked)")) {
            spanSituacao.css("color","red");
        } else {
            spanSituacao.css("color","black");
        }
    });
    
    $("#txtPesquisaItem").focusin(function () {
        $("#botaoPesquisarMC").addClass("hover");
    });
    
    $(".input-pesquisa").on("keydown", function(e) {
        if (e.which == 13) {
            e.preventDefault();
            $("#botaoPesquisarMC").click();
        }
    });

});