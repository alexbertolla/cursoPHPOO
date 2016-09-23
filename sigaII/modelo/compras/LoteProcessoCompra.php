<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\compras;

use ArrayObject,
    modelo\compras\ItemProcessoCompra;

/**
 * Description of LoteProcessoCompra
 *
 * @author alex.bertolla
 */
class LoteProcessoCompra {

    private $id;
    private $numero;
    private $processoCompraId;
    private $modalidadeId;
    private $listaItemProcessoCompra;

    function __construct() {
        $this->listaItemProcessoCompra = new ArrayObject();
    }

    function addItemProcessoCompra(ItemProcessoCompra $itemProcessoCompra) {
        $this->listaItemProcessoCompra->append($itemProcessoCompra);
    }

    function getId() {
        return $this->id;
    }

    function getNumero() {
        return $this->numero;
    }

    function getProcessoCompraId() {
        return $this->processoCompraId;
    }

    function getModalidadeId() {
        return $this->modalidadeId;
    }

    function getListaItemProcessoCompra() {
        return $this->listaItemProcessoCompra;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setProcessoCompraId($processoCompraId) {
        $this->processoCompraId = $processoCompraId;
    }

    function setModalidadeId($modalidadeId) {
        $this->modalidadeId = $modalidadeId;
    }

    function setListaItemProcessoCompra($listaItemProcessoCompra) {
        $this->listaItemProcessoCompra = $listaItemProcessoCompra;
    }

    public function __destruct() {
        unset($this->processoCompra, $this->listaItemProcessoCompra);
    }

}
