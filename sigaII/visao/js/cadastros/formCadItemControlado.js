$(document).ready(function () {
    var formCadItemControlado = $("#formCadItemControlado");
    var divFormCadastroAuxiliar = $("#divFormCadastroAuxiliarIC");
    var spanFormCadastroAuxiliar = $("#spanFormCadastroAuxiliar");
    var spanListaItensControladosCadastrados = $("#spanListaItensControladosCadastrados");
    var divListaItensControladosCadastrados = $("#divListaItensControladosCadastrados");
    var divFormCadItemControlado = $("#divFormCadItemControlado");

    var grupoId = 0;
    var orgaoControladorId = 0;

    var listar = function () {
        var opcao = "listar";
        var url = $("#url").val();
        var parametros = {opcao: opcao};
        requisicaoAjax(url, parametros, retornoListar);
    };

    var retornoListar = function (retornoListar) {
        if (retornoListar.estado === "sucesso") {
            montarLista(retornoListar.dados);
        }
    };

    var montarLista = function (listaItensControlados) {
        console.log(listaItensControlados);
        $(spanListaItensControladosCadastrados).children().remove();
        var ul = criarUl();//id, nome, classes, li
        $(listaItensControlados).each(function () {
            var itemControlado = $(this)[0];
            var descricaoItem = itemControlado.nome + " " +
                    itemControlado.quantidade +
                    itemControlado.apresentacaoComercial + " - " +
                    itemControlado.orgaoControlador.nome +
                    " (" + itemControlado.grupo.nome + ")";
            var labelItemControlado = criarLabel("", "", descricaoItem, "");//id, nome, texto, classes

            var classeBotao = "botaoDesativar";
            var tituloBotao = "Desativar";
            if (itemControlado.situacao === "0") {
                setItemInativo(labelItemControlado);
                classeBotao = "botaoAtivar";
                tituloBotao = "Ativar";

            }


            var buttonExcluir = criarButton("", "", "", "Excluir", "botaoExcluir", function () {
                excluir(itemControlado);
            });

            var buttonSituacao = criarButton("", "", "", tituloBotao, classeBotao, function () {
                situacao(itemControlado);
            });

            var spanLabel = $("<span>").append(labelItemControlado).addClass("spanLiCadastradosLabel");

            $(spanLabel).click(function () {
                alterar(itemControlado);
            });

            var spanBotao = $("<span>").append([buttonSituacao, buttonExcluir]).addClass("spanLiCadastradosButton");

            var li = criarLi("", "liListaCadastrados", [spanLabel, spanBotao]);//id, classes, conteudo
            $(ul).append(li);
        });
        $(spanListaItensControladosCadastrados).append(ul);
    };


    var excluir = function (itemControlado) {
        setOpcao(formCadItemControlado, "excluir");
        carregarDadosNoFormulario(itemControlado);
        if (confirm("Deseja realmente excluir " + itemControlado.nome + "?")) {
            submit();
        }
    };


    var alterar = function (itemControlado) {
        setOpcao(formCadItemControlado, "alterar");
        carregarDadosNoFormulario(itemControlado);
        mostrarFormCadastro();
    };

    var situacao = function (itemControlado) {
        alterar(itemControlado);
        $("#situacao").prop({checked: (itemControlado.situacao === "1") ? false : true});
        submit();
    };

    var carregarDadosNoFormulario = function (itemControlado) {
        $("#id").val(itemControlado.id);
        $("#nome").val(itemControlado.nome);
        $("#quantidade").val(itemControlado.quantidade);
        $("#apresentacaoComercial").val(itemControlado.apresentacaoComercial);
        $("#fonte").val(itemControlado.fonte);
        $("#situacao").prop({checked: (itemControlado.situacao === "1") ? true : false});
        $("#codigoGrupo").val(itemControlado.grupo.codigo);
        $("#grupoId").val(itemControlado.grupoId);

        setSelected($("#selectGrupo").children(), itemControlado.grupoId);
        setSelected($("#selectOrgaoControlador").children(), itemControlado.orgaoControladorId);

        grupoId = itemControlado.grupoId;
        orgaoControladorId = itemControlado.orgaoControladorId;
    };

    var listarOrgaoControlador = function () {
        var opcao = "listarAtivos";
        var parametros = {opcao: opcao};
        var url = $("#urlOrgaoControlador").val();
        requisicaoAjax(url, parametros, retornoListarOrgaoControlador);
    };

    var retornoListarOrgaoControlador = function (retornoAjax) {
        if (retornoAjax.estado === "sucesso") {
            montarSelectOrgaoControlador(retornoAjax.dados);
        }
    };

    var montarSelectOrgaoControlador = function (listaOrgaoControlador) {
        var select = $("#selectOrgaoControlador");
        $(select).children().remove();
        $(listaOrgaoControlador).each(function () {
            var orgaoControlador = $(this)[0];
            var option = criarOption(orgaoControlador.id, orgaoControlador.nome, false);//valor, texto, selected
            $(select).append(option);
        });
        setSelected($(select).children(), orgaoControladorId);
    };

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

    var submit = function () {
        submeterFormulario(formCadItemControlado, retornoSubmit);
    };

    var retornoSubmit = function (retornoSubmit) {
        exibirMensagem(retornoSubmit.estado, retornoSubmit.mensagem);
        if (retornoSubmit.estado === "sucesso") {
            inicializar();
        }
    };

    var inicializar = function () {
        limparFormulario(formCadItemControlado);
        listar();
        listarOrgaoControlador();
        listarGrupo();
        mostrarListaCadastrados();
    };

    var mostrarListaCadastrados = function () {
        $(divListaItensControladosCadastrados).show();
        $(divFormCadastroAuxiliar).hide();
        $(spanFormCadastroAuxiliar).children().remove();
        $(divFormCadItemControlado).hide();
    };

    var mostrarFormCadastro = function () {
        $(divListaItensControladosCadastrados).hide();
        $(divFormCadastroAuxiliar).hide();
        $(spanFormCadastroAuxiliar).children().remove();
        $(divFormCadItemControlado).show();
    };

    var mostrarCadastroAuxiliar = function (formCadastroAuxiliar) {
        $(divListaItensControladosCadastrados).hide();
        $(divFormCadastroAuxiliar).show();
        $(spanFormCadastroAuxiliar).load(formCadastroAuxiliar);
        $(divFormCadItemControlado).hide();
    };



    inicializar();

    $(formCadItemControlado).submit(function (event) {
        event.preventDefault();
        submit();
    });


    $("#botaoNovoIC").click(function () {
        limparFormulario(formCadItemControlado);
        setOpcao(formCadItemControlado, "inserir");
        mostrarFormCadastro();
    });

    $("#botaoCancelar").click(function () {
        inicializar();
    });

    $("#addGrupo").click(function () {
        mostrarCadastroAuxiliar("formCadGrupo.html");
    });

    $("#addOC").click(function () {
        mostrarCadastroAuxiliar("formCadOrgaoControlador.html");
    });

    $("#fecharCadastroAuxiliarIC").click(function () {
        mostrarFormCadastro();
        listarOrgaoControlador();
    });

    $("#botaoPesquisarIC").click(function () {
        var opcao = "listarPorNome";
        var nome = $("#txtPesquisaIC").val();
        var parametros = {opcao: opcao, nome: nome};
        var url = $("#url").val();
        requisicaoAjax(url, parametros, retornoListar);
    });
});