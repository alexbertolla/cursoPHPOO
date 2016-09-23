$(document).ready(function () {
    var formularioLogin = $("#formLogin");

    var resultadoLogin = function (retornoLogin) {
        if (retornoLogin.estado === "sucesso") {
            location.href = "visao/painelPrincipal.html";
        } else {
            exibirMensagem(retornoLogin.estado, retornoLogin.estado + " - " + retornoLogin.mensagem);
        }
    };

    var submit = function () {
        submeterFormulario(formularioLogin, resultadoLogin);
//        console.log("teste");
    };

    $(formularioLogin).submit(function (event) {
        event.preventDefault();
        submit();
    });
});