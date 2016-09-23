<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NaturezaDespesaJson
 *
 * @author alex.bertolla
 */

namespace visao\json\cadastros;

use modelo\cadastros\NaturezaDespesa,
    visao\json\RetornoJson,
    ArrayObject;

class NaturezaDespesaJson extends RetornoJson {

    function retornoJson($naturezaDespesa) {
        return ($naturezaDespesa instanceof NaturezaDespesa) ?
                array(
            "id" => $naturezaDespesa->getId(),
            "codigo" => $naturezaDespesa->getCodigo(),
            "nome" => $naturezaDespesa->getNome(),
            "situacao" => $naturezaDespesa->getSituacao(),
            "tipo" => $naturezaDespesa->getTipo()) :
                NULL;
    }

    function retornoListaJson($listaNaturezaDespesa) {
        if ($listaNaturezaDespesa instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaNaturezaDespesa as $naturezaDespesa) {
                $novoArray->append($this->retornoJson($naturezaDespesa));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
