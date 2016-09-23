<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\compras;

use modelo\compras\LoteProcessoCompra,
    visao\json\compras\ItemProcessoCompraJson,
    visao\json\RetornoJson,
    ArrayObject;

/**
 * Description of LoteProcessoCompraJson
 *
 * @author alex.bertolla
 */
class LoteProcessoCompraJson extends RetornoJson {

    function retornoJson($loteProcessoCompra) {
        if ($loteProcessoCompra instanceof LoteProcessoCompra) {
            $itemJS = new ItemProcessoCompraJson();
            return array(
                "id" => $loteProcessoCompra->getId(),
                "numero" => $loteProcessoCompra->getNumero(),
                "processoCompraId" => $loteProcessoCompra->getProcessoCompraId(),
                "modalidadeId" => $loteProcessoCompra->getModalidadeId(),
                "listaItemProcessoCompra" => $itemJS->retornoListaJson($loteProcessoCompra->getListaItemProcessoCompra())
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaLoteProcessoCompra) {
        if ($listaLoteProcessoCompra instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaLoteProcessoCompra as $loteProcessoCompra) {
                $novoArray->append($this->retornoJson($loteProcessoCompra));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
