<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras\impressao;

use modelo\compras\impressao\MapaComparativoPreco,
    dao\compras\impressao\DocumentosProcessoDeCompraDao,
    controle\compras\ManterProcessoCompra,
    controle\compras\ManterItemProposta,
    controle\AdapterFornecedor,
    controle\compras\ManterPedido,
    controle\cadastros\ManterNaturezaDespesa,
    controle\cadastros\ManterGrupo,
    sof\PA,
    ArrayObject;

/**
 * Description of GerarMapa
 *
 * @author alex.bertolla
 */
class GerarDocumentosProcessoCompra {

    private $mapaComparativo;
    private $documentosProcessoCompraDao;

    public function __construct() {
        $this->mapaComparativo = new MapaComparativoPreco();
        $this->documentosProcessoCompraDao = new DocumentosProcessoDeCompraDao();
    }

    function buscarProcessoCompra($processoCompraId) {
        $manterProcessoCompra = new ManterProcessoCompra();
        $processoCompra = $manterProcessoCompra->buscarConsolidadoPorId($processoCompraId);
        $manterProcessoCompra->setDadosProcesso();
        return $processoCompra;
    }

    function listarItensPropostasProProcessoCompra($processoCompraId, $itemId) {
        $manterItemProposta = new ManterItemProposta();
        $listaItemProposta = $manterItemProposta->listarPorProcessoCompra($processoCompraId, $itemId);
        $manterItemProposta->setDetalhesListaItemProposta($listaItemProposta);
        return $listaItemProposta;
    }

    function buscarFornecedorPorItemProposta($forecedorId, $tipoFornecedor) {
        $adapterFornecedor = new AdapterFornecedor($tipoFornecedor);
        return $adapterFornecedor->buscarPorId($forecedorId);
    }

    function listarFornecedoresVencedores($processoCompraId) {
        $listaItemProposta = $this->documentosProcessoCompraDao->listarAgrupadosPorFornecedoresVencedoresDao($processoCompraId);
        $manterItemProposta = new ManterItemProposta();
        $manterItemProposta->setDetalhesListaItemProposta($listaItemProposta);
        $listaFornecedores = new ArrayObject();
        foreach ($listaItemProposta as $itemProposta) {
            $listaFornecedores->append($itemProposta->getFornecedor());
        }

        return $listaFornecedores;
    }

    function listarItemVencedorPorFornecedor($processoCompraId, $fornecedorId) {
        $listaItemProposta = $this->documentosProcessoCompraDao->listarItemVencedorPorFornecedorDao($processoCompraId, $fornecedorId);
        $manterItemProposta = new ManterItemProposta();
//        $listaItemProposta = $manterItemProposta->listarItemVencedorPorFornecedor($processoCompraId, $fornecedorId);
        $manterItemProposta->setDetalhesListaItemProposta($listaItemProposta);
        return $listaItemProposta;
    }

    function listarAgrupadoPorPA($processoCompraId) {
        $listaItemProposta = $this->documentosProcessoCompraDao->listarGastosAgrupadoPorPADao($processoCompraId);
        return $listaItemProposta;
    }

    function buscarPAPorPedido($pedidoId) {
        $manterPedido = new ManterPedido();
        $pedido = $manterPedido->buscarPorId($pedidoId);
        $paId = $pedido->getPaId();
        $PA = new PA();
        return $PA->buscarPaPorId($paId);
    }

    function listarAgrupadoPorNaturezaDespesa($processoCompraId) {
        $listaItemProposta = $this->documentosProcessoCompraDao->listarGastosAgrupadoPorNaturezaDespesaDao($processoCompraId);
        return $listaItemProposta;
    }

    function buscarNaturezaDespesa($id) {
        $manterND = new ManterNaturezaDespesa();
        return $manterND->buscarPorId($id);
    }

    function buscarGrupo($id) {
        $manterGrupo = new ManterGrupo();
        return $manterGrupo->buscarPorId($id);
    }

    function listarAgrupadoPorGrupo($processoCompraId) {
        $listaItemProposta = $this->documentosProcessoCompraDao->listarGastosAgrupadoPorGrupoDao($processoCompraId);
        return $listaItemProposta;
    }

    function listarPAPreEmpenho($processoCompraId) {
        $listaItemProcesso = $this->documentosProcessoCompraDao->listarItemPreEmpenhoDao($processoCompraId);
        $listaPa = new ArrayObject();
        foreach ($listaItemProcesso as $itemProcesso) {
            $listaPa->append($this->buscarPAPorPedido($itemProcesso->getPedidoId()));
        }
        return $listaPa;
    }

    function getMapaComparativo() {
        return $this->mapaComparativo;
    }

}
