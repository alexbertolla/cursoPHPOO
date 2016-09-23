<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\cadastros;

/**
 * Description of FornecedorPessoaFisica
 *
 * @author alex.bertolla
 */
class FornecedorPessoaFisica extends Fornecedor {

    private $cpf;
    private $pis;
    private $rg;
    private $orgaoExpeditor;
    private $dataExpedicao;

    function toString() {
        $string = "(" . parent::toString() . ", " .
                "cpf=>{$this->getCpf()}, " .
                "pis=>{$this->getPis()}, " .
                "rg=>{$this->getRg()}, " .
                "orgaoExpeditor=>{$this->getOrgaoExpeditor()}, " .
                "dataExpedicao=>{$this->getDataExpedicao()}"
                . ")";
        return $string;
    }

    public function __construct() {
        parent::__construct();
    }

    public function __destruct() {
        parent::__destruct();
    }

    function getDocumento() {
        return $this->cpf;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getPis() {
        return $this->pis;
    }

    function getRg() {
        return $this->rg;
    }

    function getOrgaoExpeditor() {
        return $this->orgaoExpeditor;
    }

    function getDataExpedicao() {
        return $this->dataExpedicao;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function setPis($pis) {
        $this->pis = $pis;
    }

    function setRg($rg) {
        $this->rg = $rg;
    }

    function setOrgaoExpeditor($orgaoExpeditor) {
        $this->orgaoExpeditor = $orgaoExpeditor;
    }

    function setDataExpedicao($dataExpedicao) {
        $this->dataExpedicao = $dataExpedicao;
    }

}
