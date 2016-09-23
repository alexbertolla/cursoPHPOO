<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\almoxarifado;

use visao\json\RetornoJson,
    visao\json\almoxarifado\ItemEntradaJson,
    visao\json\compras\OrdemDeCompraJson,
    visao\json\almoxarifado\NotaFiscalJson,
    visao\json\cadastros\FornecedorJson,
    visao\json\cadastros\AlmoxarifadoVirtualJson,
    visao\json\compras\ProcessoCompraJson,
    modelo\almoxarifado\EntradaMaterial,
    ArrayObject;

/**
 * Description of EntradaMaterialJson
 *
 * @author alex.bertolla
 */
class EntradaMaterialJson extends RetornoJson {

    function retornoJson($entradaMaterial) {
        if ($entradaMaterial instanceof EntradaMaterial) {
            $notaFiscalJson = new NotaFiscalJson();
            $almoxarifadoJson = new AlmoxarifadoVirtualJson();
            $ordemDeCompraJson = new OrdemDeCompraJson();
            $fornecedorJson = new FornecedorJson($entradaMaterial->getTipoFornecedor());
            $processoCompraJson = new ProcessoCompraJson();
            $itemEntradaJson = new ItemEntradaJson();
            return array(
                "id" => $entradaMaterial->getId(),
                "numero" => $entradaMaterial->getNumero(),
                "data" => $entradaMaterial->getData(),
                "valor" => $entradaMaterial->getValor(),
                "notaFiscal" => $notaFiscalJson->retornoJson($entradaMaterial->getNotaFiscal()),
                "almoxarifadoVirtualId" => $entradaMaterial->getAlmoxarifadoVirtualId(),
                "almoxarifadoVirtual" => $almoxarifadoJson->retornoJson($entradaMaterial->getAlmoxarifadoVirtual()),
                "ordemDeCompraId" => $entradaMaterial->getOrdemDeCompraId(),
                "ordemDeCompra" => $ordemDeCompraJson->retornoJson($entradaMaterial->getOrdemDeCompra()),
                "tipoFornecedor" => $entradaMaterial->getTipoFornecedor(),
                "fornecedorId" => $entradaMaterial->getFornecedorId(),
                "fornecedor" => $fornecedorJson->retornoJson($entradaMaterial->getFornecedor()),
                "processoCompraId" => $entradaMaterial->getProcessoCompraId(),
                "processoCompra" => $processoCompraJson->retornoJson($entradaMaterial->getProcessoCompra()),
                "listaItemEntrada" => $itemEntradaJson->retornoListaJson($entradaMaterial->getListaItemEntrada())
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaEntradaMaterial) {
        if ($listaEntradaMaterial instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaEntradaMaterial as $entradaMaterial) {
                $novoArray->append($this->retornoJson($entradaMaterial));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
