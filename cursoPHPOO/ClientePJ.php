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
include_once './ClienteInterface.php';

class ClientePJ implements ClienteInterface {

    private $cnpj;
    private $nome;
    private $endereco;
    private $telefone;
    private $email;
    private $grauImportancia;

    public function __construct($nome, $documento, $endereco, $telefone, $email) {
        $this->cnpj = $documento;
        $this->nome = $nome;
        $this->endereco = $endereco;
        $this->telefone = $telefone;
        $this->email = $email;
    }

    public function setGrauImportancia($grauImportancia) {
        $this->grauImportancia = $grauImportancia;
    }

    function getGrauImportancia() {
        return $this->grauImportancia;
    }

    function getDocumento() {
        return $this->cnpj;
    }

    function setDocumento($documento) {
        $this->cnpj = $documento;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

}
