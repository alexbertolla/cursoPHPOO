<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\almoxarifado;

use visao\json\RetornoJson,
    modelo\almoxarifado\ItemEstoque,
    visao\json\cadastros\MaterialConsumoJson,
    ArrayObject;
        
/**
 * Description of ItemEstoqueJson
 *
 * @author egidio.ramalho
 */

class ItemEstoqueJson extends RetornoJson{
    
    function retornoJson($itemEstoque) {
        if ($itemEstoque instanceof ItemEstoque) {
            $itemJson = new MaterialConsumoJson();
            return array(
                "id" => $itemEstoque->getId(),
                "itemId" => $itemEstoque->getItemId(),
                "quantidade" => $itemEstoque->getQuantidade(),
                "precoMedio" => $itemEstoque->getPrecoMedio(),
                "diferencaContabil" => $itemEstoque->getDiferencaContabil(),
                "estoqueMaximo" => $itemEstoque->getEstoqueMaximo(),
                "estoqueMinimo" => $itemEstoque->getEstoqueMinimo(),
                "estoqueAtual" => $itemEstoque->getEstoqueAtual(),
                "dataValidade" => $itemEstoque->getDataValidade(),
                "fornecedorId" => $itemEstoque->getFornecedorId(),
                "fornecedor" => $itemEstoque->getFornecedor(),
                "quantidadeReservada" => $itemEstoque->getQuantidadeReservada(),
                "item" => $itemJson->retornoJson($itemEstoque->getItem())
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
