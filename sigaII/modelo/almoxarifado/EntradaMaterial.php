<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\almoxarifado;

use modelo\almoxarifado\NotaFiscal,
    modelo\cadastros\NaturezaOperacao,
    modelo\cadastros\AlmoxarifadoVirtual,
    modelo\compras\OrdemDeCompra,
    modelo\compras\ProcessoCompra,
    ArrayObject;

/**
 * Description of EntradaMaterial
 *
 * @author alex.bertolla
 */
class EntradaMaterial {

    private $id;
    private $numero;
    private $data;
    private $ano;
    private $valor;
    private $notaFiscal;
    private $naturezaOperacao;
    private $naturezaOperacaoId;
    private $almoxarifadoVirtual;
    private $almoxarifadoVirtualId;
    private $ordemDeCompra;
    private $ordemDeCompraId;
    private $fornecedor;
    private $fornecedorId;
    private $tipoFornecedor;
    private $processoCompraId;
    private $processoCompra;
    private $modalidadeId;
    private $listaItemEntrada;

    public function __construct() {
        $this->notaFiscal = new NotaFiscal();
        $this->naturezaOperacao = new NaturezaOperacao();
        $this->almoxarifadoVirtual = new AlmoxarifadoVirtual();
        $this->ordemDeCompra = new OrdemDeCompra();
        $this->listaItemEntrada = new ArrayObject();
        $this->processoCompra = new ProcessoCompra();
    }

    function adicionarItem($item) {
        $this->listaItemEntrada->append($item);
    }

    function calcularValor() {
        foreach ($this->listaItemEntrada as $itemEntrada) {
            $this->valor +=$itemEntrada->getValorTotal();
        }
    }

    function getId() {
        return $this->id;
    }

    function getNumero() {
        return $this->numero;
    }

    function getData() {
        return $this->data;
    }

    function getAno() {
        return $this->ano;
    }

    function getValor() {
        return $this->valor;
    }

    function getNotaFiscal() {
        return $this->notaFiscal;
    }

    function getNaturezaOperacao() {
        return $this->naturezaOperacao;
    }

    function getNaturezaOperacaoId() {
        return $this->naturezaOperacaoId;
    }

    function getAlmoxarifadoVirtual() {
        return $this->almoxarifadoVirtual;
    }

    function getAlmoxarifadoVirtualId() {
        return $this->almoxarifadoVirtualId;
    }

    function getOrdemDeCompra() {
        return $this->ordemDeCompra;
    }

    function getOrdemDeCompraId() {
        return $this->ordemDeCompraId;
    }

    function getFornecedor() {
        return $this->fornecedor;
    }

    function getFornecedorId() {
        return $this->fornecedorId;
    }

    function getTipoFornecedor() {
        return $this->tipoFornecedor;
    }

    function getProcessoCompraId() {
        return $this->processoCompraId;
    }

    function getProcessoCompra() {
        return $this->processoCompra;
    }

    function getModalidadeId() {
        return $this->modalidadeId;
    }

    function getListaItemEntrada() {
        return $this->listaItemEntrada;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setAno($ano) {
        $this->ano = $ano;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setNotaFiscal($notaFiscal) {
        $this->notaFiscal = $notaFiscal;
    }

    function setNaturezaOperacao($naturezaOperacao) {
        $this->naturezaOperacao = $naturezaOperacao;
    }

    function setNaturezaOperacaoId($naturezaOperacaoId) {
        $this->naturezaOperacaoId = $naturezaOperacaoId;
    }

    function setAlmoxarifadoVirtual($almoxarifadoVirtual) {
        $this->almoxarifadoVirtual = $almoxarifadoVirtual;
    }

    function setAlmoxarifadoVirtualId($almoxarifadoVirtualId) {
        $this->almoxarifadoVirtualId = $almoxarifadoVirtualId;
    }

    function setOrdemDeCompra($ordemDeCompra) {
        $this->ordemDeCompra = $ordemDeCompra;
    }

    function setOrdemDeCompraId($ordemDeCompraId) {
        $this->ordemDeCompraId = $ordemDeCompraId;
    }

    function setFornecedor($fornecedor) {
        $this->fornecedor = $fornecedor;
    }

    function setFornecedorId($fornecedorId) {
        $this->fornecedorId = $fornecedorId;
    }

    function setTipoFornecedor($tipoFornecedor) {
        $this->tipoFornecedor = $tipoFornecedor;
    }

    function setProcessoCompraId($processoCompraId) {
        $this->processoCompraId = $processoCompraId;
    }

    function setProcessoCompra($processoCompra) {
        $this->processoCompra = $processoCompra;
    }

    function setModalidadeId($modalidadeId) {
        $this->modalidadeId = $modalidadeId;
    }

    function setListaItemEntrada($listaItemEntrada) {
        $this->listaItemEntrada = $listaItemEntrada;
    }

    public function __destruct() {
        unset($this->notaFiscal, $this->naturezaOperacao, $this->almoxarifadoVirtual, $this->ordemDeCompra, $this->listaItemEntrada);
    }

}
