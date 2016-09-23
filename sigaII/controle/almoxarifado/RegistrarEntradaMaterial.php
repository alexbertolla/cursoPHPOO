<?php

namespace controle\almoxarifado;

use modelo\almoxarifado\EntradaMaterial,
    dao\almoxarifado\EntradaMaterialDao,
    controle\almoxarifado\RegistrarItemEntrada,
    controle\AdapterFornecedor,
    controle\almoxarifado\GerenciarEstoque,
    controle\almoxarifado\RegistrarNotaFiscal,
    configuracao\DataSistema;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegistrarEntradaMaterial
 *
 * @author alex.bertolla
 */
class RegistrarEntradaMaterial {

    private $entrada;
    private $registrarItemEntrada;
    private $registrarNotaFiscal;
    private $entradaDao;

    public function __construct() {
        $this->entrada = new EntradaMaterial();
        $this->entradaDao = new EntradaMaterialDao();
        $this->registrarItemEntrada = new RegistrarItemEntrada();
        $this->registrarNotaFiscal = new RegistrarNotaFiscal();
    }

    function listar() {
        return $this->entradaDao->listarDao();
    }

    function buscarPorId($id) {
        return $this->entradaDao->buscarPorIdDao($id);
    }

    function buscarPorNumero($numero) {
        $entrada = $this->entradaDao->buscarPorNumeroDao($numero);
        $this->setEntrada($entrada);
        $this->bdToForm();
        return $this->getEntrada();
    }

    function registrarEntradaMaterial() {
        $this->entrada->calcularValor();
        $inserir = $this->inserir();
        if ($inserir) {
            $this->registrarNotaFiscal();
            $inserir = $this->registrarItemEntrada();
        }
        return $inserir;
    }

    private function inserir() {
        $id = $this->entradaDao->inserirDao($this->entrada->getFornecedorId(), $this->entrada->getAlmoxarifadoVirtualId(), $this->entrada->getNaturezaOperacaoId(), $this->entrada->getOrdemDeCompraId(), $this->entrada->getProcessoCompraId(), $this->entrada->getValor(), $this->entrada->getTipoFornecedor(), $this->entrada->getAno());
        if ($id) {
            $this->entrada->setId($id);
        }
        return $id;
    }

    private function registrarNotaFiscal() {
        $notaFiscal = $this->entrada->getNotaFiscal();
        $notaFiscal->setEntradaId($this->entrada->getId());
        $this->registrarNotaFiscal->setNotaFiscal($notaFiscal);
        return $this->registrarNotaFiscal->inserir();
    }

    function registrarItemEntrada() {
        foreach ($this->entrada->getListaItemEntrada() as $itemEntrada) {
            $itemEntrada->setEntradaId($this->entrada->getId());
            $this->registrarItemEntrada->setItemEntrada($itemEntrada);
            if ($this->registrarItemEntrada->inserir()) {
                $inserir = $this->atualizarItemEstoque($itemEntrada);
            }
        }
        return $inserir;
    }

    private function atualizarItemEstoque($itemEntrada) {
        $gerenciarEstoque = new GerenciarEstoque();
        return $gerenciarEstoque->registrarEntradaItem($itemEntrada);
    }

    function listaBdtoForm($listaEntradaMaterial) {
        foreach ($listaEntradaMaterial as $entradaMaterial) {
            $this->setEntrada($entradaMaterial);
            $this->bdToForm();
        }
        return $listaEntradaMaterial;
    }

    function bdToForm() {
        $this->formataData();
        $this->setDadosEntrada();
    }

    private function formataData() {
        $dataSistema = new DataSistema();
        $this->entrada->setData($dataSistema->ISOtoBR($this->entrada->getData()));
        unset($dataSistema);
    }

    function setDadosEntrada() {
        $this->setNotaFiscal();
        $this->setFornecedor();
    }

    private function setNotaFiscal() {
        $notaFiscal = $this->registrarNotaFiscal->buscarPorEntradaId($this->entrada->getId());
        $this->entrada->setNotaFiscal($notaFiscal);
    }

    private function setFornecedor() {
        $adapterFornecedor = new AdapterFornecedor($this->entrada->getTipoFornecedor());
        $fornecedor = $adapterFornecedor->buscarPorId($this->entrada->getFornecedorId());
        $this->entrada->setFornecedor($fornecedor);
        unset($adapterFornecedor);
    }

    function setAtributos($atributos) {
        $this->entrada->setId($atributos->id);
        $this->entrada->setNumero($atributos->numero);
        $this->entrada->setFornecedorId($atributos->fornecedorId);
        $this->entrada->setTipoFornecedor($atributos->tipoFornecedor);
        $this->entrada->setAlmoxarifadoVirtualId(($atributos->almoxarifadoVirtualId) ? $atributos->almoxarifadoVirtualId : "NULL");
        $this->entrada->setNaturezaOperacaoId($atributos->naturezaOperacaoId);
        $this->entrada->setOrdemDeCompraId(($atributos->ordemCompraId) ? $atributos->ordemCompraId : "NULL");
        $this->entrada->setProcessoCompraId(($atributos->processoCompraId) ? $atributos->processoCompraId : "NULL");
        $this->entrada->setValor($atributos->valor);
        $this->entrada->setAno($atributos->ano);
        $this->registrarNotaFiscal->setAtribustos((object) $atributos->notaFiscal);
//        $this->registrarItemEntrada->setListaAtributos((object) $atributos->listaItemEntrada, $this->entrada);
        $this->entrada->setNotaFiscal($this->registrarNotaFiscal->getNotaFiscal());
    }

    function setAtributosItemEntrada($listaAtributoItemEntrada) {
        foreach ($listaAtributoItemEntrada as $atributosItemEntrada) {
            $this->entrada->adicionarItem($this->registrarItemEntrada->setAtributos((object) $atributosItemEntrada));
        }
    }

    function getEntrada() {
        return $this->entrada;
    }

    function setEntrada($entrada) {
        $this->entrada = $entrada;
    }

    public function __destruct() {
        unset($this->entrada, $this->entradaDao, $this->registrarItemEntrada);
    }

}
