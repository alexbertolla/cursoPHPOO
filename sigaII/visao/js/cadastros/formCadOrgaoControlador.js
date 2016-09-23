$(document).ready(function () {
    var formCadOrgaoControlador = $("#formCadOrgaoControlador");
    var divOrgaoControladoresCadastrados = $("#divOrgaoControladoresCadastrados");
    var spanOrgaoControladoresCadastrados = $("#spanOrgaoControladoresCadastrados");
    var divFormCadOrgaoControlador = $("#divFormCadOrgaoControlador");

    var mostrarDivListaCadastrados = function () {
        $(divOrgaoControladoresCadastrados).show();
        $(divFormCadOrgaoControlador).hide();
    };

    var mostrarDivFormCadastro = function () {
        $(divOrgaoControladoresCadastrados).hide();
        $(divFormCadOrgaoControlador).show();
    };

    var submit = function () {
        submeterFormulario(formCadOrgaoControlador, retornoSubmit);
    };

    var retornoSubmit = function (retornoSubmit) {
        exibirMensagem(retornoSubmit.estado, retornoSubmit.mensagem);
        if (retornoSubmit.estado === "sucesso") {
            inicializar();
        }
    };

    var listar = function () {
        var opcao = "listar";
        var parametros = {opcao: opcao};
        var url = $("#url").val();
        console.log(parametros);
        requisicaoAjax(url, parametros, retornoListar);
    };

    var retornoListar = function (retornoAjax) {
        console.log(retornoAjax);
        criarLista(retornoAjax.dados);
    };

    var criarLista = function (listaOC) {
        $(spanOrgaoControladoresCadastrados).children().remove();
        var ul = criarUl("", "", "", "");//id, nome, classes, li
        $(listaOC).each(function () {
            var orgaoControlador = $(this)[0];

            var labelNome = criarLabel("", "", orgaoControlador.nome);//id, nome, texto, classes
            
            var classeBotao = "botaoDesativar";
            var tituloBotao = "Desativar";
            
            if (orgaoControlador.situacao === "0") {
                setItemInativo(labelNome);
                classeBotao = "botaoAtivar";
                tituloBotao = "Ativar";
            }
            
            var buttonExcluir = criarButton("", "button", "", "Excluir", "botaoExcluir", function () {
                excluir(orgaoControlador);
            });//id, tipo, nome, titulo, classes, acao
            
            var buttonSituacao = criarButton("", "button", "", tituloBotao, classeBotao, function () {
                situacao(orgaoControlador);
            });
            
            var spanLabel = $("<span>").append(labelNome).addClass("spanLiCadastradosLabel");
            
            $(spanLabel).click(function (){
                alterar(orgaoControlador);
            });
            
            var spanBotao = $("<span>").append([buttonSituacao, buttonExcluir]).addClass("spanLiCadastradosButton");
            
            var li = criarLi("", "liListaCadastrados", [spanLabel,spanBotao]);//id, classes, conteudo
            
            $(ul).append(li);
        });
        $(spanOrgaoControladoresCadastrados).append(ul);
    };

    var excluir = function (orgaoControlador) {
        setOpcao(formCadOrgaoControlador, "excluir");
        carregarDadosNoFormulario(orgaoControlador);
        if (confirm("Deseja realmente excluir " + orgaoControlador.nome + "?")) {
            submit();
        }
    };


    var alterar = function (orgaoControlador) {
        setOpcao(formCadOrgaoControlador, "alterar");
        carregarDadosNoFormulario(orgaoControlador);
        mostrarDivFormCadastro();
    };

    var situacao = function (orgaoControlador) {
        alterar(orgaoControlador);
        $("#situacao").prop({checked: (orgaoControlador.situacao === "1") ? false : true});
        submit();
    };

    var carregarDadosNoFormulario = function (orgaoControlador) {
        $("#id").val(orgaoControlador.id);
        $("#nome").val(orgaoControlador.nome);
        $("#situacao").prop({checked: (orgaoControlador.situacao === "1") ? true : false});
    };

    var inicializar = function () {
        limparFormulario(formCadOrgaoControlador);
        listar();
        mostrarDivListaCadastrados();
    };

    inicializar();

    $(formCadOrgaoControlador).submit(function (event) {
        event.preventDefault();
        submit();
    });

    $("#botaoPesquisarOC").click(function () {
        var opcao = "listarPorNome";
        var nome = $("#txtPesquisaOC").val();
        var parametros = {opcao: opcao, nome: nome};
        var url = $("#url").val();
        requisicaoAjax(url, parametros, retornoListar);
    });

    $("#botaoNovoOC").click(function () {
        limparFormulario(formCadOrgaoControlador);
        setOpcao(formCadOrgaoControlador, "inserir");
        mostrarDivFormCadastro();
    });

    $("#botaoCancelar").click(function () {
        inicializar();
    });
});