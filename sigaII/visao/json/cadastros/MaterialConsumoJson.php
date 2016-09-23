<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MaterialPermanenteJson
 *
 * @author alex.bertolla
 */

namespace visao\json\cadastros;

use modelo\cadastros\MaterialConsumo,
    visao\json\RetornoJson,
    visao\json\cadastros\GrupoJson,
    visao\json\cadastros\AlmoxarifadoVirtualJson,
    visao\json\cadastros\OrgaoControladorJson,
    visao\json\cadastros\ApresentacaoComercialJson,
    visao\json\cadastros\CentroDeCustoJson,
    visao\json\cadastros\ItemControladoJson,
    ArrayObject;

class MaterialConsumoJson extends RetornoJson {

    function retornoJson($materialConsumo) {
        if ($materialConsumo instanceof MaterialConsumo) {
            $grupoJson = new GrupoJson();
            $avJson = new AlmoxarifadoVirtualJson();
            $ocJson = new OrgaoControladorJson();
            $acJson = new ApresentacaoComercialJson();
            $ccJson = new CentroDeCustoJson();
            $icJson = new ItemControladoJson();
            return array(
                "id" => $materialConsumo->getId(),
                "codigo" => $materialConsumo->getCodigo(),
                "nome" => $materialConsumo->getNome(),
                "descricao" => $materialConsumo->getDescricao(),
                "situacao" => $materialConsumo->getSituacao(),
                "dataCadastro" => $materialConsumo->getDataCadastro(),
                "dataAlteracao" => $materialConsumo->getDataAtualizacao(),
                "sustentavel" => $materialConsumo->getSustentavel(),
                "grupoId" => $materialConsumo->getGrupoId(),
                "grupo" => $grupoJson->retornoJson($materialConsumo->getGrupo()),
                "almoxarifadoVirtualId" => $materialConsumo->getAlmoxarifadoVirtualId(),
                "almoxarifadoVirtual" => $avJson->retornoJson($materialConsumo->getAlmoxarifadoVirtual()),
                "marca" => $materialConsumo->getMarca(),
                "modelo" => $materialConsumo->getModelo(),
                "partNumber" => $materialConsumo->getPartNumber(),
                "controlado" => $materialConsumo->getControlado(),
                "estoqueMaximo" => $materialConsumo->getEstoqueMaximo(),
                "estoqueMinimo" => $materialConsumo->getEstoqueMinimo(),
                "estoqueAtual" => $materialConsumo->getEstoqueAtual(),
                "codigoSinap" => $materialConsumo->getCodigoSinap(),
                "orgaoControladorId" => $materialConsumo->getOrgaoControladorId(),
                "orgaoControlador" => $ocJson->retornoJson($materialConsumo->getOrgaoControlador()),
                "itemControladoId" => $materialConsumo->getItemControladoId(),
                "itemControlado" => $icJson->retornoJson($materialConsumo->getItemControlado()),
                "apresentacaoComercialId" => $materialConsumo->getApresentacaoComercialId(),
                "apresentacaoComercial" => $acJson->retornoJson($materialConsumo->getApresentacaoComercial()),
                "centroDeCusto" => $ccJson->retornoListaJson($materialConsumo->getCentroDeCusto()),
                "naturezaDespesaId"=>$materialConsumo->getNaturezaDespesaId()
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaMaterialConsumo) {
        if ($listaMaterialConsumo instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaMaterialConsumo as $materialConsumo) {
                $novoArray->append($this->retornoJson($materialConsumo));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
