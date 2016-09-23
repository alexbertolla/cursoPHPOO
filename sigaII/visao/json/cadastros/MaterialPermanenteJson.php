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

use modelo\cadastros\MaterialPermanente,
    visao\json\RetornoJson,
    visao\json\cadastros\GrupoJson,
    visao\json\cadastros\AlmoxarifadoVirtualJson,
    ArrayObject;

class MaterialPermanenteJson extends RetornoJson {

    function retornoJson($materialPermanente) {
        if ($materialPermanente instanceof MaterialPermanente) {
            $grupoJson = new GrupoJson();
            $avJson = new AlmoxarifadoVirtualJson();
            return array(
                "id" => $materialPermanente->getId(),
                "codigo" => $materialPermanente->getCodigo(),
                "nome" => $materialPermanente->getNome(),
                "descricao" => $materialPermanente->getDescricao(),
                "situacao" => $materialPermanente->getSituacao(),
                "dataCadastro" => $materialPermanente->getDataCadastro(),
                "dataAlteracao" => $materialPermanente->getDataAtualizacao(),
                "sustentavel" => $materialPermanente->getSustentavel(),
                "grupoId" => $materialPermanente->getGrupoId(),
                "grupo" => $grupoJson->retornoJson($materialPermanente->getGrupo()),
                "almoxarifadoVirtualId" => $materialPermanente->getAlmoxarifadoVirtualId(),
                "almoxarifadoVirtual" => $avJson->retornoJson($materialPermanente->getAlmoxarifadoVirtual()),
                "marca" => $materialPermanente->getMarca(),
                "modelo" => $materialPermanente->getModelo(),
                "partNumber" => $materialPermanente->getPartNumber(),
                "naturezaDespesaId"=>$materialPermanente->getNaturezaDespesaId()
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaMaterialPermanente) {
        if ($listaMaterialPermanente instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaMaterialPermanente as $materialPermanente) {
                $novoArray->append($this->retornoJson($materialPermanente));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
