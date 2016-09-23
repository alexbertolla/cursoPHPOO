<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use modelo\compras\ItemOrdemDeCompra,
    dao\compras\ItemOrdemDeCompraDao,
    controle\cadastros\ManterNaturezaDespesa,
    controle\compras\ManterItemPedido,
    controle\AdapterItem;

/**
 * Description of ManterItemOrdemDeCompra
 *
 * @author alex.bertolla
 */
class ManterItemOrdemDeCompra {

    private $itemOrdemDeComora;
    private $itemOrdemDeComoraDao;

    public function __construct() {
        $this->itemOrdemDeComora = new ItemOrdemDeCompra();
        $this->itemOrdemDeComoraDao = new ItemOrdemDeCompraDao();
    }

    function inserirPorNovaOrdemCompra() {
//        if ($this->itemOrdemDeComora->getQuantidade() > 0) {
            return $this->itemOrdemDeComoraDao->inserirDao($this->itemOrdemDeComora->getOrdemCompraId(), $this->itemOrdemDeComora->getProcessoCompraId(), $this->itemOrdemDeComora->getFornecedorId(), $this->itemOrdemDeComora->getLoteId(), $this->itemOrdemDeComora->getPedidoId(), $this->itemOrdemDeComora->getItemId(), $this->itemOrdemDeComora->getQuantidade(), $this->itemOrdemDeComora->getValorUnitario(), $this->itemOrdemDeComora->getValorTotal());
//        }
    }

    function listarPorOrdemDeCompra($ordemCompraId) {
        $listaItemOrdemDeCompra = $this->itemOrdemDeComoraDao->listarPorOrdemDeCompraDao($ordemCompraId);
        $this->setDadosListaItem($listaItemOrdemDeCompra);
        return $listaItemOrdemDeCompra;
    }

    function setDadosListaItem($listaItemOrdemDeCompra) {
        foreach ($listaItemOrdemDeCompra as $itemOrdemDeComora) {
            $this->setItemOrdemDeComora($itemOrdemDeComora);
            $this->setDadosItem();
        }
    }

    function setDadosItem() {
        $this->setInfoItem();
    }

    private function setInfoItem() {
        $tipoPedido = ManterItemPedido::getTipoPedidoPorId($this->itemOrdemDeComora->getPedidoId());
        $adapter = new AdapterItem($tipoPedido);
        $this->itemOrdemDeComora->setItem($adapter->bucarPorId($this->itemOrdemDeComora->getItemId()));
    }

    function getItemOrdemDeComora() {
        return $this->itemOrdemDeComora;
    }

    function setItemOrdemDeComora($itemOrdemDeComora) {
        $this->itemOrdemDeComora = $itemOrdemDeComora;
    }

    function setAtributos($atributos) {
        $this->itemOrdemDeComora->setOrdemCompraId($atributos->ordemCompraId);
        $this->itemOrdemDeComora->setProcessoCompraId($atributos->processoCompraId);
        $this->itemOrdemDeComora->setFornecedorId($atributos->fornecedorId);

        $this->itemOrdemDeComora->setLoteId($atributos->loteId);
        $this->itemOrdemDeComora->setPedidoId($atributos->pedidoId);
        $this->itemOrdemDeComora->setItemId($atributos->itemId);
        $this->itemOrdemDeComora->setQuantidade($atributos->quantidade);
        $this->itemOrdemDeComora->setValorUnitario($atributos->valorUnitario);
        $this->itemOrdemDeComora->setValorTotal($atributos->valorTotal);
    }

    public function __destruct() {
        unset($this->itemOrdemDeComora, $this->itemOrdemDeComoraDao);
    }

}
