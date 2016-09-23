<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\almoxarifado;

use visao\json\RetornoJson,
    modelo\almoxarifado\ItemRequisicao,
    visao\json\almoxarifado\ItemEstoqueJson,
    ArrayObject;

/**
 * Description of ItemRequisicaoJson
 *
 * @author egidio.ramalho
 */
class ItemRequisicaoJson extends RetornoJson {

    function retornoJson($itemRequisicao) {
        if ($itemRequisicao instanceof ItemRequisicao) {
            $itemJson = new ItemEstoqueJson();
            return array(
                'requisicaoId' => $itemRequisicao->getRequisicaoId(),
                'itemEstoqueId' => $itemRequisicao->getItemEstoqueId(),
                'itemId' => $itemRequisicao->getItemId(),
                'quantidade' => $itemRequisicao->getQuantidade(),
                'valorUnitario' => $itemRequisicao->getValorUnitario(),
                'valorTotal' => $itemRequisicao->getValorTotal(),
                'itemEstoque' => $itemJson->retornoJson($itemRequisicao->getItemEstoque())
            );
        } else {
            return NULL;
        }
    }

    //put your code here
    function retornoListaJson($listaItemEstoque) {
        if ($listaItemEstoque instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaItemEstoque as $itemEntrada) {
                $novoArray->append($this->retornoJson($itemEntrada));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
