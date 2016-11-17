<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 * @author alex
 */
class Usuario {

    private $id;
    private $usuairo;
    private $senha;

    function getId() {
        return $this->id;
    }

    function getUsuairo() {
        return $this->usuairo;
    }

    function getSenha() {
        return $this->senha;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsuairo($usuairo) {
        $this->usuairo = $usuairo;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

}
