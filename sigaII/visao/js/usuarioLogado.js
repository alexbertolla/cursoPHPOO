var usuariologado = function (matricula, nome, nomeUsuario, perfilId, nomePerfil, email) {
    this.matricula = matricula;
    this.nome = nome;
    this.nomeUsuario = nomeUsuario;
    this.perfilId = perfilId;
    this.nomePerfil = nomePerfil;
    this.email = email;
};

var sistemaLogado = function (id, anoSistema, liberado) {
    this.id = id;
    this.anoSistema = anoSistema;
    this.liberado = liberado;
};

var UsusarioLogado;
var SistemaLogado;