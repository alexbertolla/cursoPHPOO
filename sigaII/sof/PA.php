<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PA
 *
 * @author alex.bertolla
 */

namespace sof;

use webservices\WSSof;

class PA {

    private $id;
    private $codigo;
    private $titulo;
    private $responsavel;
    private $saldoCusteio;
    private $saldoInvestimento;

    public function __construct() {
        
    }

    function listarPA($ano, $parametro='%') {
        $wsSosf = new WSSof();
        return $wsSosf->listarPA($ano, $parametro);
    }

    function buscarPaPorId($id) {
        $wsSof = new WSSof();
        return $wsSof->buscarPaPorId($id);
    }
    
    function buscarPaSaldoPorId($id, $ano) {
        $wsSof = new WSSof();
        return $wsSof->buscarPaSaldoPorId($id, $ano);
    }

    function getId() {
        return $this->id;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getResponsavel() {
        return $this->responsavel;
    }

    function getSaldoCusteio() {
        return $this->saldoCusteio;
    }

    function getSaldoInvestimento() {
        return $this->saldoInvestimento;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    function setSaldoCusteio($saldoCusteio) {
        $this->saldoCusteio = $saldoCusteio;
    }

    function setSaldoInvestimento($saldoInvestimento) {
        $this->saldoInvestimento = $saldoInvestimento;
    }

    public function __destruct() {
        
    }

}
