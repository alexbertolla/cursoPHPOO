$(document).ready(function () {
    var formCadMaterialPermanente = $("#formCadMaterialPermanente");

    var retornoSubmit = function (retornoSubmit) {
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

    var montarLista = function (listaMaterialPermanente) {
        var spanListaMaterialPermamenteCadastrados = $("#spanListaMaterialPermanenteCadastrados");
        var ul = criarUl();
        $(spanListaMaterialPermamenteCadastrados).children().remove();

        $(listaMaterialPermanente).each(function () {
            var materialPermanente = $(this)[0];
            var codigo = materialPermanente.codigo;
            var nome = materialPermanente.nome;
            var texto = codigo + " - " + nome;
            var labelServico = criarLabel("", "", texto, "");//id, nome, texto, classes

            var classeBotao = "btn btn-warning";
            var tituloBotao = "Desativar";
            if (materialPermanente.situacao === "0") {
                setItemInativo(labelServico);
                classeBotao = "btn btn-primary";
                tituloBotao = "Ativar";
            }


            var buttonSituacao = criarButton("", "button", "situacao", tituloBotao, classeBotao, function () {
                situacao(materialPermanente);
            });

            var buttonExcluir = criarButton("", "button", "excluir", "excluir", "btn btn-danger", function () {
                excluir(materialPermanente);
            });

            var spanLabel = $("<span>").append(labelServico).addClass("spanLiCadastradosLabel");

            $(spanLabel).click(function () {
                alterar(materialPermanente);
            });

            var spanBotao = $("<span>").append([buttonSituacao, buttonExcluir]).addClass("spanLiCadastradosButton");


            var li = criarLi("", "liListaCadastrados", [spanLabel, spanBotao]);//id, classe, conteudo
            $(ul).append(li);
        });
        $(spanListaMaterialPermamenteCadastrados).append(ul);

    };

    var alterar = function (materialPermanente) {
        prepararFormularioParaCadastro();
        setOpcao(formCadMaterialPermanente, "alterar");
        carregarDadosNoFormulario(materialPermanente);
        mostrarFormularioCadastro();
    };

    var excluir = function (materialPermanente) {
        setOpcao(formCadMaterialPermanente, "excluir");
        carregarDadosNoFormulario(materialPermanente);
        if (confirm("Confirma exclusão?")) {
            submit();
        }
    };

    var situacao = function (materialPermanente) {
        alterar(materialPermanente);
        $("#situacao").prop({checked: (materialPermanente.situacao === "1") ? false : true});
        submit();
    };

    var carregarDadosNoFormulario = function (materialPermanente) {
        $("#id").val(materialPermanente.id);
        $("#codigo").val(materialPermanente.codigo);
        $("#nome").val(materialPermanente.nome);
        $("#descricao").val(materialPermanente.descricao);
        $("#sustentavel").prop({checked: (materialPermanente.sustentavel === "1") ? true : false});
        $("#situacao").prop({checked: (materialPermanente.situacao === "1") ? true : false});

        $("#marca").val(materialPermanente.marca);
        $("#modelo").val(materialPermanente.modelo);
        $("#partNumber").val(materialPermanente.partNumber);

        grupoId = materialPermanente.grupoId;
        almoxarifadoId = materialPermanente.almoxarifadoVirtualId;

        setSelected($("#selectAlmoxarifadoVirtual").children(), materialPermanente.almoxarifadoVirtualId);
        setSelected($("#selectGrupo").children(), materialPermanente.grupoId);

    };


    var mostraListaMaterialPermanenteCadastrados = function () {
        $("#listaMaterialPermanenteCadastrados").show();
        $("#divCadastroAuxiliarMaterialPermanente").hide();
        $("#spanCadastroAuxiliarMaterialPermanente").children().remove();
        $("#divFormCadMaterialPermanente").hide();
    };

    var mostrarFormularioCadastro = function () {
        $("div.panel-head-cad-mat").hide();
        $("#listaMaterialPermanenteCadastrados").hide();
        $("#divCadastroAuxiliarMaterialPermanente").hide();
        $("#spanCadastroAuxiliarMaterialPermanente").children().remove();
        $("#divFormCadMaterialPermanente").show();
    };

    var mostrarCadastroAuxiliar = function (formCadastroAuxiliar) {
        $("#listaMaterialPermanenteCadastrados").hide();
        $("#divCadastroAuxiliarMaterialPermanente").show();
        $("#spanCadastroAuxiliarMaterialPermanente").children().remove();
        $("#spanCadastroAuxiliarMaterialPermanente").load(formCadastroAuxiliar);
        $("#divFormCadMaterialPermanente").hide();

    };

    var submit = function () {
        submeterFormulario(formCadMaterialPermanente, retornoSubmit);
    };
    
    var prepararFormularioParaCadastro = function () {
        limparFormulario(formCadMaterialPermanente);
        listarGrupoPorNaturezaDeDespesa();
        listarAlmoxarifadoVirtual();
    };

    var inicializar = function () {
        setNaturezaDespesa();
        limparFormulario(formCadMaterialPermanente);
        //listar();
        //mostraListaMaterialPermanenteCadastrados();
        $("#divFormCadMaterialPermanente").hide();
    };

    inicializar();



    $(formCadMaterialPermanente).submit(function (event) {
        event.preventDefault();
        submit();
    });


    $("#botaoNovoMP").click(function () {
        prepararFormularioParaCadastro();
        mostrarFormularioCadastro();
        setOpcao(formCadMaterialPermanente, "inserir");
    });

    $("#botaoCancelar").click(function () {
        inicializar();
    });


    $("#fecharCadastroAuxiliar").click(function () {
        listarGrupoPorNaturezaDeDespesa();
        listarAlmoxarifadoVirtual();
        mostrarFormularioCadastro();
    });

    $("#botaoAddGrupo").click(function () {
        mostrarCadastroAuxiliar("formCadGrupo.html")
    });

    $("#botaoAddAV").click(function () {
        mostrarCadastroAuxiliar("formCadAlmoxarifadoVirtual.html")
    });

    $("#botaoPesquisarMP").click(function () {
        pesquisar(retornoListar);
    });


});