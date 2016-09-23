<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PlanoAcao
 *
 * @author alex.bertolla
 */

namespace financeiro;

class PlanoAcao {

    private $numeroSeg;
    private $titulo;
    private $responsavel;
    private $saldoCusteio;
    private $saldoInvestimento;

    function getNumeroSeg() {
        return $this->numeroSeg;
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

    function setNumeroSeg($numeroSeg) {
        $this->numeroSeg = $numeroSeg;
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

}
