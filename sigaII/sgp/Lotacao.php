<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Lotacao
 *
 * @author alex.bertolla
 */

namespace sgp;

use webservices\WSsgp;

class Lotacao {

    private $id;
    private $nome;
    private $sigla;

    function listar() {
        $wsSGP = new WSsgp();
        return $wsSGP->listarLotacoes();
    }

    function buscarPorId($id) {
        $wsSGP = new WSsgp();
        return $wsSGP->buscarLotacaoPorId($id);
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getSigla() {
        return $this->sigla;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setSigla($sigla) {
        $this->sigla = $sigla;
    }

}
