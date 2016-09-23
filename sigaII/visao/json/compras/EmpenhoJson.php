<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\compras;

use visao\json\RetornoJson,
    modelo\compras\Empenho,
    visao\json\PAJson,
    visao\json\cadastros\NaturezaDespesaJson,
    visao\json\compras\PedidoJson,
    ArrayObject;

/**
 * Description of EmpenhoJson
 *
 * @author alex.bertolla
 */
class EmpenhoJson extends RetornoJson {

    function retornoJson($empenho) {
        if ($empenho instanceof Empenho) {
            $naturezaDespesaJson = new NaturezaDespesaJson();
            $paJson = new PAJson();
            $pedidoJson = new PedidoJson();
            return array(
                "id" => $empenho->getId(),
                "unidadeOrcamentaria" => $empenho->getUnidadeOrcamentaria(),
                "valor" => $empenho->getValor(),
                "paId" => $empenho->getPaId(),
                "ordemCompraId" => $empenho->getOrdemCompraId(),
                "naturezaDespesaId" => $empenho->getNaturezaDespesaId(),
                "pa" => $paJson->retornoJson($empenho->getPa()),
                "naturezaDespesa" => $naturezaDespesaJson->retornoJson($empenho->getNaturezaDespesa()),
                'pedidoId' => $empenho->getPedidoId(),
                'pedido' => $pedidoJson->retornoJson($empenho->getPedido())
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaEmpenho) {
        if ($listaEmpenho instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaEmpenho as $empenho) {
                $novoArray->append($this->retornoJson($empenho));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
