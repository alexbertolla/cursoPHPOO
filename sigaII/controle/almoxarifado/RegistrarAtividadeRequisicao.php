<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\almoxarifado;

use modelo\almoxarifado\RequisicaoAtividade,
    dao\almoxarifado\RequisicaoAtividadeDao,
    Exception;

/**
 * Description of RegistrarAtividadeRequisicao
 *
 * @author alex.bertolla
 */
class RegistrarAtividadeRequisicao {

    private $atividade;
    private $atividadeDao;

    public function __construct() {
        $this->atividade = new RequisicaoAtividade();
        $this->atividadeDao = new RequisicaoAtividadeDao();
    }

    function registarAtividadeRequisicao($matricula, $requisicaoId, $situacaoId) {
        if ($this->atividadeDao->inserirDao($matricula, $requisicaoId, $situacaoId)) {
            return TRUE;
        } else {
            throw new Exception("ERRO AO REGISTRAR ATIVIDADE REQUISIÇÃO");
        }
    }

    function getAtividade() {
        return $this->atividade;
    }

    function setAtividade($atividade) {
        $this->atividade = $atividade;
    }

    public function __destruct() {
        unset($this->atividade, $this->atividadeDao);
    }

}
