$(document).ready(function () {
    var formCadGrupo = $("#formCadGrupo");
    var divListaGruposCadastrados = $(".panel-head-grupo");
    var divCadastroAuxiliar = $("#divCadastroAuxiliarGrupo");
    var spanCadAuxiliar = $("#spanCadastroAuxiliarGrupo");
    var divFormCadGrupo = $("#divFormCadGrupo");

    var naturezaDespesaId = 0;
    var contaContabilId = 0;

    var mostrarListaCadastrados = function () {
        $(divListaGruposCadastrados).show();
        $(spanCadAuxiliar).children().remove();
        $(divCadastroAuxiliar).hide();
        $(divFormCadGrupo).hide();
    };

    var mostrarFormularioCadastro = function () {
        $(divListaGruposCadastrados).hide();
        $(spanCadAuxiliar).children().remove();
        $(divCadastroAuxiliar).hide();
        $(divFormCadGrupo).show();
    };

    var mostrarCadastroAuxiliar = function () {
        $(divListaGruposCadastrados).hide();
        $(divCadastroAuxiliar).show();
        $(divFormCadGrupo).hide();
    };


    var inicializar = function () {
        limparFormulario(formCadGrupo);
        listar();
        listarND();
        listarCC();
        mostrarListaCadastrados();
    };

    var listarND = function () {
        var url = $("#urlND").val();
        var opcao = "listarAtivas";
        var parametros = {opcao: opcao};
        requisicaoAjax(url, parametros, retornoListarND);
    };

    var retornoListarND = function (retornoListarND) {
        if (retornoListarND.estado === "sucesso") {
            montarSelectND(retornoListarND.dados);
        }
    };

    var montarSelectND = function (listaND) {
        var selectND = $("#selectND");
        $(selectND).children().remove();
        var optionVazio = criarOption("", "# Selecione uma opção #", true);
        $(selectND).append(optionVazio);
        $(listaND).each(function () {
            var naturezaDespesa = $(this)[0];
            var option = criarOption(naturezaDespesa.id, naturezaDespesa.nome, false);
            $(option).click(function () {
                mudarND(naturezaDespesa);
            });
            $(selectND).append(option);
        });

        setSelected($(selectND).children(), naturezaDespesaId);

    };

    var mudarND = function (naturezaDespesa) {
        $("#tipo").val(naturezaDespesa.tipo);
    };

    var listarCC = function () {
        var url = $("#urlCC").val();
        var opcao = "listarAtivas";
        var parametros = {opcao: opcao};
        requisicaoAjax(url, parametros, retornoListarCC);
    };

    var retornoListarCC = function (retornoListarCC) {
        if (retornoListarCC.estado === "sucesso") {
            montarSelectCC(retornoListarCC.dados);
        }
    };

    var montarSelectCC = function (listaCC) {
        var selectCC = $("#selectCC");
        $(selectCC).children().remove();
        var optionVazio = criarOption("", "# Selecione uma opção #", false);
        $(selectCC).append(optionVazio);
        $(listaCC).each(function () {
            var contaContabil = $(this)[0];
            var option = criarOption(contaContabil.id, contaContabil.nome, false);
            $(selectCC).append(option);
        });
        setSelected($(selectCC).children(), contaContabilId);
    };


    var listar = function () {
        var url = $("#url").val();
        var opcao = "listar";
        var parametros = {opcao: opcao};
        requisicaoAjax(url, parametros, retornoListar);
    };

    var retornoListar = function (retornoAjax) {
        if (retornoAjax.estado === "sucesso") {
            var listaGrupo = retornoAjax.dados;
            montarListaGrupo(listaGrupo);
        }
    };

    var montarListaGrupo = function (listaGrupos) {
        var span = $("#spanListaGruposCadastrados");
        $(span).children().remove();
        var ul = criarUl();//id, nome, classe, li
        $(listaGrupos).each(function () {
            var grupo = $(this)[0];

            var classeBotao = "botaoDesativar";
            var tituloBotao = "Desativar";

            var labelNome = criarLabel("", "", grupo.codigo + " - " + grupo.nome, "");//id, nome, texto, classe

            if (grupo.situacao === "0") {
                setItemInativo(labelNome);
                tituloBotao = "Ativar";
                classeBotao = "botaoAtivar";
            }


            var buttonExcluir = criarButton("", "", "", "Excluir", "botaoExcluir", function () {
                excluir(grupo);
            });

            var buttonSituacao = criarButton("", "", "", tituloBotao, classeBotao, function () {
                situacao(grupo);
            });

            var spanLabel = $("<span>").append(labelNome).addClass("spanLiCadastradosLabel");

            $(spanLabel).click(function () {
                alterar(grupo);
            });

            var spanBotao = $("<span>").append([buttonSituacao, buttonExcluir]).addClass("spanLiCadastradosButton");

            var li = criarLi("", "liListaCadastrados", [spanLabel, spanBotao]);//id, classe, conteudo


            $(ul).append(li);
        });
        span.append(ul);
    };

    var excluir = function (grupo) {
        setOpcao(formCadGrupo, "excluir");
        carregaDadosNoFormulario(grupo);
        if (confirm("Deseja excluir " + grupo.nome + "?")) {
            submit();
        }
    };


    var alterar = function (grupo) {
        mostrarFormularioCadastro();
        setOpcao(formCadGrupo, "alterar");
        carregaDadosNoFormulario(grupo);
    };

    var situacao = function (grupo) {
        alterar(grupo);
        $("#situacao").prop({checked: (grupo.situacao === "1") ? false : true});
        submit();
    };

    var carregaDadosNoFormulario = function (grupo) {
        $("#id").val(grupo.id);
        $("#codigo").val(grupo.codigo);
        $("#nome").val(grupo.nome);
        $("#descricao").val(grupo.descricao);
        $("#situacao").prop({checked: (grupo.situacao === "1") ? true : false});
        $("#tipo").val(grupo.tipo);

        naturezaDespesaId = grupo.naturezaDespesaId;
        contaContabilId = grupo.contaContabilId;
        setSelected($("#selectND").children(), grupo.naturezaDespesaId);
        setSelected($("#selectCC").children(), grupo.contaContabilId);
    };

    var cadastrarNovo = function () {
        limparFormulario(formCadGrupo);
        setOpcao(formCadGrupo, "inserir");
        $("#codigoND").focus();
    };

    var submit = function () {
        submeterFormulario(formCadGrupo, retornoSubmit);
    };

    var retornoSubmit = function (retornoSubmit) {
        exibirMensagem(retornoSubmit.estado, retornoSubmit.mensagem);
        if (retornoSubmit.estado === "sucesso") {
            inicializar();
        }
    };

    var abrirCadastroAuxiliar = function (fomulario) {
        mostrarCadastroAuxiliar();
        $(spanCadAuxiliar).load(fomulario);
    };

    inicializar();

    $(formCadGrupo).submit(function (event) {
        event.preventDefault();
        submit();
    });



    $("#botaoNovoGrupo").click(function () {
        mostrarFormularioCadastro();
        cadastrarNovo();
    });

    $("#botaoCancelar").click(function () {
        inicializar();
    });

    $("#addND").click(function () {
        abrirCadastroAuxiliar("formCadNaturezaDespesa.html");

    });

    $("#addCC").click(function () {
        abrirCadastroAuxiliar("formCadContaContabil.html");
    });

    $("#fecharCadastroAuxiliar").click(function () {
        mostrarFormularioCadastro();
        listarND();
        listarCC();

    });

    $("#botaoPesquisarGrupo").click(function () {
        var opcao = "listarPorNomeOuCodigo";
        var nome = $("#txtPesquisaGrupo").val();
        var parametros = {opcao: opcao, nome: nome};
        var url = $("#url").val();
        requisicaoAjax(url, parametros, retornoListar);
    });


});