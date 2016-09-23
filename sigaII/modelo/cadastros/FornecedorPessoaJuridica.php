<?php

namespace modelo\cadastros;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FornecedorPessoaJuridica
 *
 * @author alex.bertolla
 */
class FornecedorPessoaJuridica extends Fornecedor {

    private $nomeFantasia;
    private $cnpj;
    private $microEmpresa;

    public function __construct() {
        parent::__construct();
    }

    public function __destruct() {
        parent::__destruct();
    }

    function getNomeFantasia() {
        return $this->nomeFantasia;
    }

    function getDocumento() {
        return $this->cnpj;
    }

    function getCnpj() {
        return $this->cnpj;
    }

    function setNomeFantasia($nomeFantasia) {
        $this->nomeFantasia = $nomeFantasia;
    }

    function getMicroEmpresa() {
        return $this->microEmpresa;
    }

    function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    function setMicroEmpresa($microEmpresa) {
        $this->microEmpresa = $microEmpresa;
    }

    function toString() {
        $string = "(" . parent::toString() . ", "
                . "nomeFantasia=>{$this->getNomeFantasia()}, "
                . "cnpj=>{$this->getCnpj()}"
                . "microEmpresa=>{$this->getMicroEmpresa()}"
                . ")";
        return $string;
    }

}
