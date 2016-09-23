<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\compras;

/**
 * Description of ItemProposta
 *
 * @author alex.bertolla
 */
class ItemProposta {

    private $propostaId;
    private $fornecedorId;
    private $processoCompraId;
    private $loteId;
    private $pedidoId;
    private $itemId;
    private $quantidade;
    private $valorUnitario;
    private $valorTotal;
    private $item;
    private $tipoFornecedor;
    private $fornecedor;

    function getPropostaId() {
        return $this->propostaId;
    }

    function getFornecedorId() {
        return $this->fornecedorId;
    }

    function getProcessoCompraId() {
        return $this->processoCompraId;
    }

    function getModalidadeId() {
        return $this->modalidadeId;
    }

    function getLoteId() {
        return $this->loteId;
    }

    function getPedidoId() {
        return $this->pedidoId;
    }

    function getGrupoId() {
        return $this->grupoId;
    }

    function getNaturezaDespesaId() {
        return $this->naturezaDespesaId;
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

    function getItem() {
        return $this->item;
    }

    function getTipoFornecedor() {
        return $this->tipoFornecedor;
    }

    function getFornecedor() {
        return $this->fornecedor;
    }

    function setPropostaId($propostaId) {
        $this->propostaId = $propostaId;
    }

    function setFornecedorId($fornecedorId) {
        $this->fornecedorId = $fornecedorId;
    }

    function setProcessoCompraId($processoCompraId) {
        $this->processoCompraId = $processoCompraId;
    }

    function setModalidadeId($modalidadeId) {
        $this->modalidadeId = $modalidadeId;
    }

    function setLoteId($loteId) {
        $this->loteId = $loteId;
    }

    function setPedidoId($pedidoId) {
        $this->pedidoId = $pedidoId;
    }

    function setGrupoId($grupoId) {
        $this->grupoId = $grupoId;
    }

    function setNaturezaDespesaId($naturezaDespesaId) {
        $this->naturezaDespesaId = $naturezaDespesaId;
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

    function setItem($item) {
        $this->item = $item;
    }

    function setTipoFornecedor($tipoFornecedor) {
        $this->tipoFornecedor = $tipoFornecedor;
    }

    function setFornecedor($fornecedor) {
        $this->fornecedor = $fornecedor;
    }

}
