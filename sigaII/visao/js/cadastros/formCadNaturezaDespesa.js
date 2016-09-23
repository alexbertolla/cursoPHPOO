$(document).ready(function () {

    var formCadNaturezaDespesa = $("#formCadNaturezaDespesa");
    var divNaturezaDespesasCadastradas = $("#divNaturezaDespesasCadastradas");
    var divFormCadNaturezaDespesa = $("#divFormCadNaturezaDespesa");
    var spanNaturezaDespesasCadastradas = $("#spanNaturezaDespesasCadastradas");

    var mostarListaNDCadastradas = function () {
        $(divNaturezaDespesasCadastradas).show();
        $(divFormCadNaturezaDespesa).hide();
    };

    var mostarFormCadNaturezaDespesa = function () {
        $(divNaturezaDespesasCadastradas).hide();
        $(divFormCadNaturezaDespesa).show();
    };

    var submit = function () {
        submeterFormulario(formCadNaturezaDespesa, retornoSubmit);
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
        requisicaoAjax(url, parametros, retornoListarAtivas);
    };

    var retornoListarAtivas = function (retornoAjax) {
        if (retornoAjax.estado === "sucesso") {
            montarListaNDCadastradas(retornoAjax.dados);
        }
    };

    var montarListaNDCadastradas = function (listaNDCadastradas) {
        var ulND = criarUl("ulND", "", "", "");//id, nome, classe, li

        $(spanNaturezaDespesasCadastradas).children().remove();
        $(listaNDCadastradas).each(function () {
            var naturezaDespesa = $(this)[0];

            var labelND = criarLabel("", "", naturezaDespesa.codigo + " - " + naturezaDespesa.nome, "");//id, nome, texto, classes

            var classeBotao = "btn btn-warning";
            var tituloBotao = "Desativar";

            if (naturezaDespesa.situacao === "0") {
                setItemInativo($(labelND));
                tituloBotao = "Ativar";
                classeBotao = "btn btn-primary";
            }

            var buttonExcluir = criarButton("", "button", "buttonExcluir", "Excluir", "btn btn-danger", function () { //id, tipo, nome, titulo, classes, acao
                excluir(naturezaDespesa);
            });//id, tipo, nome, titulo, classes, acao

            var buttonSituacao = criarButton("", "button", "buttonSituacao", tituloBotao, classeBotao, function () { //id, tipo, nome, titulo, classes, acao
                situacao(naturezaDespesa);
            });
            var spanLabel = $("<span>").append(labelND).addClass("spanLiCadastradosLabel");

            $(spanLabel).click(function () {
                alterar(naturezaDespesa);
            });

            var spanBotao = $("<span>").append([buttonSituacao, buttonExcluir]).addClass("spanLiCadastradosButton");


            var liND = criarLi("", "liListaCadastrados", [spanLabel, spanBotao]); //id, classe, conteudo
            $(ulND).append(liND);

        }
        );
        $(spanNaturezaDespesasCadastradas).append(ulND);
    };
    var excluir = function (naturezaDespesa) {
        setOpcao(formCadNaturezaDespesa, "excluir");
        carregarDadosFomulario(naturezaDespesa);
        if (confirm("Deseja realmente apagar a natureza de despesa: " + naturezaDespesa.nome + "?")) {
            submit();
        }

    };

    var carregarDadosFomulario = function (naturezaDespesa) {
        $("#id").val(naturezaDespesa.id);
        $("#codigo").val(naturezaDespesa.codigo);
        $("#nome").val(naturezaDespesa.nome);
        $("#situacao").prop({checked: (naturezaDespesa.situacao === "1") ? true : false});
        setSelected($("#selectTipo").children(), naturezaDespesa.tipo);
    };

    var alterar = function (naturezaDespesa) {
        carregarDadosFomulario(naturezaDespesa);
        setOpcao(formCadNaturezaDespesa, "alterar");
        mostarFormCadNaturezaDespesa();
    };

    var situacao = function (naturezaDespesa) {
        alterar(naturezaDespesa);
        $("#situacao").prop({checked: (naturezaDespesa.situacao === "1") ? false : true});
        submit();
    };


    var inicializar = function () {
        limparFormulario(formCadNaturezaDespesa);
        listar();
        setOpcao(formCadNaturezaDespesa, "inserir");
        mostarListaNDCadastradas();

    };

    inicializar();

    $(formCadNaturezaDespesa).submit(function (event) {
        event.preventDefault();
        submit();
    });


    $("#botaoNovoND").click(function () {
        limparFormulario(formCadNaturezaDespesa);
        setOpcao(formCadNaturezaDespesa, "inserir");
        mostarFormCadNaturezaDespesa();
    });

    $("#botaoCancelar").click(function () {
        limparFormulario(formCadNaturezaDespesa);
        mostarListaNDCadastradas();
    });

    $("#botaoPesquisarND").click(function () {
        var opcao = "listarPorNomeOuCodigo";
        var nome = $("#txtPesquisarND").val();
        var parametros = {opcao: opcao, nome: nome};
        var url = $("#url").val();
        requisicaoAjax(url, parametros, retornoListarAtivas);
    });

});
