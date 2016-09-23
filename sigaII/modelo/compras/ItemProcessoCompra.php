<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\compras;

use modelo\compras\ItemPedido,
    modelo\compras\ProcessoCompra;

/**
 * Description of ItemProcesso
 *
 * @author alex.bertolla
 */
class ItemProcessoCompra extends ItemPedido {

    private $loteId;
    private $processoCompraId;
    private $fornecedorId;
    private $valorUnitario;
    private $valorTotal;
    private $tipoFornecedor;

    public function __construct() {
        parent::__construct();
    }

    function getLoteId() {
        return $this->loteId;
    }

    function getProcessoCompraId() {
        return $this->processoCompraId;
    }

    function getFornecedorId() {
        return $this->fornecedorId;
    }

    function getValorUnitario() {
        return $this->valorUnitario;
    }

    function getValorTotal() {
        return $this->valorTotal;
    }

    function getTipoFornecedor() {
        return $this->tipoFornecedor;
    }

    function setLoteId($loteId) {
        $this->loteId = $loteId;
    }

    function setProcessoCompraId($processoCompraId) {
        $this->processoCompraId = $processoCompraId;
    }

    function setFornecedorId($fornecedorId) {
        $this->fornecedorId = $fornecedorId;
    }

    function setValorUnitario($valorUnitario) {
        $this->valorUnitario = $valorUnitario;
    }

    function setValorTotal($valorTotal) {
        $this->valorTotal = $valorTotal;
    }

    function setTipoFornecedor($tipoFornecedor) {
        $this->tipoFornecedor = $tipoFornecedor;
    }

    public function __destruct() {
        parent::__destruct();
    }

}
