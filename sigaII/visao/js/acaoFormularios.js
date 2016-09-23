/*
 * ESSA FUNÇÃO SUBMETE TODOS OS CAMPOS DO FORMULÁRIO
 * formulario: indica qual formulário deve ser enviado
 * funcaSucesso: indica qual função será executada caso o envio seja executado
 * com sucesso.
 * 
 * url: indica qual aqrquivo será chamado pela função
 * @param {type} formulario
 * @param {type} funcaoSucesso
 * @returns {undefined}
 */

var submeterFormulario = function (formulario, funcaoSucesso) {
    var url = $(formulario).find("#url").val();
//  console.log($(formulario).serializeArray());
    $.ajax({
        url: url,
        format: 'json',
        data: $(formulario).serializeArray(),
        async: false,
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(url);
            alert("ERRO /n " + textStatus);
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        },
        success: function (data, textStatus, jqXHR) {
            funcaoSucesso(data);
        },
        type: 'POST'
    });
};
/* FIM FUNCAO submeterFormulario*/

/*
 * ESSA FUNÇÃO SUBMETE TODOS OS CAMPOS DO FORMULÁRIO
 * url: indica qual aqrquivo será chamado pela função
 * parametros: parametros enviados pela chamada
 * funcaoSucesso: indica qual função será executada caso o envio seja executado
 * com sucesso.
 * 
 * @param {type} url
 * @param {type} parametros
 * @param {type} funcaoSucesso
 * @returns {undefined}
 
 */
var requisicaoAjax = function (url, parametros, funcaoSucesso) {
    $.ajax({
        url: url,
        format: 'json',
        data: parametros,
        async: false,
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("ERRO /n " + textStatus);
            console.log(textStatus);
            console.log(errorThrown);
        },
        success: function (data, textStatus, jqXHR) {
            esconderProgressBar();
            funcaoSucesso(data);
        },
        beforeSend: function () {
            exibirProgressBar();
        },
        type: 'POST'
    });

};
/* FIM FUNCAO requisicaoAjax*/


var exibirMensagem = function (tipoMensagem, mensagem) {
    var classe = (tipoMensagem === "sucesso") ? "mensagemSistemaSucesso" : "mensagemSistemaErro";
    var label = $("#labelMensagemSistema");
    $(label).removeClass();
    $(label).addClass(classe);
    $(label).text(mensagem);
    $(label).fadeIn(200);
    $(label).fadeOut(3000);
    $(label).text(mensagem);
};

var exibirAlerta = function (tipoMensagem, mensagem) {
    //alert(mensagem);
    bootbox.alert(mensagem, function() {});
};

var limparFormulario = function (formulario) {
    $(formulario).find("#reset").click();
};

var limparTabela = function (tbody) {
    $(tbody).children().remove();
};

var setOpcao = function (formulario, opcao) {
    $(formulario).find("#opcao").val(opcao);
};

var criarText = function (id, nome, placeholder, classe) {
    var text = $("<input>").attr({
        name: nome,
        id: id,
        placeholder: placeholder,
        type: text
    });
    $(text).addClass(classe);
    return text;
};

var criarLabel = function (id, nome, texto, classes) {
    var label = $("<label>").attr({
        id: id,
        name: nome
    });
    label.text(texto);
    label.addClass(classes);
    return label;
};

var criarA = function (id, href, classes, label, title) {
    var a = $("<a>").attr({
        id: id,
        href: href,
        title: title
    });

    $(a).text(label);

    a.addClass(classes);

    return  a;
};

var criarOption = function (valor, texto, selected) {
    var option = $("<option>").attr({
        value: valor,
        selected: selected
    });
    $(option).text(texto);
    return option;
};


var criarUl = function (id, nome, classes, li) {
    var ul = $("<ul>").attr({
        id: id,
        name: nome
    });
    $(ul).addClass(classes);
    $(ul).append(li);
    return ul;
};

var criarLi = function (id, classes, conteudo) {
    var li = $("<li>").attr({
        id: id
    });
    $(li).addClass(classes);
    $(li).append(conteudo);
    return li;
};

var criarButton = function (id, tipo, nome, titulo, classes, acao) {
    var button = $("<button>").attr({
        id: id,
        type: tipo,
        name: nome,
        title: titulo
    });
    $(button).text(titulo);
    $(button).addClass(classes);
    $(button).click(acao);
    return button;
};

var criarCheckbox = function (id, nome, valor, checked) {
    var checkbox = $("<input>").attr({
        id: id,
        type: "checkbox",
        name: nome,
        value: valor,
        checked: checked
    });
    return checkbox;
};

var exibirTituloFormulario = function (titulo) {
    $("#labelTituloFormulario").text(titulo);
};

var setItemInativo = function (item) {
    $(item).addClass("inativo").toggle();
};

var setSelected = function (lista, valor) {
    $(lista).each(function () {
        $(this).prop({selected: ($(this).val() === valor) ? true : false});
    });
};

var carregarCalendario = function (input) {
    return $(input).datepicker(calendario());
};

var calendario = function () {

    var attCalendario = {
        changeMonth: true,
        changeYear: true,
        //dateFormat: 'yy-dd-mm',
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'],
        dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']
    };
    return attCalendario;
};

var exibirProgressBar = function () {
    $("#divProgressbar").show();
};

var esconderProgressBar = function () {
    $("#divProgressbar").hide();
};


var mostrar = function (objeto) {
    $(objeto).show();
};

var esconder = function (objeto) {
    $(objeto).hide();
};

//$(".calendario").datepicker(calendario());
//console.log($(window).width());