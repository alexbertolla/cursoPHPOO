$(document).ready(function () {

    var formCadAlmoxarifadoVirtual = $("#formCadAlmoxarifadoVirtual");
    var divListaAVCadastrados = $("#divListaAVCadastrados");
    var spanAVCadastrados = $("#spanAVCadastrados");
    var divFormCadAlmoxarifadoVirtual = $("#divFormCadAlmoxarifadoVirtual");

    var mostarDivListaAVCadastrados = function () {
        $(divListaAVCadastrados).show();
        $(divFormCadAlmoxarifadoVirtual).hide();
    };

    var mostarFormCadastro = function () {
        $(divListaAVCadastrados).hide();
        $(divFormCadAlmoxarifadoVirtual).show();
    };

    var submit = function () {
        submeterFormulario(formCadAlmoxarifadoVirtual, retornoSubmit);
    };

    var retornoSubmit = function (retornoSubmit) {
        exibirMensagem(retornoSubmit.estado, retornoSubmit.mensagem);
        if (retornoSubmit.estado === "sucesso") {
            inicializar();
        }
    };

    var retornoListar = function (retornoAjax) {
        if (retornoAjax.estado === "sucesso") {
            $(spanAVCadastrados).children().remove();
            var ul = criarUl("", "", "", "");
            $(retornoAjax.dados).each(function () {
                var almoxarifadoVirtual = $(this)[0];

                var classeBotao = "botaoDesativar";
                var tituloBotao = "Desativar";

                var labelAlmoxarifado = criarLabel("", "", almoxarifadoVirtual.nome, "");

                if (almoxarifadoVirtual.situacao === "0") {
                    setItemInativo(labelAlmoxarifado);
                    tituloBotao = "Ativar";
                    classeBotao = "botaoAtivar";

                }

                var buttonSituacao = criarButton("", "", "", tituloBotao, classeBotao, function () {
                    situacao(almoxarifadoVirtual);
                });

                var buttonExcluir = criarButton("", "", "", "Excluir", "botaoExcluir", function () {
                    excluir(almoxarifadoVirtual);
                });

                var spanLabel = $("<span>").append(labelAlmoxarifado).addClass("spanLiCadastradosLabel");

                $(spanLabel).click(function () {
                    alterar(almoxarifadoVirtual);
                });

                var spanBotao = $("<span>").append([buttonSituacao, buttonExcluir]).addClass("spanLiCadastradosButton");

                var li = criarLi("", "liListaCadastrados", [spanLabel, spanBotao]);
                $(ul).append(li);
            });
            $(spanAVCadastrados).append(ul);
        }
    };

    var alterar = function (almoxarifadoVirtual) {
        setOpcao(formCadAlmoxarifadoVirtual, "alterar");
        carregarDadosNoFormulario(almoxarifadoVirtual);
        mostarFormCadastro();
    };

    var excluir = function (almoxarifadoVirtual) {
        setOpcao(formCadAlmoxarifadoVirtual, "excluir");
        carregarDadosNoFormulario(almoxarifadoVirtual);
        if (confirm("Deseja realmente excluir " + almoxarifadoVirtual.nome + "?")) {
            submit();
        }
    };

    var situacao = function (almoxarifadoVirtual) {
        alterar(almoxarifadoVirtual);
        $("#situacao").prop({checked: (almoxarifadoVirtual.situacao === "1") ? false : true});
        submit();
    };

    var carregarDadosNoFormulario = function (almoxarifadoVirtual) {
        $("#id").val(almoxarifadoVirtual.id);
        $("#nome").val(almoxarifadoVirtual.nome);
        $("#situacao").prop({checked: (almoxarifadoVirtual.situacao === "1") ? true : false});
    };

    var listar = function () {
        var opcao = "listar";
        var url = $("#url").val();
        var parametros = {opcao: opcao};
        requisicaoAjax(url, parametros, retornoListar);
    };

    var inicializar = function () {
        limparFormulario(formCadAlmoxarifadoVirtual);
        listar();
        mostarDivListaAVCadastrados();
    };

    inicializar();

    $(formCadAlmoxarifadoVirtual).submit(function (event) {
        event.preventDefault();
        submit();
    });

    $("#novoAV").click(function () {
        limparFormulario(formCadAlmoxarifadoVirtual);
        setOpcao(formCadAlmoxarifadoVirtual, "inserir");
        mostarFormCadastro()
    });

    $("#botaoCancelar").click(function () {
        inicializar();
    });

    $("#pesquisarAV").click(function () {
        var opcao = "listarPorNome";
        var nome = $("#txtPesquisaAV").val();
        var parametros = {opcao: opcao, nome: nome};
        var url = $("#url").val();
        requisicaoAjax(url, parametros, retornoListar);
    });
});