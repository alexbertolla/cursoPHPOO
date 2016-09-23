<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\compras;

use visao\json\RetornoJson,
    modelo\compras\Proposta,
    visao\json\compras\ProcessoCompraJson,
    modelo\cadastros\FornecedorPessoaFisica,
    modelo\cadastros\FornecedorPessoaJuridica,
    visao\json\cadastros\FornecedorPJJson,
    visao\json\cadastros\FornecedorPFJson,
    visao\json\compras\ItemPropostaJson,
    ArrayObject;

/**
 * Description of PropostaJson
 *
 * @author alex.bertolla
 */
class PropostaJson extends RetornoJson {

    function retornoJson($proposta) {
        if ($proposta instanceof Proposta) {
            $propostaCompra = new ProcessoCompraJson();
            $fornecedor = ($proposta->getFornecedor() instanceof FornecedorPessoaJuridica) ? new FornecedorPJJson() : new FornecedorPFJson();
            $itemProposta = new ItemPropostaJson();
            return array(
                "id" => $proposta->getId(),
                "numero"=>$proposta->getNumero(),
                "fornecedorId" => $proposta->getFornecedorId(),
                "tipoFornecedor"=>$proposta->getTipoFornecedor(),
                "fornecedor" => $fornecedor->retornoJson($proposta->getFornecedor()),
                "processoCompraId" => $proposta->getProcessoCompraId(),
                "processoCompra" => $propostaCompra->retornoJson($proposta->getProcessoCompra()),
                "data" => $proposta->getData(),
                "valor" => $proposta->getValor(),
//                "listaLoteProposta" => $itemProposta->retornoListaJson($proposta->getLitaItemProposta()),
                "listaItemProposta" => $itemProposta->retornoListaJson($proposta->getListaItemProposta())
            );
        }
    }

    function retornoListaJson($listaProposta) {
        if ($listaProposta instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaProposta as $proposta) {
                $novoArray->append($this->retornoJson($proposta));
            }
            return $novoArray->getArrayCopy();
        } else {
            return FALSE;
        }
    }

}
