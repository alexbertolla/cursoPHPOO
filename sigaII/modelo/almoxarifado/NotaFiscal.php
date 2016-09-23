<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotaFiscal
 *
 * @author alex.bertolla
 */

namespace modelo\almoxarifado;

class NotaFiscal {

    private $id;
    private $numero;
    private $chaveAcesso;
    private $entradaId;
    private $fornecedorId;

    function getId() {
        return $this->id;
    }

    function getNumero() {
        return $this->numero;
    }

    function getChaveAcesso() {
        return $this->chaveAcesso;
    }

    function getEntradaId() {
        return $this->entradaId;
    }

    function getFornecedorId() {
        return $this->fornecedorId;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setChaveAcesso($chaveAcesso) {
        $this->chaveAcesso = $chaveAcesso;
    }

    function setEntradaId($entradaId) {
        $this->entradaId = $entradaId;
    }

    function setFornecedorId($fornecedorId) {
        $this->fornecedorId = $fornecedorId;
    }

}
