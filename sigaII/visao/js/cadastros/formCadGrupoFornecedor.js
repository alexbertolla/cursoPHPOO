$(document).ready(function () {
    var formCadGrupoFornecedor = $("#formCadGrupoFornecedor");
    var divNaturezaDespesa = $("#divNaturezaDespesa");
    var listaGruposFornecedor;
    var listaGrupos;
    var fornecedorId = $(document).find("#fornecedorId").val();

    var listarGruposFornecedor = function () {
        var url = $(formCadGrupoFornecedor).find("#url").val();
        var parametros = {opcao: "listarAtivosPorFornecedorId", fornecedorId: fornecedorId};

        requisicaoAjax(url, parametros, resultadoListarGrupoPorFornecedor);
    };

    var resultadoListarGrupoPorFornecedor = function (retorno) {
        listaGruposFornecedor = retorno.dados;
    };


    var listarND = function () {
        var url = $("#urlND").val();
        var parametros = {opcao: "listarAtivas"};
        requisicaoAjax(url, parametros, resultadoListarND);
    };

    var resultadoListarND = function (retornoListarND) {
        if (retornoListarND.estado === "sucesso") {
            montarFieldsetND(retornoListarND.dados);
        }
    };

    var montarFieldsetND = function (listaND) {
        $(listaND).each(function () {
            listaGrupos = null;
            var fieldset = $("<fieldset>");
            var naturezaDespesa = $(this)[0];
            var legend = $("<legend>").text(naturezaDespesa.nome);
            $(legend).addClass("well-legend");
            $(fieldset).append(legend);
            $(divNaturezaDespesa).append(fieldset);
            addGrupoFieldset(naturezaDespesa.id, fieldset);
        });
    };

    var addGrupoFieldset = function (naturezaDespesaId, fieldset) {
        listarGruposPorND(naturezaDespesaId);
        montarListaGrupos(listaGrupos, fieldset);
    };

    var listarGruposPorND = function (naturezaDespesaId) {
        var url = $(formCadGrupoFornecedor).find("#url").val();
        var parametros = {opcao: "listarAtivosPorNaturezaDespesaId", naturezaDespesaId: naturezaDespesaId};
        requisicaoAjax(url, parametros, resultadoListarGrupo);
    };

    var resultadoListarGrupo = function (retornoListarGrupo) {
        if (retornoListarGrupo.estado === "sucesso") {
            listaGrupos = retornoListarGrupo.dados;
        }
    };

    var montarListaGrupos = function (listaGrupos, fieldset) {
        var ul = criarUl("", "listaGrupo");
        $(listaGrupos).each(function () {
            var grupo = $(this)[0];
            var label = criarLabel("", "", grupo.codigo + " - " + grupo.nome, "");//id, nome, texto, classes
            var checked = setGrupoFornecedor(grupo, listaGruposFornecedor);
            var checkbox = criarCheckbox("", "grupoId[]", grupo.id, checked);//id, nome, valor, checked
            var li = criarLi("", "", [checkbox, label]);//id, classes, conteudo
            $(ul).append(li);
        });
        $(fieldset).addClass("well");
        $(fieldset).append(ul);
    };

    var setGrupoFornecedor = function (grupo, listaGrupoFornecedor) {
        var checked = false;
        $(listaGrupoFornecedor).each(function () {
            if ($(this)[0].id === grupo.id) {
                checked = true;
            }
        });
        return checked;
    };


    var submeterGrupo = function () {
        submeterFormulario(formCadGrupoFornecedor, retornoSubmit);
    };

    var retornoSubmit = function (retornoSubmit) {

        exibirAlerta(retornoSubmit.estado, retornoSubmit.mensagem);
    };

    var inicializarGrupoFornecedor = function () {
        $(formCadGrupoFornecedor).find("#fornecedorId").val(fornecedorId);

        listarGruposFornecedor();

        listarND();
    };

    inicializarGrupoFornecedor();

    $(formCadGrupoFornecedor).submit(function (event) {
        event.preventDefault();
        submeterGrupo();
    });

});

