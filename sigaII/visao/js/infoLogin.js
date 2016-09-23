var buscarUsuarioLogado = function () {
    var opcao = "buscarSessao";
    var url = "../servlets/ServletLogin.php";
    var parametos = {opcao: opcao};
    requisicaoAjax(url, parametos, function (retornoBuscarUsuarioLogado) {
        if (retornoBuscarUsuarioLogado.estado === "sucesso" && retornoBuscarUsuarioLogado.dados !== null) {
            var usuario = retornoBuscarUsuarioLogado.dados.usuario;
            $("#labelUsuarioLogado").text(usuario.nome);
            $("#perfilUsuario").text("(" + usuario.nomePerfil + ")");
            carregarMenu(usuario.idPerfil);
            setInfoSistema(retornoBuscarUsuarioLogado.dados);
        } else {
            efetuarlogOff();
        }
    });
};


var setInfoSistema = function (infoSistema) {
    UsusarioLogado = new usuariologado(infoSistema.usuario.matricula, infoSistema.usuario.nome, infoSistema.usuario.nomeUsuario, infoSistema.usuario.idPerfil, infoSistema.usuario.nomePerfil, infoSistema.usuario.email);
    SistemaLogado = new sistemaLogado(infoSistema.sistema.id, infoSistema.sistema.anoSistema, infoSistema.sistema.liberado);
    $("#anoSistema").val(infoSistema.sistema.anoSistema);
    $("#usuarioLogadoMatricula").val(infoSistema.usuario.matricula);
    $("#usuarioLogadoNome").val(infoSistema.usuario.nome);
    $("#usuarioLogadoUsuario").val(infoSistema.usuario.nomeUsuario);
    $("#usuarioLogadoEmail").val(infoSistema.usuario.email);
    $("#usuarioLogadoNomePerfil").val(infoSistema.usuario.nomePerfil);
    $("#usuarioLogadoPefilId").val(infoSistema.usuario.idPerfil);
    
    console.log(UsusarioLogado);

};


var efetuarlogOff = function () {
    var opcao = "efetuarLogof";
    var url = "../servlets/ServletLogin.php";
    var parametos = {opcao: opcao};
    requisicaoAjax(url, parametos, retornoLogOff);
};

var retornoLogOff = function () {
    location.href = "../index.html";
};

var carregarMenu = function (idPerfil) {
    switch (idPerfil) {
        case 0:
            $("#nav").load("menuUsuarioComum.html");
            break;
        case "1":
        case "2":
            $("#nav").load("menuAdministrador.html");
            break;
    }
};

$(document).ready(function () {
    buscarUsuarioLogado();

    $("#spanIconeLogoff").click(function () {
        efetuarlogOff();
    });
});

