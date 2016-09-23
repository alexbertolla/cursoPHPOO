$(document).ready(function () {
    var formConfigItensDeCompra = $("#formConfigItensDeCompra");
    var divListaICCadastrados = $("#divListaICCadastrados");
    var spanICCadastrados = $("#spanICCadastrados");
    var divFormConfigItensDeCompra = $("#divFormConfigItensDeCompra");

    var mostrarItensDeCompraCadastrados = function () {
        $(divListaICCadastrados).show();
        $(divFormConfigItensDeCompra).hide();
    };

    var mostrarFormularioCadastro = function () {
        (divListaICCadastrados).hide();
        $(divFormConfigItensDeCompra).show();
    };


    var listar = function () {
        var url = $("#url").val();
        var opcao = "listar";
        var parametros = {opcao: opcao};
        requisicaoAjax(url, parametros, retornoListar);
    };

    var retornoListar = function (retornoListar) {
        if (retornoListar.estado === "sucesso") {
            var lista = retornoListar.dados;
            montarLista(lista);
        }
    };

    var montarLista = function (lista) {

        $(spanICCadastrados).children().remove();
        var ul = criarUl();//id, nome, classe, li
        $(lista).each(function () {
//            console.log($(this)[0]);
            var itensDeCompra = $(this)[0];
            var labelNome = criarLabel("", "", itensDeCompra.nome, "");//id, nome, texto, classe

            var buttonExcluir = criarButton("", "", "", "Excluir", "botaoExcluir", function () {
                excluir(itensDeCompra);
            });

            var spanLabel = $("<span>").append(labelNome).addClass("spanLiCadastradosLabel");

            $(spanLabel).click(function () {
                alterar(itensDeCompra);
            });

            var spanBotao = $("<span>").append([buttonExcluir]).addClass("spanLiCadastradosButton");

            var li = criarLi("", "liListaCadastrados", [spanLabel, spanBotao]);//id, classe, conteudo
            $(ul).append(li);
        });
        $(spanICCadastrados).append(ul);
    };

    var excluir = function (itensDeCompra) {
        setOpcao(formConfigItensDeCompra, "excluir");
        carregaDadosNoFormulario(itensDeCompra);
        if (confirm("Deseja excluir " + itensDeCompra.nome + "?")) {
            submit();
        }
    };

    var alterar = function (itensDeCompra) {
        setOpcao(formConfigItensDeCompra, "alterar");
        carregaDadosNoFormulario(itensDeCompra);
        mostrarFormularioCadastro();
    };

    var carregaDadosNoFormulario = function (itensDeCompra) {
        $("#id").val(itensDeCompra.id);
        $("#nome").val(itensDeCompra.nome);
        $("#nomeApresentacao").val(itensDeCompra.nomeApresentacao);
        $("#descricao").val(itensDeCompra.descricao);
        $("#arquivo").val(itensDeCompra.arquivo);
        setSelected($("#selectND").children(), itensDeCompra.naturezaDespesaId);
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

        $(listaND).each(function () {
            var naturezaDespesa = $(this)[0];
            var option = criarOption(naturezaDespesa.id,naturezaDespesa.nome, false);
            $(selectND).append(option);
        });

    };

    var submit = function () {
        submeterFormulario(formConfigItensDeCompra, retornoSubmit);
    };

    var retornoSubmit = function (retornoSubmit) {
        exibirMensagem(retornoSubmit.estado, retornoSubmit.mensagem);
        if (retornoSubmit.estado === "sucesso") {
            exibirAlerta("","Para que as mudanças apareçam no menu, é necessário sair e entrar novamente no sistema!");
            inicializar();
        }
    };

    var inicializar = function () {
        limparFormulario(formConfigItensDeCompra);
        listarND();
        listar();
        mostrarItensDeCompraCadastrados();
    };

    inicializar();

    $(formConfigItensDeCompra).submit(function (event) {
        event.preventDefault();
        submit();
    });



    $("#botaoNovoIC").click(function () {
        limparFormulario(formConfigItensDeCompra);
        setOpcao(formConfigItensDeCompra, "inserir");
        mostrarFormularioCadastro();

    });

    $("#botaoCancelar").click(function () {
        inicializar();
    });

    $("#addND").click(function () {
        mostrarDivCadastroAuxiliar("formCadNaturezaDespesa.html");

    });


    $("#botaoPesquisarIC").click(function () {
        var opcao = "listarPorNome";
        var nome = $("#txtPesquisaIC").val();
        var parametros = {opcao: opcao, nome: nome};
        var url = $("#url").val();
        requisicaoAjax(url, parametros, retornoListar);
    });
});