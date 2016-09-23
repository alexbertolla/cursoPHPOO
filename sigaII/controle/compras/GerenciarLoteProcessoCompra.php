<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use modelo\compras\LoteProcessoCompra,
    dao\compras\LoteProcessoCompraDao,
    controle\compras\ManterItemProcessoCompra;

/**
 * Description of GerenciarLoteProcessoCompra
 *
 * @author alex.bertolla
 */
class GerenciarLoteProcessoCompra {

    private $loteProcessoCompra;
    private $loteProcessoCompraDao;

    public function __construct() {
        $this->loteProcessoCompra = new LoteProcessoCompra();
        $this->loteProcessoCompraDao = new LoteProcessoCompraDao();
    }

    function gerarNovoLotePorProcessoCompra($processoCompraId, $modalidadeId) {
        $this->loteProcessoCompra->setProcessoCompraId($processoCompraId);
        $this->loteProcessoCompra->setModalidadeId($modalidadeId);
        $this->inserir();
    }

    function listarPorProcessoCompra($processoCompraId) {
        $lista = $this->loteProcessoCompraDao->listarPorProcessoCompraDao($processoCompraId);
        return $lista;
    }

    function setListaItensLote($listaLote) {
        foreach ($listaLote as $loteProcessoCompra) {
            $this->setLoteProcessoCompra($loteProcessoCompra);
            $this->SetItensLote();
        }
    }

    function SetItensLote() {
        $itemProcessoComrpa = new ManterItemProcessoCompra();
        $listaItemLote = $itemProcessoComrpa->listarPorLote($this->loteProcessoCompra->getId());
        $this->loteProcessoCompra->setListaItemProcessoCompra($listaItemLote);
    }
    
    function setListaItensLoteConsolidado($listaLote) {
        foreach ($listaLote as $loteProcessoCompra) {
            $this->setLoteProcessoCompra($loteProcessoCompra);
            $this->setItensLoteConsolidado();
        }
    }

    function setItensLoteConsolidado() {
        $itemProcessoCompra = new ManterItemProcessoCompra();
        $listaItemProcessoCompraConsolidado = $itemProcessoCompra->listarPorLoteConsolidado($this->loteProcessoCompra->getId());
        $this->loteProcessoCompra->setListaItemProcessoCompra($listaItemProcessoCompraConsolidado);
    }

    function salvar($opcao) {
        switch ($opcao) {
            case "inserir":
                $resultado = $this->inserir();
                break;
            case "excluirPorProcessoCompra":
                $resultado = $this->excluirPorProcessoCompra();
                break;
        }
        return $resultado;
    }

    function gerarLote($processoCompraId, $modalidadeId) {
        $this->loteProcessoCompra->setProcessoCompraId($processoCompraId);
        $this->loteProcessoCompra->setModalidadeId($modalidadeId);
        $this->inserir();
    }

    private function inserir() {
        $id = $this->loteProcessoCompraDao->inserirDao($this->loteProcessoCompra->getProcessoCompraId(), $this->loteProcessoCompra->getModalidadeId());
        $this->loteProcessoCompra->setId($id);
        return $id;
    }

    private function excluirPorProcessoCompra() {
        return $this->loteProcessoCompraDao->excluirPorProcessoCompraDao($this->loteProcessoCompra->getProcessoCompraId());
    }

    function alterarLoteItem($loteId, $processoCompraId, $itemId) {
        $manterItem = new ManterItemProcessoCompra();
        $manterItem->alterarLote($loteId, $processoCompraId, $itemId);
        unset($manterItem);
    }

    function getLoteProcessoCompra() {
        return $this->loteProcessoCompra;
    }

    function setLoteProcessoCompra($loteProcessoCompra) {
        $this->loteProcessoCompra = $loteProcessoCompra;
    }

    public function __destruct() {
        unset($this->loteProcessoCompra, $this->loteProcessoCompraDao);
    }

}
