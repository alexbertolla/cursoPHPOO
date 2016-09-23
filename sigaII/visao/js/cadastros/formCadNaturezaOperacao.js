$(document).ready(function () {
    var formCadNaturezaOperacao = $("#formCadNaturezaOperacao");
    var divNaturezaOperacaoCadastradas = $("#divNaturezaOperacaoCadastradas");
    var divFormCadNaturezaOperacao = $("#divFormCadNaturezaOperacao");
    var spanNaturezaOperacaoCadastradas = $("#spanNaturezaOperacaoCadastradas");

    var mostarDivListaCadastradas = function () {
        $(divNaturezaOperacaoCadastradas).show();
        $(divFormCadNaturezaOperacao).hide();
    };

    var mostarDivFormCadastro = function () {
        $("#nome").focus();
        $(divNaturezaOperacaoCadastradas).hide();
        $(divFormCadNaturezaOperacao).show();
    };

    var submit = function () {
        submeterFormulario(formCadNaturezaOperacao, retornoSubmit);
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
            montarListaNaturezaOperacaoCadastradas(retornoAjax.dados);
        }
    };

    var montarListaNaturezaOperacaoCadastradas = function (listaNaturezaOperacaoCadastradas) {
//        var divCC = $("#divContaContabilCadastradas");
        var ulNaturezaOperacao = criarUl("ulNaturezaOperacao", "", "", "");//id, nome, classe, li

        $(spanNaturezaOperacaoCadastradas).children().remove();
        $(listaNaturezaOperacaoCadastradas).each(function () {
            var naturezaOperacao = $(this)[0];

//            var classeBotao = "botaoDesativar";

            var labelModadelidade = criarLabel("", "", naturezaOperacao.nome, "");//id, nome, texto, classes

//            if (modalidade.situacao === "0") {
//                setItemInativo($(labelModadelidade));
//                classeBotao = "botaoAtivar";
//            }

            var buttonExcluir = criarButton("", "button", "buttonExcluir", "Excluir", "botaoExcluir", function () { //id, tipo, nome, titulo, classes, acao
                excluir(naturezaOperacao);
            });//id, tipo, nome, titulo, classes, acao


//            var buttonSituacao = criarButton("", "button", "buttonSituacao", "Ativar/Desativar", classeBotao, function () { //id, tipo, nome, titulo, classes, acao
//                situacao(modalidade);
//            });

            var spanLabel = $("<span>").append(labelModadelidade).addClass("spanLiCadastradosLabel");

            $(spanLabel).click(function () {
                alterar(naturezaOperacao)
            });

            var spanBotao = $("<span>").append([buttonExcluir]).addClass("spanLiCadastradosButton");

            var liNaturezaOperacao = criarLi("", "liListaCadastrados", [spanLabel, spanBotao]); //id, classe, conteudo
            $(ulNaturezaOperacao).append(liNaturezaOperacao);

        });
        $(spanNaturezaOperacaoCadastradas).append(ulNaturezaOperacao);
    };

    var excluir = function (naturezaOperacao) {
        setOpcao(formCadNaturezaOperacao, "excluir");
        carregarDadosFomulario(naturezaOperacao);
        if (confirm("Deseja realmente apagar: " + naturezaOperacao.nome + "?")) {
            submit();
        }
    };


    var carregarDadosFomulario = function (naturezaOperacao) {
        $("#id").val(naturezaOperacao.id);
        $("#nome").val(naturezaOperacao.nome);
        $("#numero").val(naturezaOperacao.numero);
    };

    var alterar = function (naturezaOperacao) {
        carregarDadosFomulario(naturezaOperacao);
        setOpcao(formCadNaturezaOperacao, "alterar");
        mostarDivFormCadastro();
    };

//    var situacao = function (contaContabil) {
//        alterar(contaContabil);
//        $("#situacao").prop({checked: (contaContabil.situacao === "1") ? false : true});
//        submit();
//    };


    var inicializar = function () {
        limparFormulario(formCadNaturezaOperacao);
        listar();
        mostarDivListaCadastradas();
    };

    inicializar();

    $(formCadNaturezaOperacao).submit(function (event) {
        event.preventDefault();
        submit();
    });

    $("#botaoPesquisarNaturezaOperacao").click(function () {
        var opcao = "listarPorNome";
        var nome = $("#txtPesquisaNaturezaOperacao").val();
        var parametros = {opcao: opcao, nome: nome};
        var url = $("#url").val();
        requisicaoAjax(url, parametros, retornoListar);
    });

    $("#botaoNovaNaturezaOperacao").click(function () {
        limparFormulario(formCadNaturezaOperacao);
        setOpcao(formCadNaturezaOperacao, "inserir");
        mostarDivFormCadastro();
    });

    $("#botaoCancelar").click(function () {
        inicializar();
    });
});