<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace configuracao;

/**
 * Description of DadosUnidade
 *
 * @author alex.bertolla
 */
class EnderecoUnidade {

    private $logradouro;
    private $numero;
    private $complemento;
    private $bairro;
    private $cidade;
    private $estado;
    private $cep;

    function getLogradouro() {
        return $this->logradouro;
    }

    function getNumero() {
        return $this->numero;
    }

    function getComplemento() {
        return $this->complemento;
    }

    function getBairro() {
        return $this->bairro;
    }

    function getCidade() {
        return $this->cidade;
    }

    function getEstado() {
        return $this->estado;
    }

    function getCep() {
        return $this->cep;
    }

    function setLogradouro($logradouro) {
        $this->logradouro = $logradouro;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setComplemento($complemento) {
        $this->complemento = $complemento;
    }

    function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setCep($cep) {
        $this->cep = $cep;
    }

}

class DadosUnidade {

    private $nome;
    private $sigla;
    private $cnpj;
    private $inscricaoEstadual;
    private $inscricaoMunicipal;
    private $codigoSiged;
    private $codigoUasg;
    private $telefone;
    private $endereco;
    private $chefeGeral;
    private $chefeAdministrativo;

    public function __construct() {
        $this->endereco = new EnderecoUnidade();
    }

    function getNome() {
        return $this->nome;
    }

    function getSigla() {
        return $this->sigla;
    }

    function getCnpj() {
        return $this->cnpj;
    }

    function getInscricaoEstadual() {
        return $this->inscricaoEstadual;
    }

    function getInscricaoMunicipal() {
        return $this->inscricaoMunicipal;
    }

    function getCodigoSiged() {
        return $this->codigoSiged;
    }

    function getCodigoUasg() {
        return $this->codigoUasg;
    }

    function getTelefone() {
        return $this->telefone;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getChefeGeral() {
        return $this->chefeGeral;
    }

    function getChefeAdministrativo() {
        return $this->chefeAdministrativo;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setSigla($sigla) {
        $this->sigla = $sigla;
    }

    function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    function setInscricaoEstadual($inscricaoEstadual) {
        $this->inscricaoEstadual = $inscricaoEstadual;
    }

    function setInscricaoMunicipal($inscricaoMunicipal) {
        $this->inscricaoMunicipal = $inscricaoMunicipal;
    }

    function setCodigoSiged($codigoSiged) {
        $this->codigoSiged = $codigoSiged;
    }

    function setCodigoUasg($codigoUasg) {
        $this->codigoUasg = $codigoUasg;
    }

    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setChefeGeral($chefeGeral) {
        $this->chefeGeral = $chefeGeral;
    }

    function setChefeAdministrativo($chefeAdministrativo) {
        $this->chefeAdministrativo = $chefeAdministrativo;
    }

    public function __destruct() {
        unset($this->endereco);
    }

}
