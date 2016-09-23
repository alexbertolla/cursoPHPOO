<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use modelo\compras\ItemPedido,
    dao\compras\ItemPedidoDao,
    controle\compras\InterfaceItemPedido,
    controle\compras\PedirMaterialConsumo,
    controle\compras\PedirMaterialPermanente,
    controle\compras\PedirServico,
    controle\compras\PedirObra,
    controle\configuracao\GerenciarLog,
    controle\compras\ManterSituacaoItemPedido,
    modelo\compras\EnumSituacaoItemPedido,
    controle\compras\ManterPedido;

/**
 * Description of ManterItemPedido
 *
 * @author alex.bertolla
 */
class ManterItemPedido implements InterfaceItemPedido {

    private $itemPedido;
    private $itemPedidoDao;
    private $interfaceItemPedido;
    private $gerenciarLog;
    private $situacao;

    public function __construct($tipoInterface) {
        $this->itemPedido = new ItemPedido();
        $this->itemPedidoDao = new ItemPedidoDao();
        $this->setTipoInterface($tipoInterface);
        $this->gerenciarLog = new GerenciarLog();
        $this->situacao = new ManterSituacaoItemPedido();
    }

    function salvar($opcao) {
        switch ($opcao) {
            case "inserir":
                $resultado = $this->inserir();
                break;
            case "excluir":
                $resultado = $this->excluir();
                break;
        }
        return $resultado;
    }

    public function buscarItemPedidoConsolidadosPorProcessoCompra($processoCompraId, $itemId) {
        $this->setItemPedido($this->itemPedidoDao->listarItemPedidoConsolidadosPorProcessoCompraDao($processoCompraId, $itemId));
        $this->setDadosItemPedido();
        return $this->getItemPedido();
    }

    public function buscarItemPorId($id) {
//        $this->interfaceItemPedido->buscarItemPorId($id);
        $this->itemPedido->setItem($this->interfaceItemPedido->buscarItemPorId($id));
        return $this->itemPedido->getItem();
    }

    function listarItemPedidoPorPedido($pedidoId) {
        $listaItemPedido = $this->itemPedidoDao->listarItemPedidoPorPedidoDao($pedidoId);
        $this->setDadosListaItemPedido($listaItemPedido);
        return $listaItemPedido;
    }

    function buscarItemPedidoPorPedidoEItem($pedidoId, $itemId) {
        $this->setItemPedido($this->itemPedidoDao->buscarItemPedidoPorPedidoEItemDao($pedidoId, $itemId));
        $this->setDadosItemPedido();
        return $this->getItemPedido();
    }

    private function setDadosListaItemPedido($listaItemPedido) {
        foreach ($listaItemPedido as $itemPedido) {
            $this->setItemPedido($itemPedido);
            $this->setDadosItemPedido();
        }
        return $listaItemPedido;
    }

    private function setDadosItemPedido() {
        $this->itemPedido->setItem($this->buscarItemPorId($this->itemPedido->getItemId()));
        $this->setSituacao();
    }

    function setSituacao() {
        $this->itemPedido->setSituacao($this->situacao->buscarPorId($this->itemPedido->getSituacaoId()));
    }

    static function getTipoPedidoPorId($id) {
        $manterPedido = new ManterPedido();
        $pedido = $manterPedido->buscarPorId($id);
        unset($manterPedido);
        return $pedido->getTipo();
        
        
    }

    private function inserir() {
        $situacao = $this->situacao->buscarPorCodigo(EnumSituacaoItemPedido::EmEdicao);
        return $this->itemPedidoDao->inserirDao($this->itemPedido->getPedidoId(), $this->itemPedido->getItemId(), $this->itemPedido->getQuantidade(), $situacao->getId());
    }

    function excluir($pedidoId) {
        return $this->itemPedidoDao->excluirDao($pedidoId);
    }

    function atualizarSituacaoPorPedido($pedidoId, $situacaoId) {
        return $this->itemPedidoDao->atualizarSituacaoPorPedidoDao($pedidoId, $situacaoId);
    }

    function atualizarSituacaoPorItem($pedidoId, $itemId, $situacaoId) {
        return $this->itemPedidoDao->atualizarSituacaoPorItemDao($pedidoId, $itemId, $situacaoId);
    }

    function setAtributos($atributo) {
        $this->itemPedido->setPedidoId($atributo->pedidoId);
        $this->itemPedido->setItemId($atributo->itemId);
        $this->itemPedido->setQuantidade($atributo->quantidade);
    }

    function getItemPedido() {
        return $this->itemPedido;
    }

    function setItemPedido($itemPedido) {
        $this->itemPedido = $itemPedido;
    }

    private function setTipoInterface($tipoInterface) {
        switch ($tipoInterface) {
            case "materialConsumo":
                $this->interfaceItemPedido = new PedirMaterialConsumo();
                break;
            case "materialPermanente":
                $this->interfaceItemPedido = new PedirMaterialPermanente();
                break;
            case "obra":
                $this->interfaceItemPedido = new PedirObra();
                break;
            case "servico":
                $this->interfaceItemPedido = new PedirServico();
                break;
        }
    }

    public function __destruct() {
        unset($this->interfaceItemPedido, $this->itemPedido, $this->itemPedidoDao);
    }

}
