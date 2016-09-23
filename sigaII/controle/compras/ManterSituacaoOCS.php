<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use modelo\compras\SituacaoOCS,
    dao\compras\SituacaoOCSDao;

/**
 * Description of ManterSituacaoOCS
 *
 * @author alex.bertolla
 */
class ManterSituacaoOCS {

    private $situacaoOCS;
    private $situacaoOCSDao;

    public function __construct() {
        $this->situacaoOCS = new SituacaoOCS();
        $this->situacaoOCSDao = new SituacaoOCSDao();
    }

    function buscarPorId($id) {
        $this->setSituacaoOCS($this->situacaoOCSDao->buscarPorIdDao($id));
        $this->bdToForm();
        return $this->getSituacaoOCS();
    }

    function buscarPorCodigo($codigo) {
        $this->setSituacaoOCS($this->situacaoOCSDao->buscarPorCodigoDao($codigo));
        $this->bdToForm();
        return $this->getSituacaoOCS();
    }

    function bdToForm() {
        $this->situacaoOCS->setSituacao(utf8_encode($this->situacaoOCS->getSituacao()));
    }

    function getSituacaoOCS() {
        return $this->situacaoOCS;
    }

    function setSituacaoOCS($situacaoOCS) {
        $this->situacaoOCS = $situacaoOCS;
    }

    public function __destruct() {
        unset($this->situacaoOCS, $this->situacaoOCSDao);
    }

}
