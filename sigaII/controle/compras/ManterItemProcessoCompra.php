<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use modelo\compras\ItemProcessoCompra,
    controle\compras\ManterItemPedido,
    controle\compras\ManterOrdemDeCompra,
    dao\compras\ItemProcessoCompraDao,
    controle\compras\ManterSituacaoItemPedido,
    modelo\compras\EnumSituacaoItemPedido;

/**
 * Description of ManterItemProcessoCompra
 *
 * @author alex.bertolla
 */
class ManterItemProcessoCompra {

    private $itemProcessoCompra;
    private $itemProcessoCompraDao;
    private $manterSituacao;

    public function __construct() {
        $this->itemProcessoCompra = new ItemProcessoCompra();
        $this->itemProcessoCompraDao = new ItemProcessoCompraDao();
        $this->manterSituacao = new ManterSituacaoItemPedido;
    }

    function salvar($opcao) {
        switch ($opcao) {
            case "inserir":
                $resultado = $this->inserir();
                break;
            case "excluir":
                $resultado = $this->excluir();
                break;
            case "excluirPorProcesso":
                $resultado = $this->excluirPorProcesso();
                break;
        }
        return $resultado;
    }

    function buscarItemJaCadastrado($pedidoId, $itemId) {
        return $this->itemProcessoCompraDao->buscarItemJaCadastradoDao($pedidoId, $itemId);
    }

    private function inserir() {
//        if ($this->excluirPorProcessoIdEItemId()) {
        $this->atualizarSituacaoItemPedido(EnumSituacaoItemPedido::IncProcesso);
        return $this->itemProcessoCompraDao->inserirDao($this->itemProcessoCompra->getLoteId(), $this->itemProcessoCompra->getProcessoCompraId(), $this->itemProcessoCompra->getPedidoId(), $this->itemProcessoCompra->getItemId(), $this->itemProcessoCompra->getQuantidade());
//        }
//        return FALSE;
    }

    private function excluirPorProcesso() {
        if ($this->itemProcessoCompraDao->excluirPorProcessoDao($this->itemProcessoCompra->getProcessoCompraId())) {
            return TRUE;
        }
        return FALSE;
    }

    private function excluirPorProcessoIdEItemId() {
        if ($this->itemProcessoCompraDao->excluirPorProcessoIdEItemIdDao($this->itemProcessoCompra->getProcessoCompraId(), $this->itemProcessoCompra->getItemId())) {
            return TRUE;
        }
        return FALSE;
    }

    private function excluir() {
        $excluir = $this->itemProcessoCompraDao->excluirDao($this->itemProcessoCompra->getProcessoCompraId(), $this->itemProcessoCompra->getPedidoId(), $this->itemProcessoCompra->getItemId());
        if ($excluir) {
            $this->atualizarSituacaoItemPedido(EnumSituacaoItemPedido::AgProcesso);
        }
        return $excluir;
    }

    function atualizarSituacaoItemPedido($codigoSituacao) {
        $this->setSituacaoPorCodigo($codigoSituacao);
        $tipoInterface = ManterItemPedido::getTipoPedidoPorId($this->itemProcessoCompra->getPedidoId());
//        $tipoInterface = $pedido->getTipo();
        $manterItemPedido = new ManterItemPedido($tipoInterface);
        $manterItemPedido->atualizarSituacaoPorItem($this->itemProcessoCompra->getPedidoId(), $this->itemProcessoCompra->getItemId(), $this->itemProcessoCompra->getSituacaoId());
        unset($manterItemPedido);
    }

    function alterarLote($loteId, $processoCompraId, $itemId) {
        return $this->itemProcessoCompraDao->alterarLoteDao($loteId, $processoCompraId, $itemId);
    }

    function consolidar($processoCompraId) {
        $listaItemProcesso = $this->itemProcessoCompraDao->listarPorProcessoCompraDao($processoCompraId);
        foreach ($listaItemProcesso as $itemProcesso) {
            $this->setItemProcessoCompra($itemProcesso);
            $this->setHeranca();
            $this->itemProcessoCompraDao->consolidarValoresEFornecedorDao($processoCompraId, $itemProcesso->getItemId(), $itemProcesso->getPedidoId());
        }
    }

    function gerarOrdemDeCompraPorFornecedores($processoCompraId) {
        $manterOrdemDeCompra = new ManterOrdemDeCompra();
        $listaItemProcesso = $this->itemProcessoCompraDao->listarPorProcessoCompraAgrupadosPorFornecedorDao($processoCompraId);
        foreach ($listaItemProcesso as $itemProcessoCompra) {
            $manterOrdemDeCompra->gerarNova($itemProcessoCompra->getTipoFornecedor(), $processoCompraId, $itemProcessoCompra->getFornecedorId());
        }
        unset($manterOrdemDeCompra);
    }

    function listarPorLote($loteId) {
        $listaItemProcesso = $this->itemProcessoCompraDao->listarPorLoteDao($loteId);
        $this->setListaHeranca($listaItemProcesso);
        $this->setDetalhesLitaItens($listaItemProcesso);
        return $listaItemProcesso;
    }

    function listarPorLoteConsolidado($loteId) {
        $listaItemProcesso = $this->itemProcessoCompraDao->listarPorLoteConsolidadoDao($loteId);
        $this->setListaHeranca($listaItemProcesso);
        $this->setDetalhesLitaItens($listaItemProcesso);
        return $listaItemProcesso;
    }

    function listarParaMontarOrdemDeCompraDao($numeroOrdemDeCompra, $sequencia = '%') {
        $listaItemProcesso = $this->itemProcessoCompraDao->listarParaMontarOrdemDeCompraDao($numeroOrdemDeCompra, $sequencia);
        $this->setListaHeranca($listaItemProcesso);
        $this->setDetalhesLitaItens($listaItemProcesso);
        return $listaItemProcesso;
    }

    function setDetalhesLitaItens($listaItemProcesso) {
        foreach ($listaItemProcesso as $itemProcesso) {
            $this->setItemProcessoCompra($itemProcesso);
            $this->setDetalhesItem();
        }
    }

    private function setListaHeranca($listaItemProcesso) {
        foreach ($listaItemProcesso as $itemProcesso) {
            $this->setItemProcessoCompra($itemProcesso);
            $this->setHeranca();
        }
    }

    private function setHeranca() {
        $this->itemProcessoCompra->setPedidoId($this->itemProcessoCompra->pedidoId);
        $this->itemProcessoCompra->setItemId($this->itemProcessoCompra->itemId);
        $this->itemProcessoCompra->setQuantidade($this->itemProcessoCompra->quantidade);
    }

    function setDetalhesItem() {
        $this->setItemPedido();
    }

    private function setItemPedido() {
        $tipoInterface = ManterItemPedido::getTipoPedidoPorId($this->itemProcessoCompra->getPedidoId());
        $manterIP = new ManterItemPedido($tipoInterface);
        $item = $manterIP->buscarItemPorId($this->itemProcessoCompra->getItemId());
        $this->itemProcessoCompra->setItem($item);
        unset($tipoInterface, $manterIP, $item, $pedido);
    }

    function setSituacaoPorCodigo($codigo) {
        $situacao = $this->manterSituacao->buscarPorCodigo($codigo);
        $this->itemProcessoCompra->setSituacao($situacao);
        $this->itemProcessoCompra->setSituacaoId($situacao->getId());
    }

    function setAtributos($atributos) {
        $this->itemProcessoCompra->setLoteId($atributos->loteId);
        $this->itemProcessoCompra->setProcessoCompraId($atributos->processoCompraId);
        $this->itemProcessoCompra->setPedidoId($atributos->pedidoId);
        $this->itemProcessoCompra->setItemId($atributos->itemId);
        $this->itemProcessoCompra->setQuantidade($atributos->quantidade);
//        return $this->getItemProcessoCompra();
    }

    function getItemProcessoCompra() {
        return $this->itemProcessoCompra;
    }

    function setItemProcessoCompra($itemProcessoCompra) {
        $this->itemProcessoCompra = $itemProcessoCompra;
    }

}
