<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\cadastros;
use modelo\cadastros\Banco;
/**
 * Description of DadosBancario
 *
 * @author alex.bertolla
 */
class DadosBancario {

    private $id;
    private $bancoId;
    private $fornecedorId;
    private $agencia;
    private $conta;
    private $situacao;
    private $banco;

    public function __construct() {
        $this->banco = new Banco();
    }

    public function __destruct() {
        unset($this->banco);
    }

    function getId() {
        return $this->id;
    }

    function getBancoId() {
        return $this->bancoId;
    }

    function getFornecedorId() {
        return $this->fornecedorId;
    }

    function getAgencia() {
        return $this->agencia;
    }

    function getConta() {
        return $this->conta;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function getBanco() {
        return $this->banco;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setBancoId($bancoId) {
        $this->bancoId = $bancoId;
    }

    function setFornecedorId($fornecedorId) {
        $this->fornecedorId = $fornecedorId;
    }

    function setAgencia($agencia) {
        $this->agencia = $agencia;
    }

    function setConta($conta) {
        $this->conta = $conta;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setBanco($banco) {
        $this->banco = $banco;
    }

    function toString() {
        $string = "(" .
                "id=>{$this->getId()}, " .
                "agencia=>{$this->getAgencia()}, " .
                "conta=>{$this->getConta()}, " .
                "bancoId=>{$this->getBancoId()}, " .
                "fornecedorId=>{$this->getFornecedorId()}, " .
                "situacao=>{$this->getSituacao()}"
                . ")";
        return $string;
    }

}
