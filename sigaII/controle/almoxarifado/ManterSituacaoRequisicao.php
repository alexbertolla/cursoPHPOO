<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\almoxarifado;

use modelo\almoxarifado\SituacaoRequisicao,
    dao\almoxarifado\SituacaoRequisicaoDao;

/**
 * Description of ManterSituacaoRequisicao
 *
 * @author alex.bertolla
 */
class ManterSituacaoRequisicao {

    private $situacaoRequisicao;
    private $situacaoRequisicaoDao;

    public function __construct() {
        $this->situacaoRequisicao = new SituacaoRequisicao();
        $this->situacaoRequisicaoDao = new SituacaoRequisicaoDao();
    }

    function buscarPorId($id) {
        return $this->situacaoRequisicaoDao->buscarPorIdDao($id);
    }

    function buscarPorCodigo($codigo) {
        return $this->situacaoRequisicaoDao->buscarPorCodigoDao($codigo);
    }

    function getSituacaoRequisicao() {
        return $this->situacaoRequisicao;
    }

    function setSituacaoRequisicao($situacaoRequisicao) {
        $this->situacaoRequisicao = $situacaoRequisicao;
    }

    public function __destruct() {
        unset($this->situacaoRequisicao, $this->situacaoRequisicaoDao);
    }

}
