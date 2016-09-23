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

use modelo\cadastros\CentroDeCusto,
    visao\json\RetornoJson,
    ArrayObject;

class CentroDeCustoJson extends RetornoJson {

    function retornoJson($centroDeCusto) {
        return ($centroDeCusto instanceof CentroDeCusto) ?
                array(
            "id" => $centroDeCusto->getId(),
            "codigo" => $centroDeCusto->getCodigo(),
            "nome" => $centroDeCusto->getNome(),
            "situacao" => $centroDeCusto->getSituacao()) :
                NULL;
    }

    function retornoListaJson($listaCentroDeCusto) {
        if ($listaCentroDeCusto instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaCentroDeCusto as $centroDeCusto) {
                $novoArray->append($this->retornoJson($centroDeCusto));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
