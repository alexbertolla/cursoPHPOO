<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use configuracao\DataSistema;
use dao\compras\EmpenhoDao;
use modelo\compras\Empenho,
    controle\cadastros\ManterNaturezaDespesa,
    sof\PA,
    controle\compras\ManterPedido;

/**
 * Description of ManterEmpenho
 *
 * @author alex.bertolla
 */
class ManterEmpenho {

    private $empenho;
    private $empenhoDao;
    private $dataSistema;

    public function __construct() {
        $this->empenho = new Empenho();
        $this->empenhoDao = new EmpenhoDao();
        $this->dataSistema = new DataSistema();
    }

    function inserirNovoEmpenhoPorOredemDeCompra($ordemCompraId) {
        return $this->empenhoDao->inserirDao($ordemCompraId);
    }

    private function alterar() {
        return $this->empenhoDao->alterarDao($this->empenho->getId(), $this->empenho->getNumero(), $this->empenho->getData(), $this->empenho->getUnidadeOrcamentaria());
    }

    function salvarListaEmpenho($listaEmpenho) {
        $this->listaFormToBd($listaEmpenho);
        foreach ($listaEmpenho as $empenho) {
            $this->setEmpenho($empenho);
            $this->alterar();
        }
    }

    function listarPorOrdemDeCompra($ordemCompraId) {
        $listaEmpenho = $this->empenhoDao->listarPorOrdemDeCompraDao($ordemCompraId);
        $this->listaBdToForm($listaEmpenho);
        return $listaEmpenho;
    }

    function listaBdToForm($listaEmpenho) {
        foreach ($listaEmpenho as $empenho) {
            $this->setEmpenho($empenho);
            $this->BdToForm();
        }
        return $listaEmpenho;
    }

    function BdToForm() {
//        $this->empenho->setData($this->dataSistema->ISOtoBR($this->empenho->getData()));
        $this->setPA();
        $this->setNaturezaDespesa();
        $this->setPedido();
    }

    function listaFormToBd($listaEmpenho) {
        foreach ($listaEmpenho as $empenho) {
            $this->setEmpenho($empenho);
            $this->formToBd();
        }
        return $listaEmpenho;
    }

    function formToBd() {
//        $this->empenho->setData($this->dataSistema->BRtoISO($this->empenho->getData()));
    }

    function setPA() {
        $pa = new PA();
        $this->empenho->setPa($pa->buscarPaPorId($this->empenho->getPaId()));
        unset($pa);
    }

    function setNaturezaDespesa() {
        $manterND = new ManterNaturezaDespesa();
        $this->empenho->setNaturezaDespesa($manterND->buscarPorId($this->empenho->getNaturezaDespesaId()));
        unset($manterND);
    }

    function setPedido() {
        $manterPedido = new ManterPedido();
        $this->empenho->setPedido($manterPedido->buscarPorId($this->empenho->getPedidoId()));
        unset($manterPedido);
    }

    function getEmpenho() {
        return $this->empenho;
    }

    function setEmpenho($empenho) {
        $this->empenho = $empenho;
    }

    public function __destruct() {
        unset($this->empenho, $this->empenhoDao, $this->dataSistema);
    }

}
