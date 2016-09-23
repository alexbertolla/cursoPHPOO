var dadosUnidade = function (nome, sigla, cnpj, inscricaoEstadual, inscricaoMinicipal, codigoSiged, codigoUasg, telefone, endereco, chefeGeral, chefeAdministrativo) {
    this.nome = nome;
    this.sigla = sigla;
    this.cnpj = cnpj;
    this.inscricaoEstadual = inscricaoEstadual;
    this.inscricaoMunicipal = inscricaoMinicipal;
    this.codigoSiged = codigoSiged;
    this.codigoUasg = codigoUasg;
    this.telefone = telefone;
    this.endereco = endereco;
    this.chefeGeral = chefeGeral;
    this.chefeAdministrativo = chefeAdministrativo;
};

var enderecoUnidade = function (logradouro, numero, complemento, bairro, cidade, estado, cep) {
    this.logradouro = logradouro;
    this.numero = numero;
    this.complemento = complemento;
    this.bairro = bairro;
    this.cidade = cidade;
    this.estado = estado;
    this.cep = cep;
};

var DadosUnidade;
var EnderecoUnidade;