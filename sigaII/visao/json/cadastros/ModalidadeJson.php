<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\cadastros;

use modelo\cadastros\Modalidade,
    visao\json\RetornoJson,
    ArrayObject;

/**
 * Description of ModalidadeJson
 *
 * @author alex.bertolla
 */
class ModalidadeJson extends RetornoJson {

    function retornoJson($modalidade) {
        return ($modalidade instanceof Modalidade) ?
                array(
            "id" => $modalidade->getId(),
            "nome" => $modalidade->getNome(),
                ) :
                NULL;
    }

    function retornoListaJson($listaModalidade) {
        if ($listaModalidade instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaModalidade as $modalidade) {
                $novoArray->append($this->retornoJson($modalidade));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
