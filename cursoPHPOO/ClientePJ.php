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
include_once './clienteinterface.php';
class ClientePJ implements ClienteInterface  {

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
        $this->email=$email;
    }

    public function setEndereco($endereco) {
        $this->endereco=$endereco;   
    }

    public function setNome($nome) {
        $this->nome=$nome;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

}
