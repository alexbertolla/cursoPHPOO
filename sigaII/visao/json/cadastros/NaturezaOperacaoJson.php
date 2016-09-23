<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\cadastros;

use visao\json\RetornoJson,
    modelo\cadastros\NaturezaOperacao,
    ArrayObject;

/**
 * Description of NaturezaOperacaoJson
 *
 * @author alex.bertolla
 */
class NaturezaOperacaoJson extends RetornoJson {

    function retornoJson($naturezaOperacao) {
        if ($naturezaOperacao instanceof NaturezaOperacao) {
            return array(
                "id" => $naturezaOperacao->getId(),
                "numero" => $naturezaOperacao->getNumero(),
                "nome" => $naturezaOperacao->getNome()
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaNaturezaOperacao) {
        if ($listaNaturezaOperacao instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaNaturezaOperacao as $naturezaOperacao) {
                $novoArray->append($this->retornoJson($naturezaOperacao));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
