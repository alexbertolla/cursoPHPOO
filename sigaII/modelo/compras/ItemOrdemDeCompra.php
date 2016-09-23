<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\compras;

/**
 * Description of ItemOrdemDeCompra
 *
 * @author alex.bertolla
 */
class ItemOrdemDeCompra {

    private $ordemCompraId;
    private $processoCompraId;
    private $fornecedorId;
    private $loteId;
    private $pedidoId;
    private $itemId;
    private $quantidade;
    private $valorUnitario;
    private $valorTotal;
    private $lote;
    private $item;

    public function __construct() {
        $this->lote = new LoteProcessoCompra();
    }

    function getOrdemCompraId() {
        return $this->ordemCompraId;
    }

    function getProcessoCompraId() {
        return $this->processoCompraId;
    }

    function getFornecedorId() {
        return $this->fornecedorId;
    }

    function getLoteId() {
        return $this->loteId;
    }

    function getPedidoId() {
        return $this->pedidoId;
    }

    function getItemId() {
        return $this->itemId;
    }

    function getQuantidade() {
        return $this->quantidade;
    }

    function getValorUnitario() {
        return $this->valorUnitario;
    }

    function getValorTotal() {
        return $this->valorTotal;
    }

    function getLote() {
        return $this->lote;
    }

    function getItem() {
        return $this->item;
    }

    function setOrdemCompraId($ordemCompraId) {
        $this->ordemCompraId = $ordemCompraId;
    }

    function setProcessoCompraId($processoCompraId) {
        $this->processoCompraId = $processoCompraId;
    }

    function setFornecedorId($fornecedorId) {
        $this->fornecedorId = $fornecedorId;
    }

    function setLoteId($loteId) {
        $this->loteId = $loteId;
    }

    function setPedidoId($pedidoId) {
        $this->pedidoId = $pedidoId;
    }

    function setItemId($itemId) {
        $this->itemId = $itemId;
    }

    function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    function setValorUnitario($valorUnitario) {
        $this->valorUnitario = $valorUnitario;
    }

    function setValorTotal($valorTotal) {
        $this->valorTotal = $valorTotal;
    }

    function setLote($lote) {
        $this->lote = $lote;
    }

    function setItem($item) {
        $this->item = $item;
    }

    public function __destruct() {
        unset($this->lote);
    }

}
