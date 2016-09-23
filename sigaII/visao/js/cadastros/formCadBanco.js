$(document).ready(function () {
    var formularioCadBanco = $("#formCadBanco");
    var divBancosCadastrados = $("#divBancosCadastrados");
    var spanBancosCadastrados = $("#spanBancosCadastrados");
    var divFormCadBanco = $("#divFormCadBanco");

    var mostarDivBancosCadastrados = function () {
        $(divBancosCadastrados).show();
        $(divFormCadBanco).hide();
    };

    var mostarFormCadastro = function () {
        $(divBancosCadastrados).hide();
        $(divFormCadBanco).show();
    };

    var listar = function () {
        var opcao = "listar";
        var url = $("#url").val();
        var parametros = {opcao: opcao};

        requisicaoAjax(url, parametros, retornoListar);
    };

    var retornoListar = function (retornoAjax) {
        console.log(retornoAjax);
        montarListaBancosCadastrados(retornoAjax.dados);
    };

    var montarListaBancosCadastrados = function (listaBancos) {
        $(spanBancosCadastrados).children().remove();
        var ul = criarUl();//(id, nome, classes, li)
        $(listaBancos).each(function () {
            var banco = $(this)[0];
            var textoBanco = banco.codigo + " - " + banco.nome;
            var situacao = $(this)[0].situacao;

            var labelBanco = criarLabel("", "", textoBanco, "");//(id, nome, texto, classes)
            var classeBotao = "botaoDesativar";

            if (situacao === "0") {
                setItemInativo(labelBanco);
                classeBotao = "botaoAtivar";
            }
            var buttonSituacao = criarButton("", "button", "setSituacao", "Ativar/Desativar", classeBotao, function () {
                setSituacao(banco);
            });//(id, tipo, nome, titulo, classes, acao)

            var buttonExcluir = criarButton("", "button", "excluir", "Excluir", "botaoExcluir", function () {
                excluir(banco);
            });//(id, tipo, nome, titulo, classes, acao)

            var spanLabel = $("<span>").append(labelBanco).addClass("spanLiCadastradosLabel");
            
            $(spanLabel).click(function (){
                alterar(banco);
            });
            
            var spanBotao = $("<span>").append([buttonSituacao, buttonExcluir]).addClass("spanLiCadastradosButton");

            var li = criarLi("", "liListaCadastrados", [spanLabel, spanBotao]);//(id, classes, conteudo)
            $(ul).append(li);
        });
        $(spanBancosCadastrados).append(ul);
    };

    var alterar = function (banco) {
        setOpcao(formularioCadBanco, "alterar");
        carregarDadosNoFormulario(banco);
        mostarFormCadastro();
    };

    var excluir = function (banco) {
        setOpcao(formularioCadBanco, "excluir");
        carregarDadosNoFormulario(banco);
        if (confirm("Deseja realmente excluir [" + banco.nome + "]:")) {
            submit();
        }
    };

    var setSituacao = function (banco) {
        alterar(banco);
        $("#situacao").prop({checked: (banco.situacao === "1") ? false : true});
        submit();
    };

    var carregarDadosNoFormulario = function (banco) {
        $("#id").val(banco.id);
        $("#codigo").val(banco.codigo);
        $("#nome").val(banco.nome);
        $("#situacao").prop({checked: (banco.situacao === "1") ? true : false});
    };

    var submit = function () {
        submeterFormulario(formularioCadBanco, retornoSubmit)
    };

    var retornoSubmit = function (retornoSubmit) {
        console.log(retornoSubmit);
        inicializar();
    };

    var inicializar = function () {
        limparFormulario(formularioCadBanco);
        listar();
        mostarDivBancosCadastrados();
    };

    inicializar();

    $(formularioCadBanco).submit(function (event) {
        event.preventDefault();
        submit();
    });

    $("#botaoNovoBanco").click(function () {
        limparFormulario(formularioCadBanco);
        setOpcao(formularioCadBanco, "inserir");
        mostarFormCadastro();
    });

    $("#botaoCancelar").click(function () {
        inicializar();
    });

    $("#botaoPesquisarBanco").click(function () {
        var opcao = "listarPorNome";
        var nome = $("#txtPesquisaBanco").val();
        var parametros = {opcao: opcao, nome: nome};
        var url = $("#url").val();
        requisicaoAjax(url, parametros, retornoListar);
    });


});
    