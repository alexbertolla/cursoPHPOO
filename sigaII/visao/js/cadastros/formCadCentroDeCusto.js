$(document).ready(function () {
    var formCadCentroDeCusto = $("#formCadCentroDeCusto");
    var divCentroDeCustosCadastrados = $("#divCentroDeCustosCadastrados");
    var spanCentroDeCustosCadastrados = $("#spanCentroDeCustosCadastrados");
    var divFormCadCentroDeCusto = $("#divFormCadCentroDeCusto");

    var mostrarDivListaCadastrados = function () {
        $(divCentroDeCustosCadastrados).show();
        $(divFormCadCentroDeCusto).hide();
    };

    var mostrarDivFormCadastro = function () {
        $(divCentroDeCustosCadastrados).hide();
        $(divFormCadCentroDeCusto).show();
    };

    var submit = function () {
        submeterFormulario(formCadCentroDeCusto, retornoSubmit);
    };

    var retornoSubmit = function (retornoSubmit) {
        exibirMensagem(retornoSubmit.estado, retornoSubmit.mensagem);
        if (retornoSubmit.estado === "sucesso") {
            inicializar();
        }
    };

    var listar = function () {
        var url = $("#url").val();
        var opcao = "listar";
        var parametros = {opcao: opcao};
        requisicaoAjax(url, parametros, retornoListar);
    };

    var retornoListar = function (retornoAjax) {
        console.log(retornoAjax);
        if (retornoAjax.estado === "sucesso") {
            montarListaCCCadastradas(retornoAjax.dados);
        }
    };

    var montarListaCCCadastradas = function (listaCCCadastradas) {
        var ulCC = criarUl("ulCC", "", "", "");//id, nome, classe, li

        $(spanCentroDeCustosCadastrados).children().remove();
        $(listaCCCadastradas).each(function () {
            var centroDeCustos = $(this)[0];

            var classeBotao = "botaoDesativar";
            var tituloBotao = "Desativar";

            var labelCC = criarLabel("", "", centroDeCustos.codigo + " - " + centroDeCustos.nome, "");//id, nome, texto, classes
            if (centroDeCustos.situacao === "0") {
                setItemInativo(labelCC);
                tituloBotao = "Ativar";
                classeBotao = "botaoAtivar";

            }
            var buttonExcluir = criarButton("", "button", "buttonExcluir", "Excluir", "botaoExcluir", function () { //id, tipo, nome, titulo, classes, acao
                excluir(centroDeCustos);
            });//id, tipo, nome, titulo, classes, acao

            var buttonSituacao = criarButton("", "button", "buttonSituacao", tituloBotao, classeBotao, function () { //id, tipo, nome, titulo, classes, acao
                situacao(centroDeCustos);
            });

            var spanLabel = $("<span>").append(labelCC).addClass("spanLiCadastradosLabel");

            $(spanLabel).click(function () {
                alterar(centroDeCustos);
            });

            var spanBotao = $("<span>").append([buttonSituacao, buttonExcluir]).addClass("spanLiCadastradosButton");

            var liCC = criarLi("", "liListaCadastrados", [spanLabel, spanBotao]); //id, classe, conteudo
            $(ulCC).append(liCC);

        });
        $(spanCentroDeCustosCadastrados).append(ulCC);
    };

    var excluir = function (centroDeCustos) {
        setOpcao(formCadCentroDeCusto, "excluir");
        carregarDadosFomulario(centroDeCustos);
        if (confirm("Deseja realmente apagar o centro de custos: " + centroDeCustos.nome + "?")) {
            submit();
        }

    };


    var carregarDadosFomulario = function (centroDeCustos) {
        $("#id").val(centroDeCustos.id);
        $("#codigo").val(centroDeCustos.codigo);
        $("#nome").val(centroDeCustos.nome);
        $("#situacao").prop({checked: (centroDeCustos.situacao === "1") ? true : false});
    };

    var alterar = function (centroDeCustos) {
//        limparFormulario(formCadCentroDeCusto);
        setOpcao(formCadCentroDeCusto, "alterar");
        carregarDadosFomulario(centroDeCustos);
        mostrarDivFormCadastro();
    };

    var situacao = function (centroDeCustos) {
        alterar(centroDeCustos);
        $("#situacao").prop({checked: (centroDeCustos.situacao === "1") ? false : true});
        submit();
    };


    var inicializar = function () {
        limparFormulario(formCadCentroDeCusto);
        mostrarDivListaCadastrados()
        listar();
    };

    inicializar();

    $(formCadCentroDeCusto).submit(function (event) {
        event.preventDefault();
        submit();
    });

    $("#botaoPesquisarCC").click(function () {
        var opcao = "listarPorNome";
        var nome = $("#txtPesquisaCC").val();
        var parametros = {opcao: opcao, nome: nome};
        var url = $("#url").val();
        requisicaoAjax(url, parametros, retornoListar);
    });

    $("#botaoNovoCC").click(function () {
        limparFormulario(formCadCentroDeCusto);
        setOpcao(formCadCentroDeCusto, "inserir");
        mostrarDivFormCadastro();
    });

    $("#botaoCancelar").click(function () {
        inicializar();
    });
});