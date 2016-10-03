<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cliente
 *
 * @author alex.bertolla
 */
include_once './ClienteInterface.php';

class ClientePF implements ClienteInterface {

    private $nome;
    private $cpf;
    private $endereco;
    private $telefone;
    private $email;
    private $grauImportancia;

    public function __construct($nome, $documento, $endereco, $telefone, $email) {
        $this->nome = $nome;
        $this->cpf = $documento;
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
        return $this->cpf;
    }

    function setDocumento($documento) {
        $this->cpf = $documento;
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
