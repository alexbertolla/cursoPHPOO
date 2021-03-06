<?php

namespace son\cliente;

use son\cliente\interfaces\ClienteInterface;

abstract class ClienteAbstract implements ClienteInterface {

    private $id;
    private $nome;
    private $endereco;
    private $telefone;
    private $email;
    private $grauImportancia;

    public function __construct($id, $nome, $endereco, $telefone, $email, $grauImportancia) {
        $this->id = $id;
        $this->nome = $nome;
        $this->endereco = $endereco;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->grauImportancia = $grauImportancia;
    }

    function getId() {
        return $this->id;
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

    function setId($id) {
        $this->id = $id;
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
