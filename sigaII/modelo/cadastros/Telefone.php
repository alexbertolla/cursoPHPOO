<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\cadastros;

/**
 * Description of Telefone
 *
 * @author alex.bertolla
 */
class Telefone {

    private $id;
    private $fornecedorId;
    private $ddi;
    private $ddd;
    private $numero;

    public function __construct() {
        
    }

    public function __destruct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getFornecedorId() {
        return $this->fornecedorId;
    }

    function getDdi() {
        return $this->ddi;
    }

    function getDdd() {
        return $this->ddd;
    }

    function getNumero() {
        return $this->numero;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFornecedorId($fornecedorId) {
        $this->fornecedorId = $fornecedorId;
    }

    function setDdi($ddi) {
        $this->ddi = $ddi;
    }

    function setDdd($ddd) {
        $this->ddd = $ddd;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function toString() {
        $string = "(" .
                "id=>{$this->getId()}, " .
                "fornecedorId=>{$this->getFornecedorId()}, " .
                "ddi=>{$this->getDdi()}, " .
                "ddd=>{$this->getDdd()}, " .
                "numero=>{$this->getNumero()}"
                . ")";
        return $string;
    }

}
