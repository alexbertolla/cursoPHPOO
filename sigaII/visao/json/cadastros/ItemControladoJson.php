<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ItemControladoJson
 *
 * @author alex.bertolla
 */

namespace visao\json\cadastros;

use modelo\cadastros\ItemControlado,
    visao\json\cadastros\OrgaoControladorJson,
    visao\json\cadastros\GrupoJson,
    visao\json\RetornoJson,
    ArrayObject;

class ItemControladoJson extends RetornoJson {

    function retornoJson($itemControlado) {
        if ($itemControlado instanceof ItemControlado) {
            $ocJson = new OrgaoControladorJson();

            $grupoJson = new GrupoJson();
            return array(
                "id" => $itemControlado->getId(),
                "nome" => $itemControlado->getNome(),
                "quantidade" => $itemControlado->getQuantidade(),
                "apresentacaoComercial" => $itemControlado->getApresentacaoComercial(),
                "fonte" => $itemControlado->getFonte(),
                "situacao" => $itemControlado->getSituacao(),
                "orgaoControladorId" => $itemControlado->getOrgaoControladorId(),
                "grupoId" => $itemControlado->getGrupoId(),
                "orgaoControlador" => $ocJson->retornoJson($itemControlado->getOrgaoControlador()),
                "grupo" => $grupoJson->retornoJson($itemControlado->getGrupo())
            );
        } else {
            NULL;
        }
    }

    function retornoListaJson($listaItemControlado) {
        if ($listaItemControlado instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaItemControlado as $itemControlado) {
                $novoArray->append($this->retornoJson($itemControlado));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
