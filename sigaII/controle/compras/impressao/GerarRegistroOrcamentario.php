<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras\impressao;

use controle\compras\ManterItemProposta,
    controle\cadastros\ManterNaturezaDespesa,
    controle\compras\ManterProcessoCompra,
    controle\compras\ManterPedido,
    sof\PA,
    ArrayObject;

/**
 * Description of GerarRegistroOrcamentario
 *
 * @author alex.bertolla
 */
class GerarRegistroOrcamentario {

    public function __construct() {
//        header('Content-Type: application/json');
//        include_once '../../../autoload.php';
    }

    function buscarNaturezaDespesa($naturezaDespesaId) {
        $manterND = new ManterNaturezaDespesa();
        return $manterND->buscarPorId($naturezaDespesaId);
    }

    function buscarProcessoCompra($processoCompraId) {
        $manterProcessoCompra = new ManterProcessoCompra();
        $processoCompra = $manterProcessoCompra->buscarConsolidadoPorId($processoCompraId);
        $manterProcessoCompra->setDadosProcesso();
        return $processoCompra;
    }

    function listarFornecedoresVencedores($processoCompraId) {
        $manterItemProposta = new ManterItemProposta();
        $listaItemProposta = $manterItemProposta->listarFornecedoresVencedores($processoCompraId);
        $manterItemProposta->setDetalhesListaItemProposta($listaItemProposta);
        $listaFornecedores = new ArrayObject();
        foreach ($listaItemProposta as $itemProposta) {
            $listaFornecedores->append($itemProposta->getFornecedor());
        }

        return $listaFornecedores;
    }

    function listarItemVencedorPorFornecedor($processoCompraId, $fornecedorId) {
        $manterItemProposta = new ManterItemProposta();
        $listaItemProposta = $manterItemProposta->listarItemVencedorPorFornecedor($processoCompraId, $fornecedorId);
        $manterItemProposta->setDetalhesListaItemProposta($listaItemProposta);
        return $listaItemProposta;
    }

    function listarPAPorPedido($pedidoId) {
        $manterPedido = new ManterPedido();
        $pedido = $manterPedido->buscarPorId($pedidoId);
        $paId = $pedido->getPaId();
        $PA = new PA();
        return $PA->buscarPaPorId($paId);
    }

    function gerarPerEmpenho($processoCompraId) {
        
    }

}
