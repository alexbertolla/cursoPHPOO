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
include_once './clienteinterface.php';

class ClientePF implements ClienteInterface {

    private $nome;
    private $cpf;
    private $endereco;
    private $telefone;
    private $email;
    private $tipo;
    private $grauImportancia;

    public function __construct($nome, $cpf, $endereco, $telefone, $email) {
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->endereco = $endereco;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->tipo = 'Pessoa Física';
    }

    public function setGrauImportancia($grauImportancia) {
        $this->grauImportancia = $grauImportancia;
    }

    public function getEmail() {
        
    }

    public function getEndereco() {
        
    }

    public function getNome() {
        
    }

    public function getTelefone() {
        
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
