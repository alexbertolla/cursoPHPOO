$(document).ready(function () {
    var formCadObra = $("#formCadObra");

    var listarFuncionario = function () {
        var opcao = "listar";
        var urlFuncionario = $("#urlFuncionario").val();
        var parametros = {opcao: opcao};
        requisicaoAjax(urlFuncionario, parametros, retornoListarFuncionario);
    };

    var retornoListarFuncionario = function (retornoAjax) {
        if (retornoAjax.estado === "sucesso") {
            var lista = $("#dataListListaFuncionario");
            $(lista).children().remove();
            $(retornoAjax.dados).each(function () {
                var funcionario = $(this)[0];
                var option = criarOption(funcionario.nome, funcionario.nome, "");//valor, texto, selected
                $(option).attr({id: funcionario.matricula});
                $(lista).append(option);
            });
        }
    };


    var retornoSubmit = function (retornoSubmit) {
        if (retornoSubmit.estado === "sucesso") {
            inicializar();
        }
    };

    var listar = function () {
        var opcao = "listar";
        var parametros = {opcao: opcao};
        var url = $("#url").val();
        requisicaoAjax(url, parametros, retornoListar);
    };

    var retornoListar = function (retornoAjax) {
        montarLista(retornoAjax.dados);
    };

    var montarLista = function (listaObras) {
        var spanListaObrasCadastradas = $("#spanListaObrasCadastradas");
        var ul = criarUl();
        $(spanListaObrasCadastradas).children().remove();

        $(listaObras).each(function () {
            var obra = $(this)[0];
            var codigo = obra.codigo;
            var nome = obra.nome;
            var responsavel = obra.responsavelClass.nome;
            var local = obra.local;
            var texto = codigo + " - " + nome + " - " + responsavel + " - " + local;
            var labelObra = criarLabel("", "", texto, "");//id, nome, texto, classes

            var classeBotao = "btn btn-warning";
            var tituloBotao = "Desativar";
            if (obra.situacao === "0") {
                setItemInativo(labelObra);
                classeBotao = "btn btn-primary";
                tituloBotao = "Ativar";
            }

            var buttonSituacao = criarButton("", "button", "situacao", tituloBotao, classeBotao, function () {
                situacao(obra);
            });


            var buttonExcluir = criarButton("", "button", "excluir", "Excluir", "btn btn-danger", function () {
                excluir(obra);
            });

            var spanLabel = $("<span>").append(labelObra).addClass("spanLiCadastradosLabel");

            $(spanLabel).click(function () {
                alterar(obra);
            });

            var spanBotao = $("<span>").append([buttonSituacao, buttonExcluir]).addClass("spanLiCadastradosButton");

            var li = criarLi("", "liListaCadastrados", [spanLabel, spanBotao]);//id, classe, conteudo
            $(ul).append(li);
        });


        $(spanListaObrasCadastradas).append(ul);

    };


    var alterar = function (obra) {
        prepararFormularioParaCadastro();
        setOpcao(formCadObra, "alterar");
        carregarDadosNoFormulario(obra);
        mostrarFormularioCadastro();
    };

    var excluir = function (obra) {
        setOpcao(formCadObra, "excluir");
        carregarDadosNoFormulario(obra);
        if (confirm("Confirma exclusão?")) {
            submit();
        }
    };

    var situacao = function (obra) {
        alterar(obra);
        $("#situacao").prop({checked: (obra.situacao === "1") ? false : true});
        submit();
    };

    var carregarDadosNoFormulario = function (obra) {
        $("#id").val(obra.id);
        $("#codigo").val(obra.codigo);
        $("#nome").val(obra.nome);
        $("#descricao").val(obra.descricao);
        $("#responsavelNome").val(obra.responsavelClass.nome);
        $("#responsavel").val(obra.responsavel);
        $("#local").val(obra.local);
        $("#bemPrincipal").val(obra.bemPrincipal);
        $("#sustentavel").prop({checked: (obra.sustentavel === "1") ? true : false});
        $("#situacao").prop({checked: (obra.situacao === "1") ? true : false});

        grupoId = obra.grupoId;
        almoxarifadoId = obra.almoxarifadoVirtualId;

        setSelected($("#selectGrupo").children(), obra.grupoId);
        setSelected($("#selectAlmoxarifadoVirtual").children(), obra.almoxarifadoVirtualId);
//        setSelected($("#selectBemPrincipal").children(), obra.bemPrincipal);
    };


    var mostraListaObrasCadastradas = function () {
        $("#listaObrasCadastradas").show();
        $("#divCadastroAuxiliarObra").hide();
        $("#spanCadastroAuxiliarObra").children().remove();
        $("#divFormCadObra").hide();
    };

    var mostrarFormularioCadastro = function () {
        $("#listaObrasCadastradas").hide();
        $("#divCadastroAuxiliarObra").hide();
        $("#spanCadastroAuxiliarObra").children().remove();
        $("#divFormCadObra").show();
    };

    var mostrarCadastroAuxiliar = function (formCadastroAuxiliar) {
        $("#listaObrasCadastradas").hide();
        $("#divCadastroAuxiliarObra").show();
        $("#spanCadastroAuxiliarObra").children().remove();
        $("#spanCadastroAuxiliarObra").load(formCadastroAuxiliar);
        $("#divFormCadObra").hide();

    };

    var submit = function () {
        submeterFormulario(formCadObra, retornoSubmit);
    };

    var prepararFormularioParaCadastro = function () {
        limparFormulario(formCadObra);
        listarGrupoPorNaturezaDeDespesa();
        listarAlmoxarifadoVirtual();
        listarFuncionario();
//        listarLotacao();
    };


    var inicializar = function () {
        setNaturezaDespesa();
        limparFormulario(formCadObra);
        listar();
        mostraListaObrasCadastradas();
    };

    $(formCadObra).submit(function (event) {
        event.preventDefault();
        submit();
    });

    inicializar();

    $("#responsavelNome").change(function () {
        var nome = $(this).val();
        var lista = $("#dataListListaFuncionario option");
        var responsavel = $("#responsavel").val("");
        $(lista).each(function () {
            if ($(this).val() === nome) {
                $(responsavel).val($(this).prop("id"));
            }
        });
        if ($(responsavel).val() === "") {
            alert("Funcionário " + nome + " não cadastrado");
        }
    });

    $("#botaoNovaObra").click(function () {
        prepararFormularioParaCadastro();
        mostrarFormularioCadastro();
        setOpcao(formCadObra, "inserir");
    });

    $("#botaoCancelar").click(function () {
        inicializar();
    });


    $("#fecharCadastroAuxiliar").click(function () {
        listarAlmoxarifadoVirtual();
        mostrarFormularioCadastro();
    });

    $("#botaoAddGrupo").click(function () {
        mostrarCadastroAuxiliar("formCadGrupo.html")
    });

    $("#botaoAddAV").click(function () {
        mostrarCadastroAuxiliar("formCadAlmoxarifadoVirtual.html")
    });

    $("#botaoPesquisarObra").click(function () {
        pesquisar(retornoListar);
    });


});