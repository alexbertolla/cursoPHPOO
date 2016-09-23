<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use modelo\compras\SituacaoProcessoDeCompra,
    dao\compras\SituacaoProcessoDeCompraDao;

/**
 * Description of ManterSituacaoProcessoCompra
 *
 * @author alex.bertolla
 */
class ManterSituacaoProcessoCompra {

    private $situacaoProcessoCompra;
    private $situacaoProcessoCompraDao;

    public function __construct() {
        $this->situacaoProcessoCompra = new SituacaoProcessoDeCompra();
        $this->situacaoProcessoCompraDao = new SituacaoProcessoDeCompraDao();
    }

    function buscarPorId($id) {
        $this->setSituacaoProcessoCompra($this->situacaoProcessoCompraDao->buscarPorIdDao($id));
        $this->bdToForm();
        return $this->getSituacaoProcessoCompra();
    }

    function buscarPorCodigo($codigo) {
        $this->setSituacaoProcessoCompra($this->situacaoProcessoCompraDao->buscarPorCodigoDao($codigo));
        $this->bdToForm();
        return $this->getSituacaoProcessoCompra();
    }

    function bdToForm() {
        $this->situacaoProcessoCompra->setSituacao(utf8_encode($this->situacaoProcessoCompra->getSituacao()));
    }

    function getSituacaoProcessoCompra() {
        return $this->situacaoProcessoCompra;
    }

    function setSituacaoProcessoCompra($situacaoProcessoCompra) {
        $this->situacaoProcessoCompra = $situacaoProcessoCompra;
    }

    public function __destruct() {
        unset($this->situacaoProcessoCompra, $this->situacaoProcessoCompraDao);
    }

}
