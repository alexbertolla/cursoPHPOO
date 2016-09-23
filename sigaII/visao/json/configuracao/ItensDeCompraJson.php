<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ItensDeCompraJson
 *
 * @author alex.bertolla
 */

namespace visao\json\configuracao;

use configuracao\ItensDeCompra,
    visao\json\RetornoJson,
    visao\json\cadastros\NaturezaDespesaJson,
    ArrayObject;

class ItensDeCompraJson extends RetornoJson {

    function retornoJson($itensDeCompra) {
        $ndJson = new NaturezaDespesaJson();
        return ($itensDeCompra instanceof ItensDeCompra) ?
                array(
            "id" => $itensDeCompra->getId(),
            "nome" => $itensDeCompra->getNome(),
            "nomeApresentacao" => $itensDeCompra->getNomeApresentacao(),
            "descricao" => $itensDeCompra->getDescricao(),
            "arquivo" => $itensDeCompra->getArquivo(),
            "naturezaDespesaId" => $itensDeCompra->getNaturezaDespesaId(),
            "naturezaDespesa" => $ndJson->retornoJson($itensDeCompra->getNaturezaDespesa())
                ) :
                NULL;
    }

    function retornoListaJson($listaItensDeCompra) {
        if ($listaItensDeCompra instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaItensDeCompra as $itensDeCompra) {
                $novoArray->append($this->retornoJson($itensDeCompra));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
