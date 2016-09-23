<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\cadastros;

use ArrayObject,
    modelo\cadastros\Endereco;

/**
 * Description of Fornecedor
 *
 * @author alex.bertolla
 */
class Fornecedor {

    protected $id;
    protected $nome;
    protected $site;
    protected $telefone;
    protected $endereco;
    protected $email;
    protected $grupo;
    protected $dadosBancarios;
    protected $situacao;
    protected $tipo;

    public function __construct() {
        $this->telefone = new ArrayObject();
        $this->endereco = new Endereco();
        $this->email = new ArrayObject();
        $this->grupo = new ArrayObject();
        $this->dadosBancarios = new ArrayObject();
    }

    public function __destruct() {
        unset($this->endereco, $this->telefone, $this->email, $this->grupo);
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getSite() {
        return $this->site;
    }

    function getTelefone() {
        return $this->telefone;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getEmail() {
        return $this->email;
    }

    function getGrupo() {
        return $this->grupo;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setSite($site) {
        $this->site = $site;
    }

    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setGrupo($grupo) {
        $this->grupo = $grupo;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function getDadosBancarios() {
        return $this->dadosBancarios;
    }

    function setDadosBancarios($dadosBancarios) {
        $this->dadosBancarios = $dadosBancarios;
    }

    function adicionarTelefone(Telefone $telefone) {
        $this->telefone->append($telefone);
    }

    function adicionarEmail(EmailFornecedor $email) {
        $this->email->append($email);
    }

    function adicionarGrupo(Grupo $grupo) {
        $this->grupo->append($grupo);
    }

    function adicionarDadosBancarios(DadosBancario $dadosBancarios) {
        $this->dadosBancarios->append($dadosBancarios);
    }

    function toString() {
        $string = "id=>{$this->getId()}, " .
                "nome=>{$this->getNome()}, " .
                "site=>{$this->getSite()}, " .
                "situacao=>{$this->getSituacao()}";
        return $string;
    }

}
