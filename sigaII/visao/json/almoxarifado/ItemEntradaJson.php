<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\almoxarifado;

use visao\json\RetornoJson,
    modelo\almoxarifado\ItemEntrada,
    visao\json\cadastros\MaterialConsumoJson,
    ArrayObject;

/**
 * Description of ItemEntradaJson
 *
 * @author alex.bertolla
 */
class ItemEntradaJson extends RetornoJson {

    function retornoJson($itemEntrada) {
        if ($itemEntrada instanceof ItemEntrada) {
            $itemJson = new MaterialConsumoJson();
            return array(
                "entradaId" => $itemEntrada->getEntradaId(),
                "fornecedorId" => $itemEntrada->getFornecedorId(),
                "itemId" => $itemEntrada->getItemId(),
                "grupoId" => $itemEntrada->getGrupoId(),
                "quantidade" => $itemEntrada->getQuantidade(),
                "valorUnitario" => $itemEntrada->getValorUnitario(),
                "valorTotal" => $itemEntrada->getValorTotal(),
                "item" => $itemJson->retornoJson($itemEntrada->getItem())
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaItemEntrada) {
        if ($listaItemEntrada instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaItemEntrada as $itemEntrada) {
                $novoArray->append($this->retornoJson($itemEntrada));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
