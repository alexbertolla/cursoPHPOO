$(document).ready(function () {
    var formCadServico = $("#formCadServico");

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

    var montarLista = function (listaServico) {
        var spanListaServicosCadastrados = $("#spanListaServicosCadastrados");
        var ul = criarUl();
        $(spanListaServicosCadastrados).children().remove();

        $(listaServico).each(function () {
            var servico = $(this)[0];
            var codigo = servico.codigo;
            var nome = servico.nome;
            var texto = codigo + " - " + nome;
            var labelServico = criarLabel("", "", texto, "");//id, nome, texto, classes

            var classeBotao = "btn btn-warning";
            var tituloBotao = "Desativar";
            if (servico.situacao === "0") {
                setItemInativo(labelServico);
                classeBotao = "btn btn-primary";
                tituloBotao = "Ativar";
            }

            var buttonSituacao = criarButton("", "button", "situacao", tituloBotao, classeBotao, function () {
                situacao(servico);
            });


            var buttonExcluir = criarButton("", "button", "excluir", "Excluir", "btn btn-danger", function () {
                excluir(servico);
            });

            var spanLabel = $("<span>").append(labelServico).addClass("spanLiCadastradosLabel");
            $(spanLabel).click(function () {
                alterar(servico);
            });
            var spanBotao = $("<span>").append([buttonSituacao, buttonExcluir]).addClass("spanLiCadastradosButton");

            var li = criarLi("", "liListaCadastrados", [spanLabel, spanBotao]);//id, classe, conteudo
            $(ul).append(li);
        });
        $(spanListaServicosCadastrados).append(ul);

    };

    var situacao = function (servico) {
        alterar(servico);
        carregarDadosNoFormulario(servico);
        $("#situacao").prop({checked: (servico.situacao === "1") ? false : true});
        submit();
    };

    var alterar = function (servico) {
        prepararFormularioParaCadastro();
        setOpcao(formCadServico, "alterar");
        carregarDadosNoFormulario(servico);
        mostrarFormularioCadastro();
    };

    var excluir = function (servico) {
        setOpcao(formCadServico, "excluir");
        carregarDadosNoFormulario(servico);
        if (confirm("Confirma Exclusão?")) {
            submit();
        }
    };


    var carregarDadosNoFormulario = function (servico) {
        $("#id").val(servico.id);
        $("#codigo").val(servico.codigo);
        $("#nome").val(servico.nome);
        $("#descricao").val(servico.descricao);
        $("#sustentavel").prop({checked: (servico.sustentavel === "1") ? true : false});
        $("#situacao").prop({checked: (servico.situacao === "1") ? true : false});

        grupoId = servico.grupoId;
        almoxarifadoId = servico.almoxarifadoVirtualId;

        setSelected($("#selectGrupo").children(), servico.grupoId);
        setSelected($("#selectAlmoxarifadoVirtual").children(), servico.almoxarifadoVirtualId);
//        setSelected($("#tipo").children(), servico.tipo);
    };

    var mostraListaServicosCadastrados = function () {
        $("#listaServicosCadastrados").show();
        $("#divCadastroAuxiliarServico").hide();
        $("#spanCadastroAuxiliarServico").children().remove();
        $("#divFormCadServico").hide();
    };

    var mostrarFormularioCadastro = function () {
        $("#listaServicosCadastrados").hide();
        $("#divCadastroAuxiliarServico").hide();
        $("#spanCadastroAuxiliarServico").children().remove();
        $("#divFormCadServico").show();
    };

    var mostrarCadastroAuxiliar = function (formCadastroAuxiliar) {
        $("#listaServicosCadastrados").hide();
        $("#divCadastroAuxiliarServico").show();
        $("#spanCadastroAuxiliarServico").children().remove();
        $("#spanCadastroAuxiliarServico").load(formCadastroAuxiliar);
        $("#divFormCadServico").hide();

    };

    var submit = function () {
        submeterFormulario(formCadServico, retornoSubmit);
    };

    var prepararFormularioParaCadastro = function () {
        limparFormulario(formCadServico);
        listarGrupoPorNaturezaDeDespesa();
        listarAlmoxarifadoVirtual();
    };


    var inicializar = function () {
        setNaturezaDespesa();
        limparFormulario(formCadServico);
        //listar();
        mostraListaServicosCadastrados();
    };

    inicializar();

    $(formCadServico).submit(function (event) {
        event.preventDefault();
        submit();
    });


    $("#botaoNovoServico").click(function () {
        prepararFormularioParaCadastro();
        mostrarFormularioCadastro();
        setOpcao(formCadServico, "inserir");
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

    $("#botaoPesquisarGrupo").click(function () {
        pesquisar(retornoListar);
    });


});