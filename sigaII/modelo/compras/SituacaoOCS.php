<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\compras;

/**
 * Description of SituacaoOCS
 *
 * @author alex.bertolla
 */
class SituacaoOCS {

    private $id;
    private $codigo;
    private $situacao;

    function toString() {
        $string = "("
                . "id=>{$this->getId()}, "
                . "codigo=>{$this->getCodigo()}, "
                . "situacao=>{$this->situacao}"
                . ")";
        return $string;
    }

    function getId() {
        return $this->id;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

}
