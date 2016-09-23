<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\configuracao;

use configuracao\Sistema,
    dao\configuracao\SistemaDao;

/**
 * Description of SistemaControle
 *
 * @author alex.bertolla
 */
class SistemaControle {

    private $sistema;
    private $sistemaDao;

    public function __construct() {
        $this->sistema = new Sistema();
        $this->sistemaDao = new SistemaDao();
    }

    function verificaSistemaLiberado() {
        $infoSistema = $this->buscarInfoSistema();
        return $infoSistema->getLiberado();
    }

    function buscarInfoSistema() {
        $this->setSistema($this->sistemaDao->buscarInfoSistemaDao());
        return $this->getSistema();
    }

    function salvar($opcao) {
        switch ($opcao) {
            case "inserir":
                $resultado = $this->inserir();
                break;
            case "alterar":
                $resultado = $this->alterar();
                break;
        }
        return $resultado;
    }

    private function inserir() {
        return $this->sistemaDao->inserirDao($this->sistema->getAnoSistema(), $this->sistema->getLiberado());
    }

    private function alterar() {
        return $this->sistemaDao->alterarDao($this->sistema->getAnoSistema(), $this->sistema->getLiberado());
    }

    function setAtributos($atributos) {
        $this->sistema->setAnoSistema($atributos->anoSistema);
        $this->sistema->setLiberado(($atributos->liberado) ? 1 : 0);
    }

    function setSistema($sistema) {
        $this->sistema = $sistema;
    }

    function getSistema() {
        return $this->sistema;
    }

    public function __destruct() {
        unset($this->sistema, $this->sistemaDao);
    }

}
