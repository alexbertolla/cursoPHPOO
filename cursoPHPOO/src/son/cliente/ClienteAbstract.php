<?php

namespace son\cliente;

use son\cliente\interfaces\ClienteInterface;

abstract class ClienteAbstract implements ClienteInterface {

    private $nome;
    private $endereco;
    private $telefone;
    private $email;
    private $grauImportancia;

    public function __construct($nome, $endereco, $telefone, $email) {
        $this->nome = $nome;
        $this->endereco = $endereco;
        $this->telefone = $telefone;
        $this->email = $email;
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

    function getGrauImportancia() {
        return $this->grauImportancia;
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

    function setGrauImportancia($grauImportancia) {
        $this->grauImportancia = $grauImportancia;
    }

}
