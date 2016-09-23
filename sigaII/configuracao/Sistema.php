<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace configuracao;

/**
 * Description of Sistema
 *
 * @author alex.bertolla
 */
class Sistema {

    private $id;
    private $anoSistema;
    private $liberado;

    public function __construct() {
        
    }

    public function __destruct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getAnoSistema() {
        return $this->anoSistema;
    }

    function getLiberado() {
        return $this->liberado;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setAnoSistema($anoSistema) {
        $this->anoSistema = $anoSistema;
    }

    function setLiberado($liberado) {
        $this->liberado = $liberado;
    }

}
