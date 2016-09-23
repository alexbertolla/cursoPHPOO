<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\compras;

use visao\json\RetornoJson,
    modelo\compras\ItemPedido,
    ArrayObject,
    modelo\cadastros\MaterialConsumo,
    modelo\cadastros\MaterialPermanente,
    modelo\cadastros\Servico,
    modelo\cadastros\Obra,
    visao\json\cadastros\MaterialConsumoJson,
    visao\json\cadastros\MaterialPermanenteJson,
    visao\json\cadastros\ServicoJson,
    visao\json\cadastros\ObraJson,
    visao\json\compras\SituacaoItemPedidoJson;

/**
 * Description of ItemPedidoJson
 *
 * @author alex.bertolla
 */
class ItemPedidoJson extends RetornoJson {

    private function setInstancia($item) {
        if ($item instanceof MaterialConsumo) {
            return new MaterialConsumoJson();
        } elseif ($item instanceof MaterialPermanente) {
            return new MaterialPermanenteJson();
        } elseif ($item instanceof Servico) {
            return new ServicoJson();
        } elseif ($item instanceof Obra) {
            return new ObraJson();
        } else {
            return NULL;
        }
    }

    function retornoJson($itemPedido) {
        $itemJson = $this->setInstancia($itemPedido->getItem());
        $situacaoJson = new SituacaoItemPedidoJson();
        if ($itemPedido instanceof ItemPedido) {
            return
                    array(
                        "pedidoId" => $itemPedido->getPedidoId(),
                        "itemId" => $itemPedido->getItemId(),
                        "item" => ($itemJson) ? $itemJson->retornoJson($itemPedido->getItem()) : NULL,
                        "quantidade" => $itemPedido->getQuantidade(),
                        "situacaoId" => $itemPedido->getSituacaoId(),
                        "situacao" => $situacaoJson->retornoJson($itemPedido->getSituacao())
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaItens) {
        if ($listaItens instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaItens as $itemPedido) {
                $novoArray->append($this->retornoJson($itemPedido));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
