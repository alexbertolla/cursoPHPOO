<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\almoxarifado;

use modelo\cadastros\MaterialConsumo;

/**
 * Description of ItemEstoque
 *
 * @author alex.bertolla
 */
class ItemEstoque {

    private $id;
    private $itemId;
    private $item;
    private $quantidade;
    private $precoMedio;
    private $diferencaContabil;
    private $estoqueMaximo;
    private $estoqueMinimo;
    private $estoqueAtual;
    private $dataValidade;
    private $fornecedorId;
    private $fornecedor;
    private $quantidadeReservada;

    public function __construct() {
        $this->item = new MaterialConsumo();
    }

    function entradaItem($quantidade) {
        $this->quantidade += $quantidade;
    }

    function saidaItem($quantidade) {
        $this->quantidade -= $quantidade;
    }

    function getQuantidadeReservada() {
        return $this->quantidadeReservada;
    }

    function setQuantidadeReservada($quantidadeReservada) {
        $this->quantidadeReservada = $quantidadeReservada;
    }

    function getId() {
        return $this->id;
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

    function getPrecoMedio() {
        return $this->precoMedio;
    }

    function getDiferencaContabil() {
        return $this->diferencaContabil;
    }

    function getEstoqueMaximo() {
        return $this->estoqueMaximo;
    }

    function getEstoqueMinimo() {
        return $this->estoqueMinimo;
    }

    function getEstoqueAtual() {
        return $this->estoqueAtual;
    }

    function getDataValidade() {
        return $this->dataValidade;
    }

    function getFornecedorId() {
        return $this->fornecedorId;
    }

    function getFornecedor() {
        return $this->fornecedor;
    }

    function setId($id) {
        $this->id = $id;
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

    function setPrecoMedio($precoMedio) {
        $this->precoMedio = $precoMedio;
    }

    function setDiferencaContabil($diferencaContabil) {
        $this->diferencaContabil = $diferencaContabil;
    }

    function setEstoqueMaximo($estoqueMaximo) {
        $this->estoqueMaximo = $estoqueMaximo;
    }

    function setEstoqueMinimo($estoqueMinimo) {
        $this->estoqueMinimo = $estoqueMinimo;
    }

    function setEstoqueAtual($estoqueAtual) {
        $this->estoqueAtual = $estoqueAtual;
    }

    function setDataValidade($dataValidade) {
        $this->dataValidade = $dataValidade;
    }

    function setFornecedorId($fornecedorId) {
        $this->fornecedorId = $fornecedorId;
    }

    function setFornecedor($fornecedor) {
        $this->fornecedor = $fornecedor;
    }

    public function __destruct() {
        unset($this->item);
    }

}
