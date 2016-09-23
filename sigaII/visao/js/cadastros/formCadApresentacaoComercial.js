$(document).ready(function () {
    var formCadApresentacaoComercial = $("#formCadApresentacaoComercial");
    var divListaApresentacaoComercialCadastradas = $("#divListaApresentacaoComercialCadastradas");
    var divCadastroGrupo = $("#divCadastroGrupo");
    var spanCadastroGrupo = $("#spanCadastroGrupo");
    var divFormCadApresentacaoComercial = $("#divFormCadApresentacaoComercial");

    var grupoId = 0;

    var listarGrupo = function () {
        var opcao = "listarAtivos";
        var parametros = {opcao: opcao};
        var url = $("#urlGrupo").val();
        requisicaoAjax(url, parametros, retornoListarGrupo);
    };

    var retornoListarGrupo = function (retornoAjax) {
        if (retornoAjax.estado === "sucesso") {
            montarSelectGrupo(retornoAjax.dados);
        }
    };

    var montarSelectGrupo = function (listaGrupo) {
        var select = $("#selectGrupo");
        $(select).children().remove();
        $(listaGrupo).each(function () {
            var grupo = $(this)[0];
            var option = criarOption(grupo.id, grupo.codigo + " - " + grupo.nome, false);//valor, texto, selected
            $(select).append(option);
        });
        setSelected($(select).children(), grupoId);
    };


    var listar = function () {
        var url = $("#url").val();
        var opcao = "listar";
        var parametros = {opcao: opcao};
        requisicaoAjax(url, parametros, retornoListar);

    };

    var retornoListar = function (retornoAjax) {
        montarLista(retornoAjax.dados);
    };

    var montarLista = function (listaAC) {
        var span = $("#spanListaApresentacaoComercialCadastradas");
        var ul = criarUl();//id, nome, classes, li
        $(span).children().remove();
        $(listaAC).each(function () {
            var apresentacaoComercial = $(this)[0];
            var apresentacaoComercialTexto = apresentacaoComercial.nome
                    + ", " + apresentacaoComercial.quantidade
                    + " " + apresentacaoComercial.apresentacaoComercial
                    + " (" + apresentacaoComercial.grupo.nome + ")";
            var labelApresentacaoComercial = criarLabel("", "", apresentacaoComercialTexto, "");//id, nome, texto, classes

            var classeBotao = "botaoDesativar";
            var tituloBotao = "Desativar";

            if (apresentacaoComercial.situacao === "0") {
                setItemInativo(labelApresentacaoComercial);
                tituloBotao = "Ativar";
                classeBotao = "botaoAtivar";
            }

            var buttonSituacao = criarButton("", "button", "", tituloBotao, classeBotao, function () {
                situacao(apresentacaoComercial);
            });


            var buttonExcluir = criarButton("", "button", "", "Excluir", "botaoExcluir", function () {
                excluir(apresentacaoComercialTexto, apresentacaoComercial);
            });

            var spanLabel = $("<span>").append(labelApresentacaoComercial).addClass("spanLiCadastradosLabel");

            $(spanLabel).click(function () {
                alterar(apresentacaoComercial);
            });

            var spanBotao = $("<span>").append([buttonSituacao, buttonExcluir]).addClass("spanLiCadastradosButton");

            var li = criarLi("", "liListaCadastrados", [spanLabel, spanBotao]);//id, classes, conteudo
            $(ul).append(li);
        });
        $(span).append(ul);
    };

    var excluir = function (apresentacaoComercialTexto, apresentacaoComercial) {
        setOpcao(formCadApresentacaoComercial, "excluir");
        carregarDadosNoFormulario(apresentacaoComercial);
        if (confirm("Deseja apagar " + apresentacaoComercialTexto + "?")) {
            submit();
        } else {
            inicializar();
        }
    };

    var alterar = function (apresentacaoComercial) {
//        limparFormulario(formCadApresentacaoComercial);
        setOpcao(formCadApresentacaoComercial, "alterar");

        carregarDadosNoFormulario(apresentacaoComercial);
        mostarFormCadApresentacaoComercial();
    };

    var situacao = function (apresentacaoComercial) {
        alterar(apresentacaoComercial);
        $("#situacao").prop({checked: (apresentacaoComercial.situacao === "1") ? false : true});
        submit();
    };


    var carregarDadosNoFormulario = function (apresentacaoComercial) {
        $("#id").val(apresentacaoComercial.id);
        $("#nome").val(apresentacaoComercial.nome);
        $("#apresentacaoComercial").val(apresentacaoComercial.apresentacaoComercial);
        $("#quantidade").val(apresentacaoComercial.quantidade);

        $("#situacao").prop({checked: (apresentacaoComercial.situacao === "1") ? true : false});

        setSelected($("#selectGrupo").children(), apresentacaoComercial.grupoId);

        grupoId = apresentacaoComercial.grupoId;
    };


    var submit = function () {
        submeterFormulario(formCadApresentacaoComercial, retornoSubmit);
    };

    var retornoSubmit = function (retornoSubmit) {
        exibirMensagem(retornoSubmit.estado, retornoSubmit.mensagem);
        if (retornoSubmit.estado === "sucesso") {
            inicializar();
        }
    };

    var mostarListaCadastrados = function () {
        $(divListaApresentacaoComercialCadastradas).show();
        $(divCadastroGrupo).hide();
        $(spanCadastroGrupo).children().remove();
        $(divFormCadApresentacaoComercial).hide();
    };

    var mostarFormCadApresentacaoComercial = function () {
        $(divListaApresentacaoComercialCadastradas).hide();
        $(divCadastroGrupo).hide();
        $(spanCadastroGrupo).children().remove();
        $(divFormCadApresentacaoComercial).show();
    };

    var mostarFormCadGrupo = function () {
        $(divListaApresentacaoComercialCadastradas).hide();
        $(divCadastroGrupo).show();
        $(spanCadastroGrupo).load("formCadGrupo.html");
        $(divFormCadApresentacaoComercial).hide();
    };



    var inicializar = function () {
        limparFormulario(formCadApresentacaoComercial);
        listar();
        listarGrupo();
        mostarListaCadastrados();
    };



    inicializar();

    $(formCadApresentacaoComercial).submit(function (event) {
        event.preventDefault();
        submit();
    });

    $("#novoApresentacaoComercial").click(function () {
        limparFormulario(formCadApresentacaoComercial);
        setOpcao(formCadApresentacaoComercial, "inserir");
        mostarFormCadApresentacaoComercial();
    });


    $("#botaoCancelar").click(function () {
        inicializar();
    });

    $("#addGrupo").click(function () {
        mostarFormCadGrupo();
    });

    $("#fecharCadastroGrupo").click(function () {
        mostarFormCadApresentacaoComercial();
        listarGrupo();
    });

    $("#botaoPesquisarAC").click(function () {
        var opcao = "listarPorNome";
        var nome = $("#txtPesquisaAC").val();
        var parametros = {opcao: opcao, nome: nome};
        var url = $("#url").val();
        requisicaoAjax(url, parametros, retornoListar);
    });


});