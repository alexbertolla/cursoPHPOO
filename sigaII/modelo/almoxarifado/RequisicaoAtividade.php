<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\almoxarifado;

use modelo\almoxarifado\RequisicaoMaterial,
    modelo\almoxarifado\SituacaoRequisicao,
    sgp\Funcionario;

/**
 * Description of RequisicaoAtividade
 *
 * @author alex.bertolla
 */
class RequisicaoAtividade {

    private $id;
    private $data;
    private $matriculaResponsavel;
    private $responsavel;
    private $requisicaoId;
    private $requisicao;
    private $situacaoId;
    private $situacao;

    public function __construct() {
        $this->responsavel = new Funcionario();
        $this->requisicao = new RequisicaoMaterial();
        $this->situacao = new SituacaoRequisicao();
    }

    function getId() {
        return $this->id;
    }

    function getData() {
        return $this->data;
    }

    function getMatriculaResponsavel() {
        return $this->matriculaResponsavel;
    }

    function getResponsavel() {
        return $this->responsavel;
    }

    function getRequisicaoId() {
        return $this->requisicaoId;
    }

    function getRequisicao() {
        return $this->requisicao;
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

    function setData($data) {
        $this->data = $data;
    }

    function setMatriculaResponsavel($matriculaResponsavel) {
        $this->matriculaResponsavel = $matriculaResponsavel;
    }

    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    function setRequisicaoId($requisicaoId) {
        $this->requisicaoId = $requisicaoId;
    }

    function setRequisicao($requisicao) {
        $this->requisicao = $requisicao;
    }

    function setSituacaoId($situacaoId) {
        $this->situacaoId = $situacaoId;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    public function __destruct() {
        unset($this->responsavel, $this->requisicao, $this->situacao);
    }

}
