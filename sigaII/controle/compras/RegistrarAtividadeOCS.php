<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use modelo\compras\AtividadeOCS,
    dao\compras\AtividadeOCSDao,
    configuracao\DataSistema;

/**
 * Description of RegistrarAtividadeOCS
 *
 * @author alex.bertolla
 */
class RegistrarAtividadeOCS {

    private $atividadeOCS;
    private $atividadeOCSDao;
    private $dataSistema;

    public function __construct() {
        $this->atividadeOCS = new AtividadeOCS();
        $this->atividadeOCSDao = new AtividadeOCSDao();
        $this->dataSistema = new DataSistema();
    }

    function registrarAtividade() {
        $this->formToBD();
        return $this->atividadeOCSDao->registrarAtividadeDao($this->atividadeOCS->getAtividade(), $this->atividadeOCS->getOrdemCompraId());
    }

    function listarAtividadePorOCS($ordemDeCompraId) {
        $listaAtividadeOCS = $this->atividadeOCSDao->listarAtividadeDao($ordemDeCompraId);
        $this->listaBdToForm($listaAtividadeOCS);
        return $listaAtividadeOCS;
    }

    function formToBD() {
        $this->atividadeOCS->setAtividade(addslashes($this->atividadeOCS->getAtividade()));
        $this->atividadeOCS->setAtividade(utf8_decode($this->atividadeOCS->getAtividade()));
    }

    function listaBdToForm($listaAtividadeOCS) {
        foreach ($listaAtividadeOCS as $atividadeOCS) {
            $this->setAtividadeOCS($atividadeOCS);
            $this->bdToForm();
        }
        return $listaAtividadeOCS;
    }

    function bdToForm() {
        $this->atividadeOCS->setAtividade(stripslashes($this->atividadeOCS->getAtividade()));
        $this->atividadeOCS->setAtividade(utf8_encode($this->atividadeOCS->getAtividade()));
        $this->atividadeOCS->setData($this->dataSistema->ISOtoBR($this->atividadeOCS->getData()));
    }

    function setAtributos($atributos) {
        $this->atividadeOCS->setId($atributos->id);
        $this->atividadeOCS->setAtividade($atributos->atividade);
        $this->atividadeOCS->setOrdemCompraId($atributos->ordemCompraId);
    }

    function getAtividadeOCS() {
        return $this->atividadeOCS;
    }

    function setAtividadeOCS($atividadeOCS) {
        $this->atividadeOCS = $atividadeOCS;
    }

    public function __destruct() {
        unset($this->atividadeOCS, $this->atividadeOCSDao);
    }

}
