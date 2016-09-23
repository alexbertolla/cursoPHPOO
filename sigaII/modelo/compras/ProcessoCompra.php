<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\compras;

use modelo\cadastros\Modalidade,
    modelo\compras\LoteProcessoCompra,
    ArrayObject,
    sgp\Funcionario,
    modelo\compras\SituacaoProcessoDeCompra;

/**
 * Description of ProcessoCompra
 *
 * @author alex.bertolla
 */
class ProcessoCompra {

    private $id;
    private $numero;
    private $modalidade;
    private $modalidadeId;
    private $numeroModalidade;
    private $objeto;
    private $justificativa;
    private $dataAbertura;
    private $dataEncerramento;
    private $responsavel;
    private $responsavelClass;
    private $listaLoteProcessoCompra;
    private $consolidado;
    private $bloqueado;
    private $encerrado;
    private $situacaoId;
    private $situacao;

    public function __construct() {
        $this->modalidade = new Modalidade();
        $this->responsavelClass = new Funcionario();
        $this->listaLoteProcessoCompra = new ArrayObject();
        $this->situacao = new SituacaoProcessoDeCompra();
    }

    function addLote(LoteProcessoCompra $loteProcessoCompra) {
        $this->listaLoteProcessoCompra->append($loteProcessoCompra);
    }

    function getId() {
        return $this->id;
    }

    function getNumero() {
        return $this->numero;
    }

    function getModalidade() {
        return $this->modalidade;
    }

    function getModalidadeId() {
        return $this->modalidadeId;
    }

    function getNumeroModalidade() {
        return $this->numeroModalidade;
    }

    function getObjeto() {
        return $this->objeto;
    }

    function getJustificativa() {
        return $this->justificativa;
    }

    function getDataAbertura() {
        return $this->dataAbertura;
    }

    function getDataEncerramento() {
        return $this->dataEncerramento;
    }

    function getResponsavel() {
        return $this->responsavel;
    }

    function getResponsavelClass() {
        return $this->responsavelClass;
    }

    function getListaLoteProcessoCompra() {
        return $this->listaLoteProcessoCompra;
    }

    function getConsolidado() {
        return $this->consolidado;
    }

    function getBloqueado() {
        return $this->bloqueado;
    }

    function getEncerrado() {
        return $this->encerrado;
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

    function setModalidade($modalidade) {
        $this->modalidade = $modalidade;
    }

    function setModalidadeId($modalidadeId) {
        $this->modalidadeId = $modalidadeId;
    }

    function setNumeroModalidade($numeroModalidade) {
        $this->numeroModalidade = $numeroModalidade;
    }

    function setObjeto($objeto) {
        $this->objeto = $objeto;
    }

    function setJustificativa($justificativa) {
        $this->justificativa = $justificativa;
    }

    function setDataAbertura($dataAbertura) {
        $this->dataAbertura = $dataAbertura;
    }

    function setDataEncerramento($dataEncerramento) {
        $this->dataEncerramento = $dataEncerramento;
    }

    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    function setResponsavelClass($responsavelClass) {
        $this->responsavelClass = $responsavelClass;
    }

    function setListaLoteProcessoCompra($listaLoteProcessoCompra) {
        $this->listaLoteProcessoCompra = $listaLoteProcessoCompra;
    }

    function setConsolidado($consolidado) {
        $this->consolidado = $consolidado;
    }

    function setBloqueado($bloqueado) {
        $this->bloqueado = $bloqueado;
    }

    function setEncerrado($encerrado) {
        $this->encerrado = $encerrado;
    }

    function setSituacaoId($situacaoId) {
        $this->situacaoId = $situacaoId;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    public function __destruct() {
        unset($this->modalidade, $this->responsavelClass);
    }

}
