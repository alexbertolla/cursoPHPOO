<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\compras;

use modelo\compras\SituacaoItemPedido;

//use modelo\Item;

/**
 * Description of ItemPedido
 *
 * @author alex.bertolla
 */
class ItemPedido {

    private $pedidoId;
    private $itemId;
    private $item;
    private $quantidade;
    private $situacaoId;
    private $situacao;

    public function __construct() {
        $this->situacao = new SituacaoItemPedido();
    }

    function getPedidoId() {
        return $this->pedidoId;
    }

    function getItemId() {
        return $this->itemId;
    }

    function getItem() {
        return $this->item;
    }

    function getQuantidade() {
        return $this->quantidade;
    }

    function getSituacaoId() {
        return $this->situacaoId;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function setPedidoId($pedidoId) {
        $this->pedidoId = $pedidoId;
    }

    function setItemId($itemId) {
        $this->itemId = $itemId;
    }

    function setItem($item) {
        $this->item = $item;
    }

    function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    function setSituacaoId($situacaoId) {
        $this->situacaoId = $situacaoId;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function toString() {
        $string = "(pedidoId=>{$this->getPedidoId()}, "
                . "grupoId=>{$this->getGrupoId()}, "
                . "naturezaDespesaId=>{$this->getNaturezaDespesaId()}, "
                . "itemId,quantidade=>{$this->getQuantidade()}"
                . ")";
        return $string;
    }

    public function __destruct() {
        unset($this->item, $this->situacao);
    }

}
