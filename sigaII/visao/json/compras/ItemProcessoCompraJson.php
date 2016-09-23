<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\compras;

use visao\json\RetornoJson,
    ArrayObject,
    modelo\compras\ItemProcessoCompra,
//    visao\json\compras\ItemPedidoJson,
    visao\json\cadastros\GrupoJson,
    modelo\cadastros\MaterialConsumo,
    modelo\cadastros\MaterialPermanente,
    modelo\cadastros\Servico,
    modelo\cadastros\Obra,
    visao\json\cadastros\MaterialConsumoJson,
    visao\json\cadastros\MaterialPermanenteJson,
    visao\json\cadastros\ServicoJson,
    visao\json\cadastros\ObraJson,
    visao\json\cadastros\NaturezaDespesaJson;

/**
 * Description of ItemProcessoCompraJson
 *
 * @author alex.bertolla
 */
class ItemProcessoCompraJson extends RetornoJson {

    private function setInstancia($item) {
        if ($item instanceof MaterialConsumo) {
            return new MaterialConsumoJson();
        } elseif ($item instanceof MaterialPermanente) {
            return new MaterialPermanenteJson();
        } elseif ($item instanceof Servico) {
            return new ServicoJson();
        } else {
            return new ObraJson();
        }
    }

    function retornoJson($itemProcessoCompra) {
        if ($itemProcessoCompra instanceof ItemProcessoCompra) {
            $itemJson = $this->setInstancia($itemProcessoCompra->getItem());
            $grupoJson = new GrupoJson();
            $naturezaDespesaJson = new NaturezaDespesaJson();
            return array(
                "loteId" => $itemProcessoCompra->getLoteId(),
                "processoCompraId" => $itemProcessoCompra->getProcessoCompraId(),
                "pedidoId" => $itemProcessoCompra->getPedidoId(),
                "itemId" => $itemProcessoCompra->getItemId(),
                "item" => $itemJson->retornoJson($itemProcessoCompra->getItem()),
                "quantidade" => $itemProcessoCompra->getQuantidade(),
                "valorUnitario" => $itemProcessoCompra->getValorUnitario(),
                "valorTotal" => $itemProcessoCompra->getValorTotal(),
                "fornecedorId" => $itemProcessoCompra->getFornecedorId()
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaItemProcessoCompra) {
        if ($listaItemProcessoCompra instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaItemProcessoCompra as $itemProcessoCompra) {
                $novoArray->append($this->retornoJson($itemProcessoCompra));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
