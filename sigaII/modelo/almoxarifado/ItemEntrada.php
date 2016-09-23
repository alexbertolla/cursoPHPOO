<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\almoxarifado;

use modelo\cadastros\MaterialConsumo;

/**
 * Description of ItemEntrada
 *
 * @author alex.bertolla
 */
class ItemEntrada {

    private $entradaId;
    private $fornecedorId;
    private $itemId;
    private $grupoId;
    private $quantidade;
    private $valorUnitario;
    private $valorTotal;
    private $item;

    function __construct() {
        $this->item = new MaterialConsumo();
    }

    function getEntradaId() {
        return $this->entradaId;
    }

    function getFornecedorId() {
        return $this->fornecedorId;
    }

    function getItemId() {
        return $this->itemId;
    }

    function getGrupoId() {
        return $this->grupoId;
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

    function setEntradaId($entradaId) {
        $this->entradaId = $entradaId;
    }

    function setFornecedorId($fornecedorId) {
        $this->fornecedorId = $fornecedorId;
    }

    function setItemId($itemId) {
        $this->itemId = $itemId;
    }

    function setGrupoId($grupoId) {
        $this->grupoId = $grupoId;
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

    function __destruct() {
        unset($this->item);
    }

}
