<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\almoxarifado;

use modelo\almoxarifado\SituacaoRequisicao,
    modelo\almoxarifado\ItemRequisicao,
    sgp\Funcionario,
    sgp\Lotacao,
    sof\PA,
    ArrayObject;

/**
 * Description of Requisicao
 *
 * @author alex.bertolla
 */
class RequisicaoMaterial {

    private $id;
    private $numero;
    private $matriculaRequisitante;
    private $requisitante;
    private $matriculaResponsavel;
    private $responsavel;
    private $dataRequisicao;
    private $dataAtendimento;
    private $paId;
    private $pa;
    private $lotacaoId;
    private $lotacao;
    private $situacao;
    private $situacaoId;
    private $valor;
    private $ano;
    private $enviada;
    private $atendida;
    private $encerrada;
    private $listaItemRequisicao;

    public function __construct() {
        
        $this->requisitante = new Funcionario();
        $this->responsavel = new Funcionario();
        $this->pa = new PA();
        $this->lotacao = new Lotacao();
        $this->situacao = new SituacaoRequisicao();
        $this->listaItemRequisicao = new ArrayObject();
    }

    function adicionarItemRequisicao(ItemRequisicao $itemRequisicao) {
        $this->listaItemRequisicao->append($itemRequisicao);
        $this->calcularValor($itemRequisicao->getValorTotal());
    }

    private function calcularValor($valor) {
        $this->valor+= $valor;
    }

    function getId() {
        return $this->id;
    }

    function getNumero() {
        return $this->numero;
    }

    function getMatriculaRequisitante() {
        return $this->matriculaRequisitante;
    }

    function getRequisitante() {
        return $this->requisitante;
    }

    function getMatriculaResponsavel() {
        return $this->matriculaResponsavel;
    }

    function getResponsavel() {
        return $this->responsavel;
    }

    function getDataRequisicao() {
        return $this->dataRequisicao;
    }

    function getDataAtendimento() {
        return $this->dataAtendimento;
    }

    function getPaId() {
        return $this->paId;
    }

    function getPa() {
        return $this->pa;
    }

    function getLotacaoId() {
        return $this->lotacaoId;
    }

    function getLotacao() {
        return $this->lotacao;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function getSituacaoId() {
        return $this->situacaoId;
    }

    function getValor() {
        return $this->valor;
    }

    function getAno() {
        return $this->ano;
    }

    function getEnviada() {
        return $this->enviada;
    }

    function getAtendida() {
        return $this->atendida;
    }

    function getEncerrada() {
        return $this->encerrada;
    }

    function getListaItemRequisicao() {
        return $this->listaItemRequisicao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setMatriculaRequisitante($matriculaRequisitante) {
        $this->matriculaRequisitante = $matriculaRequisitante;
    }

    function setRequisitante($requisitante) {
        $this->requisitante = $requisitante;
    }

    function setMatriculaResponsavel($matriculaResponsavel) {
        $this->matriculaResponsavel = $matriculaResponsavel;
    }

    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    function setDataRequisicao($dataRequisicao) {
        $this->dataRequisicao = $dataRequisicao;
    }

    function setDataAtendimento($dataAtendimento) {
        $this->dataAtendimento = $dataAtendimento;
    }

    function setPaId($paId) {
        $this->paId = $paId;
    }

    function setPa($pa) {
        $this->pa = $pa;
    }

    function setLotacaoId($lotacaoId) {
        $this->lotacaoId = $lotacaoId;
    }

    function setLotacao($lotacao) {
        $this->lotacao = $lotacao;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setSituacaoId($situacaoId) {
        $this->situacaoId = $situacaoId;
    }

//    function setValor($valor) {
//        $this->valor = $valor;
//    }

    function setAno($ano) {
        $this->ano = $ano;
    }

    function setEnviada($enviada) {
        $this->enviada = $enviada;
    }

    function setAtendida($atendida) {
        $this->atendida = $atendida;
    }

    function setEncerrada($encerrada) {
        $this->encerrada = $encerrada;
    }

    function setListaItemRequisicao($listaItemRequisicao) {
        $this->listaItemRequisicao = $listaItemRequisicao;
    }

    public function __destruct() {
        unset($this->listaItemRequisicao, $this->situacao, $this->requisitante, $this->pa, $this->lotacao, $this->responsavel);
    }

}
