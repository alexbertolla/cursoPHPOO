<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\almoxarifado;

use modelo\almoxarifado\ItemEstoque;

/**
 * Description of ItemRequisicao
 *
 * @author alex.bertolla
 */
class ItemRequisicao {

    private $requisicaoId;
    private $itemEstoqueId;
    private $itemId;
    private $quantidade;
    private $valorUnitario;
    private $valorTotal;
    private $itemEstoque;

    public function __construct() {
        $this->itemEstoque = new ItemEstoque();
    }

    function calcularValorTotal() {
        $this->valorTotal = $this->valorUnitario * $this->quantidade;
    }

    function getItemEstoqueId() {
        return $this->itemEstoqueId;
    }

    function getItemId() {
        return $this->itemId;
    }

    function getItemEstoque() {
        return $this->itemEstoque;
    }

    function getQuantidade() {
        return $this->quantidade;
    }

    function getValorUnitario() {
        return $this->valorUnitario;
    }

    function getValorTotal() {
        return $this->valorUnitario * $this->quantidade;
    }

    function getRequisicaoId() {
        return $this->requisicaoId;
    }

    function setItemEstoqueId($itemEstoqueId) {
        $this->itemEstoqueId = $itemEstoqueId;
    }

    function setItemId($itemId) {
        $this->itemId = $itemId;
    }

    function setItemEstoque($itemEstoque) {
        $this->itemEstoque = $itemEstoque;
    }

    function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    function setValorUnitario($valorUnitario) {
        $this->valorUnitario = $valorUnitario;
    }

    function setRequisicaoId($requisicaoId) {
        $this->requisicaoId = $requisicaoId;
    }

    public function __destruct() {
        unset($this->itemEstoque);
    }

}
