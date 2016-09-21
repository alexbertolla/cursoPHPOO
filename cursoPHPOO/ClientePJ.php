<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClientePJ
 *
 * @author alex.bertolla
 */
class ClientePJ implements InterfaceImportanciaCliente {

    private $cnpj;
    private $nome;
    private $endereco;
    private $telefone;
    private $email;
    private $tipo;
    private $grauImportancia;

    public function __construct($cnpj, $nome, $endereco, $telefone, $email) {
        $this->cnpj = $cnpj;
        $this->nome = $nome;
        $this->endereco = $endereco;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->tipo = 'Pessoa Jurídica';
    }

    public function setGrauImportancia($grauImportancia) {
        $this->grauImportancia = $grauImportancia;
    }

    function getCnpj() {
        return $this->cnpj;
    }

    function getNome() {
        return $this->nome;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getTelefone() {
        return $this->telefone;
    }

    function getEmail() {
        return $this->email;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getGrauImportancia() {
        return $this->grauImportancia;
    }

    function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    function setEmail($email) {
        $this->email = $email;
    }

}
