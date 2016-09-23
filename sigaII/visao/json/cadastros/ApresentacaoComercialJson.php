<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ApresentacaoComercialJson
 *
 * @author alex.bertolla
 */

namespace visao\json\cadastros;

use modelo\cadastros\ApresentacaoComercial,
    visao\json\cadastros\GrupoJson,
    visao\json\RetornoJson,
    ArrayObject;

class ApresentacaoComercialJson extends RetornoJson {

    function retornoJson($apresentacaoComercial) {
        if ($apresentacaoComercial instanceof ApresentacaoComercial) {
            $grupoJson = new GrupoJson();
            return array(
                "id" => $apresentacaoComercial->getId(),
                "nome" => $apresentacaoComercial->getNome(),
                "apresentacaoComercial" => $apresentacaoComercial->getApresentacaoComercial(),
                "quantidade" => $apresentacaoComercial->getQuantidade(),
                "situacao" => $apresentacaoComercial->getSituacao(),
                "grupoId" => $apresentacaoComercial->getGrupoId(),
                "grupo" => $grupoJson->retornoJson($apresentacaoComercial->getGrupo())
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaApresentacaoComercial) {
        if ($listaApresentacaoComercial instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaApresentacaoComercial as $apresentacaoComercial) {
                $novoArray->append($this->retornoJson($apresentacaoComercial));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
