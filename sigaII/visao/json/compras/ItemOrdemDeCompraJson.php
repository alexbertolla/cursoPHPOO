<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\compras;

use visao\json\RetornoJson,
    modelo\compras\ItemOrdemDeCompra,
    visao\json\compras\LoteProcessoCompraJson,
    visao\json\cadastros\ItemJson,
    ArrayObject;

/**
 * Description of ItemOrdemDeCompraJson
 *
 * @author alex.bertolla
 */
class ItemOrdemDeCompraJson extends RetornoJson {

    function retornoJson($itemOrdemDeCompra) {
        if ($itemOrdemDeCompra instanceof ItemOrdemDeCompra) {
            $loteJson = new LoteProcessoCompraJson();
            $itemJson = new ItemJson();
            return array(
                "ordemCompraId" => $itemOrdemDeCompra->getOrdemCompraId(),
                "processoCompraId" => $itemOrdemDeCompra->getProcessoCompraId(),
                "fornecedorId" => $itemOrdemDeCompra->getFornecedorId(),
                "loteId" => $itemOrdemDeCompra->getLoteId(),
                "pedidoId" => $itemOrdemDeCompra->getPedidoId(),
                "itemId" => $itemOrdemDeCompra->getItemId(),
                "quantidade" => $itemOrdemDeCompra->getQuantidade(),
                "valorUnitario" => $itemOrdemDeCompra->getValorUnitario(),
                "valorTotal" => $itemOrdemDeCompra->getValorTotal(),
                "lote" => $loteJson->retornoJson($itemOrdemDeCompra->getLote()),
                "item"=>$itemJson->retornoItemJson($itemOrdemDeCompra->getItem())
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaItemOrdemDeCompra) {
        if ($listaItemOrdemDeCompra instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaItemOrdemDeCompra as $itemOrdemDeCompra) {
                $novoArray->append($this->retornoJson($itemOrdemDeCompra));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
