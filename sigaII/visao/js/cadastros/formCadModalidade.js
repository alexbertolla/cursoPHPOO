$(document).ready(function () {
    var formCadModalidade = $("#formCadModalidade");
    var divModalidadeCadastradas = $("#divModalidadeCadastradas");
    var divFormCadModalidade = $("#divFormCadModalidade");
    var spanModalidadeCadastradas = $("#spanModalidadeCadastradas");

    var mostarDivListaCadastradas = function () {
        $(divModalidadeCadastradas).show();
        $(divFormCadModalidade).hide();
    };

    var mostarDivFormCadastro = function () {
        $("#nome").focus();
        $(divModalidadeCadastradas).hide();
        $(divFormCadModalidade).show();
    };

    var submit = function () {
        submeterFormulario(formCadModalidade, retornoSubmit);
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
            montarListaModalidadeCadastradas(retornoAjax.dados);
        }
    };

    var montarListaModalidadeCadastradas = function (listaModalidadeCadastradas) {
//        var divCC = $("#divContaContabilCadastradas");
        var ulModalidade = criarUl("ulModalidade", "", "", "");//id, nome, classe, li

        $(spanModalidadeCadastradas).children().remove();
        $(listaModalidadeCadastradas).each(function () {
            var modalidade = $(this)[0];

//            var classeBotao = "botaoDesativar";

            var labelModadelidade = criarLabel("", "", modalidade.nome, "");//id, nome, texto, classes

//            if (modalidade.situacao === "0") {
//                setItemInativo($(labelModadelidade));
//                classeBotao = "botaoAtivar";
//            }

            var buttonExcluir = criarButton("", "button", "buttonExcluir", "Excluir", "botaoExcluir", function () { //id, tipo, nome, titulo, classes, acao
                excluir(modalidade);
            });//id, tipo, nome, titulo, classes, acao


//            var buttonSituacao = criarButton("", "button", "buttonSituacao", "Ativar/Desativar", classeBotao, function () { //id, tipo, nome, titulo, classes, acao
//                situacao(modalidade);
//            });

            var spanLabel = $("<span>").append(labelModadelidade).addClass("spanLiCadastradosLabel");

            $(spanLabel).click(function () {
                alterar(modalidade)
            });

            var spanBotao = $("<span>").append([buttonExcluir]).addClass("spanLiCadastradosButton");

            var liModalidade = criarLi("", "liListaCadastrados", [spanLabel, spanBotao]); //id, classe, conteudo
            $(ulModalidade).append(liModalidade);

        });
        $(spanModalidadeCadastradas).append(ulModalidade);
    };

    var excluir = function (modalidade) {
        setOpcao(formCadModalidade, "excluir");
        carregarDadosFomulario(modalidade);
        if (confirm("Deseja realmente apagar a modalidade: " + modalidade.nome + "?")) {
            submit();
        }
    };


    var carregarDadosFomulario = function (modalidade) {
        $("#id").val(modalidade.id);
        $("#nome").val(modalidade.nome);
    };

    var alterar = function (modalidade) {
        carregarDadosFomulario(modalidade);
        setOpcao(formCadModalidade, "alterar");
        mostarDivFormCadastro();
    };

//    var situacao = function (contaContabil) {
//        alterar(contaContabil);
//        $("#situacao").prop({checked: (contaContabil.situacao === "1") ? false : true});
//        submit();
//    };


    var inicializar = function () {
        limparFormulario(formCadModalidade);
        listar();
        mostarDivListaCadastradas();
    };

    inicializar();

    $(formCadModalidade).submit(function (event) {
        event.preventDefault();
        submit();
    });

    $("#botaoPesquisarModalidade").click(function () {
        var opcao = "listarPorNome";
        var nome = $("#txtPesquisaModalidade").val();
        var parametros = {opcao: opcao, nome: nome};
        var url = $("#url").val();
        requisicaoAjax(url, parametros, retornoListar);
    });

    $("#botaoNovaModalidade").click(function () {
        limparFormulario(formCadModalidade);
        setOpcao(formCadModalidade, "inserir");
        mostarDivFormCadastro();
    });

    $("#botaoCancelar").click(function () {
        inicializar();
    });
});