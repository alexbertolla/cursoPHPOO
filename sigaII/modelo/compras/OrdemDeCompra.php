<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\compras;

use configuracao\DadosUnidade,
    modelo\cadastros\DadosBancario,
    modelo\compras\ItemOrdemDeCompra,
    modelo\compras\SituacaoOCS,
    ArrayObject;

/**
 * Description of OrderDeCompra
 *
 * @author alex.bertolla
 */
class OrdemDeCompra {

    private $id;
    private $numero;
    private $sequencia;
    private $valor;
    private $prazo;
    private $dataEmissao;
    private $dataAssinatura;
    private $dataPrazoEntrega;
    private $tipoFornecedor;
    private $fornecedorId;
    private $processoCompraId;
    private $dadosBancarioId;
    private $bancoId;
    private $dadosUnidade;
    private $fornecedor;
    private $dadosBancario;
    private $listaItemOrdemDeCompra;
    private $listaItemProcessoCompra;
    private $listaEmpenho;
    private $situacaoId;
    private $situacao;

    public function __construct() {
        $this->dadosBancario = new DadosBancario();
        $this->listaItemOrdemDeCompra = new ArrayObject();
        $this->listaItemProcessoCompra = new ArrayObject();
        $this->dadosUnidade = new DadosUnidade();
        $this->listaEmpenho = new ArrayObject();
        $this->situacao = new SituacaoOCS();
    }

    function adicionarItemNaLista(ItemOrdemDeCompra $itemOrdemDeCompra) {
        $this->listaItemOrdemDeCompra->append($itemOrdemDeCompra);
    }

    function calcularValor() {
        $valor = 0;
        foreach ($this->listaItemOrdemDeCompra as $itemOrdemDeCompra) {
            $valor+=$itemOrdemDeCompra->getValorTotal();
        }
        $this->setValor($valor);
    }

    function atualizaDataEntrega($dataReferencia) {
        $this->dataPrazoEntrega = date('Y-m-d', strtotime("+{$this->prazo} days", strtotime($dataReferencia)));
    }

    function toString() {
        $string = "("
                . "id=>{$this->id}, "
                . "numero=>{$this->numero}, "
                . "sequencia=>{$this->sequencia}, "
                . "valor=>{$this->valor}, "
                . "prazo=>{$this->prazo}, "
                . "dataEmissao=>{$this->dataEmissao}, "
                . "dataAssinatura=>{$this->dataAssinatura}, "
                . "tipoFornecedor=>{$this->tipoFornecedor}, "
                . "fornecedorId=>{$this->fornecedorId}, "
                . "processoCompraId=>{$this->processoCompraId}, "
                . "dadosBancarioId=>{$this->dadosBancarioId}, "
                . "bancoId=>{$this->bancoId}, "
//                . "dadosUnidade=>{$this->dadosUnidade}, "
//                . "fornecedor=>{$this->fornecedor->toString()}, "
                . "dadosBancario=>{$this->dadosBancario->toString()}, "
//                . "listaItemOrdemCompra=>{$this->sequencia}, "
//                . "listaItemProcessoCompra=>{$this->sequencia}, "
//                . "listaEmpenho=>{$this->listaEmpenho}, "
                . "situacaoId=>{$this->situacaoId}, "
                . "situacao=>{$this->situacao->toString()}, "
                . ")";
        return $string;
    }

    function getId() {
        return $this->id;
    }

    function getNumero() {
        return $this->numero;
    }

    function getSequencia() {
        return $this->sequencia;
    }

    function getValor() {
        return $this->valor;
    }

    function getPrazo() {
        return $this->prazo;
    }

    function getDataEmissao() {
        return $this->dataEmissao;
    }

    function getDataAssinatura() {
        return $this->dataAssinatura;
    }

    function getDataPrazoEntrega() {
        return $this->dataPrazoEntrega;
    }

    function getTipoFornecedor() {
        return $this->tipoFornecedor;
    }

    function getFornecedorId() {
        return $this->fornecedorId;
    }

    function getProcessoCompraId() {
        return $this->processoCompraId;
    }

    function getDadosBancarioId() {
        return $this->dadosBancarioId;
    }

    function getBancoId() {
        return $this->bancoId;
    }

    function getDadosUnidade() {
        return $this->dadosUnidade;
    }

    function getFornecedor() {
        return $this->fornecedor;
    }

    function getDadosBancario() {
        return $this->dadosBancario;
    }

    function getListaItemOrdemDeCompra() {
        return $this->listaItemOrdemDeCompra;
    }

    function getListaItemProcessoCompra() {
        return $this->listaItemProcessoCompra;
    }

    function getListaEmpenho() {
        return $this->listaEmpenho;
    }

    function getSituacaoId() {
        return $this->situacaoId;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setSequencia($sequencia) {
        $this->sequencia = $sequencia;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setPrazo($prazo) {
        $this->prazo = $prazo;
    }

    function setDataEmissao($dataEmissao) {
        $this->dataEmissao = $dataEmissao;
    }

    function setDataAssinatura($dataAssinatura) {
        $this->dataAssinatura = $dataAssinatura;
    }

    function setDataPrazoEntrega($dataPrazoEntrega) {
        $this->dataPrazoEntrega = $dataPrazoEntrega;
    }

    function setTipoFornecedor($tipoFornecedor) {
        $this->tipoFornecedor = $tipoFornecedor;
    }

    function setFornecedorId($fornecedorId) {
        $this->fornecedorId = $fornecedorId;
    }

    function setProcessoCompraId($processoCompraId) {
        $this->processoCompraId = $processoCompraId;
    }

    function setDadosBancarioId($dadosBancarioId) {
        $this->dadosBancarioId = $dadosBancarioId;
    }

    function setBancoId($bancoId) {
        $this->bancoId = $bancoId;
    }

    function setDadosUnidade($dadosUnidade) {
        $this->dadosUnidade = $dadosUnidade;
    }

    function setFornecedor($fornecedor) {
        $this->fornecedor = $fornecedor;
    }

    function setDadosBancario($dadosBancario) {
        $this->dadosBancario = $dadosBancario;
    }

    function setListaItemOrdemDeCompra($listaItemOrdemDeCompra) {
        $this->listaItemOrdemDeCompra = $listaItemOrdemDeCompra;
    }

    function setListaItemProcessoCompra($listaItemProcessoCompra) {
        $this->listaItemProcessoCompra = $listaItemProcessoCompra;
    }

    function setListaEmpenho($listaEmpenho) {
        $this->listaEmpenho = $listaEmpenho;
    }

    function setSituacaoId($situacaoId) {
        $this->situacaoId = $situacaoId;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    public function __destruct() {
        unset($this->dadosUnidade, $this->dadosBancario, $this->listaItemOrdemDeCompra, $this->listaEmpenho);
    }

}
