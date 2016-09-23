$(document).ready(function () {
    console.log("TESTE");
    var formConfigurarDadosUnidade = $("#formConfigurarDadosUnidade");

    var buscarDadosUnidade = function () {
        var url = $("#url").val();
        var opcao = "buscarDadosUnidade";
        var parametros = {opcao: opcao};
        requisicaoAjax(url, parametros, function (retornoBuscarDadosUniadde) {
            console.log(retornoBuscarDadosUniadde);
            if (retornoBuscarDadosUniadde.estado === "sucesso") {
                carregarDadosNoFormulario(retornoBuscarDadosUniadde.dados);
            }
        });
    };

    var carregarDadosNoFormulario = function (dadosUnidade) {
        var endereco = dadosUnidade.endereco;
        $("#nome").val(dadosUnidade.nome);
        $("#sigla").val(dadosUnidade.sigla);
        $("#cnpj").val(dadosUnidade.cnpj);
        $("#inscricaoEstadual").val(dadosUnidade.inscricaoEstadual);
        $("#inscricaoMunicipal").val(dadosUnidade.inscricaoMunicipal);
        $("#codigoSiged").val(dadosUnidade.codigoSiged);
        $("#codigoUasg").val(dadosUnidade.codigoUasg);
        $("#telefone").val(dadosUnidade.telefone);

        $("#chefeGeral").val(dadosUnidade.chefeGeral);
        $("#chefeAdministrativo").val(dadosUnidade.chefeAdministrativo);

        $("#cep").val(endereco.cep);
        $("#logradouro").val(endereco.logradouro);
        $("#numero").val(endereco.numero);
        $("#complemento").val(endereco.complemento);
        $("#bairro").val(endereco.bairro);
        $("#cidade").val(endereco.cidade);
        $("#estado").val(endereco.estado);


    };

    var inicializarDadosUnidade = function () {
        buscarDadosUnidade();
    };

    inicializarDadosUnidade();

    $(formConfigurarDadosUnidade).submit(function (event) {
        event.preventDefault();
        submeterFormulario(formConfigurarDadosUnidade, function (retornoSalvarDadosUnidade) {
            console.log(retornoSalvarDadosUnidade);
            exibirAlerta(retornoSalvarDadosUnidade.estado, retornoSalvarDadosUnidade.mensagem);
            if (retornoSalvarDadosUnidade.estado === "sucesso") {
                carregarDadosNoFormulario(retornoSalvarDadosUnidade.dados);
            }
        });
    });
});