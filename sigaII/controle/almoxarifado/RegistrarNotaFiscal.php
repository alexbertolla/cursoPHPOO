<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\almoxarifado;

use modelo\almoxarifado\NotaFiscal,
    dao\almoxarifado\NotaFiscalDao;

/**
 * Description of RegistrarNotaFiscal
 *
 * @author alex.bertolla
 */
class RegistrarNotaFiscal {

    private $notaFiscal;
    private $notaFiscalDao;

    public function __construct() {
        $this->notaFiscal = new NotaFiscal();
        $this->notaFiscalDao = new NotaFiscalDao();
    }

    function inserir() {
        return $this->notaFiscalDao->inserirDao($this->notaFiscal->getNumero(), $this->notaFiscal->getChaveAcesso(), $this->notaFiscal->getEntradaId(), $this->notaFiscal->getFornecedorId());
    }

    function excluirPorEntradaId($entradaId) {
        return $this->notaFiscalDao->excluirPorEntradaIdDao($entradaId);
    }

    function buscarPorId($id) {
        return $this->notaFiscalDao->buscarPorIdDao($id);
    }

    function buscarPorEntradaId($entradaId) {
        return $this->notaFiscalDao->buscarPorEntradaIdDao($entradaId);
    }

    function setAtribustos($atributos) {
        $this->notaFiscal->setId($atributos->id);
        $this->notaFiscal->setNumero($atributos->numero);
        $this->notaFiscal->setChaveAcesso($atributos->chaveAcesso);
        $this->notaFiscal->setEntradaId($atributos->entradaId);
        $this->notaFiscal->setFornecedorId($atributos->fornecedorId);
    }

    function getNotaFiscal() {
        return $this->notaFiscal;
    }

    function setNotaFiscal($notaFiscal) {
        $this->notaFiscal = $notaFiscal;
    }

    public function __destruct() {
        unset($this->notaFiscal, $this->notaFiscalDao);
    }

}
