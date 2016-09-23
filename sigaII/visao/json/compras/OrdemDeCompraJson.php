<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\compras;

use modelo\compras\OrdemDeCompra,
    visao\json\RetornoJson,
    visao\json\cadastros\FornecedorJson,
    visao\json\cadastros\DadosBancarioJson,
    visao\json\compras\ItemOrdemDeCompraJson,
    visao\json\compras\ItemProcessoCompraJson,
    visao\json\compras\EmpenhoJson,
    visao\json\compras\SituacaoOCSJson,
    ArrayObject;

/**
 * Description of OrdemDeCompraJson
 *
 * @author alex.bertolla
 */
class OrdemDeCompraJson extends RetornoJson {

    function retornoJson($ordemDeCompra) {
        if ($ordemDeCompra instanceof OrdemDeCompra) {
            $fornecedorJson = new FornecedorJson($ordemDeCompra->getTipoFornecedor());
            $dadosBancarioJson = new DadosBancarioJson();
            $itemOrdemDeCompraJson = new ItemOrdemDeCompraJson();
            $itemProcessoCompraJson = new ItemProcessoCompraJson();
            $empenhoJson = new EmpenhoJson();
            $situacao = new SituacaoOCSJson();
            return array(
                "id" => $ordemDeCompra->getId(),
                "numero" => $ordemDeCompra->getNumero(),
                "sequencia" => $ordemDeCompra->getSequencia(),
                "valor" => $ordemDeCompra->getValor(),
                "prazo" => $ordemDeCompra->getPrazo(),
                "dataEmissao" => $ordemDeCompra->getDataEmissao(),
                "dataAssinatura" => $ordemDeCompra->getDataAssinatura(),
                "dataPrazoEntrega" => $ordemDeCompra->getDataPrazoEntrega(),
                "tipoFornecedor" => $ordemDeCompra->getTipoFornecedor(),
                "fornecedorId" => $ordemDeCompra->getFornecedorId(),
                "processoCompraId" => $ordemDeCompra->getProcessoCompraId(),
                "dadosBancarioId" => $ordemDeCompra->getDadosBancarioId(),
                "bancoId" => $ordemDeCompra->getBancoId(),
                "fornecedor" => $fornecedorJson->retornoJson($ordemDeCompra->getFornecedor()),
                "dadosBancario" => $dadosBancarioJson->retornoJson($ordemDeCompra->getDadosBancario()),
                "situacaoId" => $ordemDeCompra->getSituacaoId(),
                "situacao" => $situacao->retornoJson($ordemDeCompra->getSituacao()),
                "listaItemOrdemDeCompra" => $itemOrdemDeCompraJson->retornoListaJson($ordemDeCompra->getListaItemOrdemDeCompra()),
                "listaItemProcessoCompra" => $itemProcessoCompraJson->retornoListaJson($ordemDeCompra->getListaItemProcessoCompra()),
                "listaEmpenho" => $empenhoJson->retornoListaJson($ordemDeCompra->getListaEmpenho())
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaOrdemDeCompra) {
        if ($listaOrdemDeCompra instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaOrdemDeCompra as $ordemDeCompra) {
                $novoArray->append($this->retornoJson($ordemDeCompra));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
