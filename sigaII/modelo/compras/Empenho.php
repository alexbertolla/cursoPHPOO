<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\compras;

use sof\PA,
    modelo\cadastros\NaturezaDespesa,
    modelo\compras\Pedido;

/**
 * Description of Empenho
 *
 * @author alex.bertolla
 */
class Empenho {

    private $id;
    private $unidadeOrcamentaria;
    private $valor;
    private $ordemCompraId;
    private $paId;
    private $pa;
    private $naturezaDespesaId;
    private $naturezaDespesa;
    private $pedidoId;
    private $pedido;

    public function __construct() {
        $this->pa = new PA();
        $this->naturezaDespesa = new NaturezaDespesa();
        $this->pedido = new Pedido();
    }

    function getId() {
        return $this->id;
    }

    function getUnidadeOrcamentaria() {
        return $this->unidadeOrcamentaria;
    }

    function getValor() {
        return $this->valor;
    }

    function getOrdemCompraId() {
        return $this->ordemCompraId;
    }

    function getPaId() {
        return $this->paId;
    }

    function getPa() {
        return $this->pa;
    }

    function getNaturezaDespesaId() {
        return $this->naturezaDespesaId;
    }

    function getNaturezaDespesa() {
        return $this->naturezaDespesa;
    }

    function getPedidoId() {
        return $this->pedidoId;
    }

    function getPedido() {
        return $this->pedido;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUnidadeOrcamentaria($unidadeOrcamentaria) {
        $this->unidadeOrcamentaria = $unidadeOrcamentaria;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setOrdemCompraId($ordemCompraId) {
        $this->ordemCompraId = $ordemCompraId;
    }

    function setPaId($paId) {
        $this->paId = $paId;
    }

    function setPa($pa) {
        $this->pa = $pa;
    }

    function setNaturezaDespesaId($naturezaDespesaId) {
        $this->naturezaDespesaId = $naturezaDespesaId;
    }

    function setNaturezaDespesa($naturezaDespesa) {
        $this->naturezaDespesa = $naturezaDespesa;
    }

    function setPedidoId($pedidoId) {
        $this->pedidoId = $pedidoId;
    }

    function setPedido($pedido) {
        $this->pedido = $pedido;
    }

    public function __destruct() {
        unset($this->pa, $this->naturezaDespesa, $this->pedido);
    }

}
