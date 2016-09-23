<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\cadastros;

/**
 * Description of Modalidade
 *
 * @author alex.bertolla
 */
class Modalidade {

    private $id;
    private $nome;

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function toString() {
        $string = "(" .
                "id=>" . $this->getId() . "," .
                "nome=>" . $this->getNome() . "," .
                ")";
        return $string;
    }

}
