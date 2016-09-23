<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\cadastros;

/**
 * Description of NaturezaOperacao
 *
 * @author alex.bertolla
 */
class NaturezaOperacao {

    private $id;
    private $numero;
    private $nome;

    function getId() {
        return $this->id;
    }

    function getNumero() {
        return $this->numero;
    }

    function getNome() {
        return $this->nome;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

}
