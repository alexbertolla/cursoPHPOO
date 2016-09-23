$(document).ready(function () {
    var formCadContaContabil = $("#formCadContaContabil");
    var divNaturezaDespesasCadastradas = $(".panel-head-cc");
    var divFormCadContaContabil = $("#divFormCadContaContabil");
    var spanContaContabilCadastradas = $("#spanContaContabilCadastradas");

    var mostarDivListaCadastradas = function () {
        $(divNaturezaDespesasCadastradas).show();
        $(divFormCadContaContabil).hide();
    };

    var mostarDivFormCadastro = function () {
        $("#codigo").focus();
        $(divNaturezaDespesasCadastradas).hide();
        $(divFormCadContaContabil).show();
    };

    var submit = function () {
        submeterFormulario(formCadContaContabil, retornoSubmit);
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
        if (retornoAjax.estado === "sucesso") {
            montarListaCCCadastradas(retornoAjax.dados);
        }
    };

    var montarListaCCCadastradas = function (listaCCCadastradas) {
//        var divCC = $("#divContaContabilCadastradas");
        var ulCC = criarUl("ulCC", "", "", "");//id, nome, classe, li

        $(spanContaContabilCadastradas).children().remove();
        $(listaCCCadastradas).each(function () {
            var contaContabil = $(this)[0];

            var classeBotao = "btn btn-warning";
            var tituloBotao = "Desativar";

            var labelCC = criarLabel("", "", contaContabil.codigo + " - " + contaContabil.nome, "");//id, nome, texto, classes

            if (contaContabil.situacao === "0") {
                setItemInativo($(labelCC));
                tituloBotao = "Ativar";
                classeBotao = "btn btn-primary";

            }

            var buttonExcluir = criarButton("", "button", "buttonExcluir", "Excluir", "btn btn-danger", function () { //id, tipo, nome, titulo, classes, acao
                excluir(contaContabil);
            });//id, tipo, nome, titulo, classes, acao


            var buttonSituacao = criarButton("", "button", "buttonSituacao", tituloBotao, classeBotao, function () { //id, tipo, nome, titulo, classes, acao
                situacao(contaContabil);
            });

            var spanLabel = $("<span>").append(labelCC).addClass("spanLiCadastradosLabel");

            $(spanLabel).click(function () {
                alterar(contaContabil)
            });

            var spanBotao = $("<span>").append([buttonSituacao, buttonExcluir]).addClass("spanLiCadastradosButton");

            var liCC = criarLi("", "liListaCadastrados", [spanLabel, spanBotao]); //id, classe, conteudo
            $(ulCC).append(liCC);

        });
        $(spanContaContabilCadastradas).append(ulCC);
    };

    var excluir = function (contaContabil) {
        setOpcao(formCadContaContabil, "excluir");
        carregarDadosFomulario(contaContabil);
        if (confirm("Deseja realmente apagar a conta contabil: " + contaContabil.nome + "?")) {
            submit();
        }
    };


    var carregarDadosFomulario = function (contaContabil) {
        $("#id").val(contaContabil.id);
        $("#codigo").val(contaContabil.codigo);
        $("#nome").val(contaContabil.nome);
        $("#situacao").prop({checked: (contaContabil.situacao === "1") ? true : false});
    };

    var alterar = function (contaContabil) {
        carregarDadosFomulario(contaContabil);
        setOpcao(formCadContaContabil, "alterar");
        mostarDivFormCadastro();
    };

    var situacao = function (contaContabil) {
        alterar(contaContabil);
        $("#situacao").prop({checked: (contaContabil.situacao === "1") ? false : true});
        submit();
    };


    var inicializar = function () {
        limparFormulario(formCadContaContabil);
        listar();
        mostarDivListaCadastradas();
    };

    inicializar();

    $(formCadContaContabil).submit(function (event) {
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

    $("#botaoNovoContaContabil").click(function () {
        limparFormulario(formCadContaContabil);
        setOpcao(formCadContaContabil, "inserir");
        mostarDivFormCadastro();
    });

    $("#botaoCancelar").click(function () {
        inicializar();
    });
});