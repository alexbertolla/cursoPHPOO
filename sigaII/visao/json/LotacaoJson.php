<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LotacaoJson
 *
 * @author alex.bertolla
 */

namespace visao\json;

use sgp\Lotacao,
    ArrayObject;

class LotacaoJson extends RetornoJson {

    function retornoJson($lotacao) {
        return ($lotacao instanceof Lotacao) ?
                array(
            "id" => $lotacao->getId(),
            "nome" => $lotacao->getNome(),
            "sigla" => $lotacao->getSigla()
                ) :
                NULL;
    }

    function retornoListaJson($listaLotacao) {
        if ($listaLotacao instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaLotacao as $lotacao) {
                $novoArray->append($this->retornoJson($lotacao));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
