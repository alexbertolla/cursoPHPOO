
    var formCadDadosBancariosFornecedor = $("#formCadDadosBancariosFornecedor");
    var divListaDadosBancariosCadastrados = $("#divListaDadosBancariosCadastrados");
    var divCadastroAuxiliarDadosBancarios = $("#divCadastroAuxiliarDadosBancarios");
    var spanCadastroAuxiliarDadosBancarios = $("#spanCadastroAuxiliarDadosBancarios");
    var divFormCadastroDadosBancarios = $("#divFormCadastroDadosBancarios");
    var fornecedorId;
    var urlBanco = $(formCadDadosBancariosFornecedor).find("#url").val();


    var carregarDadosBancariosNoFormulario = function (fID) {
        fornecedorId = fID;
        inicializar();
    };


    var mostarDivDadosBancariosCadastrados = function () {
//        $(divListaDadosBancariosCadastrados).show();
//        $(divCadastroAuxiliarDadosBancarios).hide();
//        $(divFormCadastroDadosBancarios).hide();
    };

    var mostarDivFormCadastroDadosBancarios = function () {
//        $(divListaDadosBancariosCadastrados).hide();
//        $(divCadastroAuxiliarDadosBancarios).hide();
//        $(divFormCadastroDadosBancarios).show();
    };

    var mostarDivCadastroAuxiliarDadosBancarios = function () {
        $(divListaDadosBancariosCadastrados).hide();
        $(divCadastroAuxiliarDadosBancarios).show();
        $(divFormCadastroDadosBancarios).hide();
    };

    var listar = function () {
        var opcao = "listarPorFornecedorId";
        var parametros = {opcao: opcao, fornecedorId: fornecedorId};
        requisicaoAjax(urlBanco, parametros, retornoListar);
    };

    var retornoListar = function (retornoListar) {
        if (retornoListar.estado === "sucesso") {
            montarListaDadosBancarios(retornoListar.dados);
        }
    };

    var montarListaDadosBancarios = function (listaDadosBancarios) {
        var tabela = $("#tabelaContas");
        var tbody = tabela.children("tbody");
        tbody.children().remove();
        
        $(listaDadosBancarios).each(function () {
            var dadosBancarios = $(this)[0];
            
            var texto = dadosBancarios.Banco.nome + " - Agência: " + dadosBancarios.agencia + ", Conta: " + dadosBancarios.conta;
            var tdTexto = $("<td>").append(texto);

            var classeBotao = "botaoDesativar";
            var tituloBotao = "Desativar";
            if (dadosBancarios.situacao === "0") {
                setItemInativo(label);
                classeBotao = "botaoAtivar";
                tituloBotao = "Ativar";
            }

            var buttonSituacao = criarButton("", " button", "", tituloBotao, classeBotao, function () {
                situacao(dadosBancarios);
            });

            var buttonExcluir = criarButton("", " button", "", "Excluir", "botaoExcluir", function () {
                excluir(dadosBancarios);
            });
            
            var tdExcluirConta = $("<td>").append(buttonExcluir);

            $(tdTexto).click(function () {
                alterar(dadosBancarios);
            });

            var tr = $("<tr>").append([tdTexto, tdExcluirConta]);

            tbody.append(tr);
        });
    };

    var situacao = function (dadosBancarios) {
        alterar(dadosBancarios);
        $("#situacao").prop({checked: (dadosBancarios.situacao) === "1" ? false : true});
        submeter();
    };

    var excluir = function (dadosBancarios) {
        setOpcao(formCadDadosBancariosFornecedor, "excluir");
        carregarDadosNoFormulario(dadosBancarios);
        if (confirm("Confirma exclusão ?")) {
            submeter();
        } else {
            inicializar();
        }
    };

    var alterar = function (dadosBancarios) {
//        limparFormulario(formCadDadosBancariosFornecedor);
        setOpcao(formCadDadosBancariosFornecedor, "alterar");
        carregarDadosNoFormulario(dadosBancarios);
        //mostarDivFormCadastroDadosBancarios();
    };

    var carregarDadosNoFormulario = function (dadosBancarios) {
        $("#id").val(dadosBancarios.id);
        $("#fornecedorId").val(dadosBancarios.fornecedorId);
        $("#agencia").val(dadosBancarios.agencia);
        $("#conta").val(dadosBancarios.conta);
        $("#situacao").prop({checked: (dadosBancarios.situacao) === "1" ? true : false});

        setSelected($("#selectBanco").children(), dadosBancarios.bancoId);
    };


    var listarBancosAtivos = function () {
        var opcao = "listarAtivos";
        var url = $("#urlBanco").val();
        var parametros = {opcao: opcao, fornecedorId: 1};
        requisicaoAjax(url, parametros, retornoListarBancosAtivos);
    };

    var retornoListarBancosAtivos = function (retornoListarBancosAtivos) {
        if (retornoListarBancosAtivos.dados.length > 0) {
            montarSelectBanco(retornoListarBancosAtivos.dados);
        }
    };

    var montarSelectBanco = function (listaBanco) {
        var select = $("#selectBanco");
        $(select).children().remove();
        $(listaBanco).each(function () {
            var banco = $(this)[0];
            var labelBanco = banco.codigo + " - " + banco.nome;
            var option = criarOption(banco.id, labelBanco, false);
            $(select).append(option);
        });
    };


    var inicializar = function () {
        limparFormulario(formCadDadosBancariosFornecedor);
        $(formCadDadosBancariosFornecedor).find("#fornecedorId").val(fornecedorId);
        setOpcao(formCadDadosBancariosFornecedor, "inserir");
        listarBancosAtivos();
        listar();
        mostarDivDadosBancariosCadastrados();
    };

    var submeter = function () {
        submeterFormulario(formCadDadosBancariosFornecedor, retornoSubmit);
    };

    var retornoSubmit = function (retornoSubmit) {
        console.log(retornoSubmit);
        if (retornoSubmit.estado === "sucesso") {
            inicializar();
        }
    };

    

    $("#botaoNovoDadosBancario").click(function () {
        setOpcao(formCadDadosBancariosFornecedor, "inserir");
        mostarDivFormCadastroDadosBancarios();
    });

    $("#addBanco").click(function () {
        mostarDivCadastroAuxiliarDadosBancarios();
        $(spanCadastroAuxiliarDadosBancarios).load("formCadBanco.html", function () {
            $("#novoBanco").click();
        });
    });

    $("#botaoCancelar").click(function () {
        inicializar();
    });

    $("#fecharCadastroAuxiliar").click(function () {
        listarBancosAtivos();
        mostarDivFormCadastroDadosBancarios();
    });


