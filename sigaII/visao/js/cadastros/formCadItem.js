var naturezaDespesaIdGlobal;
var grupoId = 0;
var almoxarifadoId = 0;

var setNaturezaDespesa = function (naturezaDespesaId) {
    $("#naturezaDespesaId").val(naturezaDespesaId);
};


var listarAlmoxarifadoVirtual = function () {
    var opcao = "listarAtivos";
    var parametros = {opcao: opcao};
    var url = $("#urlAlmoxarifadoVirtual").val();
    requisicaoAjax(url, parametros, retornoListarAlmoxarifadoVirtual);
};

var retornoListarAlmoxarifadoVirtual = function (retornoAjax) {
    if (retornoAjax.estado === "sucesso") {
        montarSelectAlmoxarifadoVirtual(retornoAjax.dados);
    }
};

var montarSelectAlmoxarifadoVirtual = function (listaAlmoxarifadoVirtual) {
    var select = $("#selectAlmoxarifadoVirtual");
    $(select).children().remove();
    $(listaAlmoxarifadoVirtual).each(function () {
        var almoxarifadoVirtual = $(this)[0];
        var option = criarOption(almoxarifadoVirtual.id, almoxarifadoVirtual.nome, false);//valor, texto, selected
        $(select).append(option);
    });
    setSelected($(select).children(), almoxarifadoId);
};


var listarGrupoPorNaturezaDeDespesa = function () {
    var opcao = "listarAtivosPorTipoNaturezaDespesa";
    var tipoNaturezaDespesa = $("#tipoNaturezaDespesa").val();
    var parametros = {opcao: opcao, tipoNaturezaDespesa: tipoNaturezaDespesa};
    var url = $("#urlGrupo").val();
    requisicaoAjax(url, parametros, retornolistarGrupo);
};

var retornolistarGrupo = function (retornoAjax) {
    if (retornoAjax.estado === "sucesso") {
        setNaturezaDespesa(retornoAjax.dados[0].naturezaDespesaId);
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
//    listarApresentacaoComercialPorGrupo();
};

var listarApresentacaoComercialPorGrupo = function () {
    var opcao = "listarPorGrupoAtivo";
    var grupoId = $("#selectGrupo").val();
    var parametros = {opcao: opcao, grupoId: grupoId};
    var url = $("#urlApresentacaoComercial").val();
    requisicaoAjax(url, parametros, retornListarApresentacaoComercial);
};

var retornListarApresentacaoComercial = function (retornoAjax) {
    if (retornoAjax.estado === "sucesso") {
        montarSelecApresentacaoComercial(retornoAjax.dados);
    }
};

var montarSelecApresentacaoComercial = function (listaApresentacaoComercial) {
    var select = $("#selectApresentacaoComercial");
    $(select).children().remove();
    $(listaApresentacaoComercial).each(function () {
        var apresentacaoComercial = $(this)[0];
        var textoOption = apresentacaoComercial.nome + " " + apresentacaoComercial.quantidade + apresentacaoComercial.apresentacaoComercial;
        var option = criarOption(apresentacaoComercial.id, textoOption);
        $(select).append(option);
    });
    setSelected($(select).children(), apresentacaoComercialId);
};


var pesquisar = function (funcaoRetorno) {
    var opcao = "listarPorNomeDescricaoOuCodigo";
    var nome = $("#txtPesquisaItem").val();

    var url = $("#url").val();
    var parametros = {opcao: opcao, nome: nome, url: url};
    requisicaoAjax(url, parametros, funcaoRetorno);
};
