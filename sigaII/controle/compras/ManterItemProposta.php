<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use modelo\compras\ItemProposta,
    dao\compras\ItemPropostaDao,
    controle\AdapterFornecedor,
    controle\AdapterItem,
    controle\cadastros\ManterNaturezaDespesa;

/**
 * Description of ManterItemProposta
 *
 * @author alex.bertolla
 */
class ManterItemProposta {

    private $itemProposta;
    private $itemPropostaDao;

    public function __construct() {
        $this->itemProposta = new ItemProposta();
        $this->itemPropostaDao = new ItemPropostaDao();
    }

    function listarPorProcessoCompra($processoCompraId, $itemId) {
        $listaItemProposta = $this->itemPropostaDao->listarPorProcessoCompraDao($processoCompraId, $itemId);
        return $listaItemProposta;
    }

    function listarItemVencedorPorFornecedor($processoCompraId, $fornecedorId) {
        $listaItemProposta = $this->itemPropostaDao->listarItemVencedorPorFornecedorDao($processoCompraId, $fornecedorId);
        return $listaItemProposta;
    }

    function listarFornecedoresVencedores($processoCompraId) {
        $listaItemProposta = $this->itemPropostaDao->listarFornecedoresVencedoresDao($processoCompraId);
        return $listaItemProposta;
    }

    function setDetalhesListaItemProposta($listaItemProposta) {
        foreach ($listaItemProposta as $itemProposta) {
            $this->setItemProposta($itemProposta);
            $this->setDetalheItemProposta();
        }
        return $listaItemProposta;
    }

    function setDetalheItemProposta() {
        $this->setFornecedor();
        $this->setItem();
    }

    function setFornecedor() {
        $adapterFornecedor = new AdapterFornecedor($this->itemProposta->getTipoFornecedor());
        $this->itemProposta->setFornecedor($adapterFornecedor->buscarPorId($this->itemProposta->getFornecedorId()));
        unset($adapterFornecedor);
    }

    function setItem() {
        $manterND = new ManterNaturezaDespesa();
        $nd = $manterND->buscarPorId($this->itemProposta->getNaturezaDespesaId());
        $adapterItem = new AdapterItem($nd->getTipo());
        $this->itemProposta->setItem($adapterItem->bucarPorId($this->itemProposta->getItemId()));
        unset($manterND, $nd, $adapterItem);
    }

    public function __destruct() {
        unset($this->itemProposta, $this->itemPropostaDao);
    }

    function getItemProposta() {
        return $this->itemProposta;
    }

    function setItemProposta($itemProposta) {
        $this->itemProposta = $itemProposta;
    }

}
