<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\compras;

use visao\json\RetornoJson,
    modelo\compras\AtividadeOCS,
    ArrayObject;

/**
 * Description of AtividadeOCSJson
 *
 * @author alex.bertolla
 */
class AtividadeOCSJson extends RetornoJson {

    function retornoJson($atividadeOCS) {
        if ($atividadeOCS instanceof AtividadeOCS) {
            return array(
                "id" => $atividadeOCS->getId(),
                "atividade" => $atividadeOCS->getAtividade(),
                "data" => $atividadeOCS->getData(),
                "ordemCompraId" => $atividadeOCS->getOrdemCompraId()
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaAtividadeOCS) {
        if ($listaAtividadeOCS instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaAtividadeOCS as $atividadeOCS) {
                $novoArray->append($this->retornoJson($atividadeOCS));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
