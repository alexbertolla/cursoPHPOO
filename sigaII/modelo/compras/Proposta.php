<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\compras;

use modelo\compras\ProcessoCompra,
    modelo\cadastros\Modalidade,
    modelo\compras\ItemProposta,
    modelo\compras\LoteProposta,
    ArrayObject;

/**
 * Description of Proposta
 *
 * @author alex.bertolla
 */
class Proposta {

    private $id;
    private $fornecedorId;
    private $tipoFornecedor;
    private $fornecedor;
    private $processoCompraId;
    private $processoCompra;
    private $data;
    private $numero;
    private $valor;
    private $listaLoteProposta;
    private $listaItemProposta;

    public function __construct() {
        $this->processoCompra = new ProcessoCompra();
        $this->modalidade = new Modalidade();
        $this->listaLoteProposta = new ArrayObject();
        $this->listaItemProposta = new ArrayObject();
    }

    function adicionarItemNaProposta(ItemProposta $itemProposta) {
        $this->listaItemProposta->append($itemProposta);
    }

    function adicionarLoteNaProposta(LoteProposta $loteProposta) {
        $this->listaLoteProposta->append($loteProposta);
    }

    function getId() {
        return $this->id;
    }

    function getFornecedorId() {
        return $this->fornecedorId;
    }

    function getTipoFornecedor() {
        return $this->tipoFornecedor;
    }

    function getFornecedor() {
        return $this->fornecedor;
    }

    function getProcessoCompraId() {
        return $this->processoCompraId;
    }

    function getProcessoCompra() {
        return $this->processoCompra;
    }

    function getData() {
        return $this->data;
    }

    function getNumero() {
        return $this->numero;
    }

    function getValor() {
        return $this->valor;
    }

    function getListaLoteProposta() {
        return $this->listaLoteProposta;
    }

    function getListaItemProposta() {
        return $this->listaItemProposta;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFornecedorId($fornecedorId) {
        $this->fornecedorId = $fornecedorId;
    }

    function setTipoFornecedor($tipoFornecedor) {
        $this->tipoFornecedor = $tipoFornecedor;
    }

    function setFornecedor($fornecedor) {
        $this->fornecedor = $fornecedor;
    }

    function setProcessoCompraId($processoCompraId) {
        $this->processoCompraId = $processoCompraId;
    }

    function setProcessoCompra($processoCompra) {
        $this->processoCompra = $processoCompra;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setListaLoteProposta($listaLoteProposta) {
        $this->listaLoteProposta = $listaLoteProposta;
    }

    function setListaItemProposta($listaItemProposta) {
        $this->listaItemProposta = $listaItemProposta;
    }

    public function __destruct() {
        unset($this->processoCompra, $this->modalidade, $this->listaLoteProposta);
    }

}
