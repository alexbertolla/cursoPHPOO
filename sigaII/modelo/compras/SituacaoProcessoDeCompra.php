<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\compras;

/**
 * Description of SituacaoOrdemDeCompra
 *
 * @author alex.bertolla
 */
class SituacaoProcessoDeCompra {

    private $id;
    private $codigo;
    private $situacao;

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
