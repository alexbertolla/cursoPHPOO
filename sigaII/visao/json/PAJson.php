<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json;

use visao\json\RetornoJson,
    sof\PA,
    ArrayObject;

/**
 * Description of PAJson
 *
 * @author alex.bertolla
 */
class PAJson extends RetornoJson {

    function retornoJson($pa) {
        return ($pa instanceof PA) ?
                array(
            "id" => $pa->getId(),
            "codigo" => $pa->getCodigo(),
            "titulo" => $pa->getTitulo(),
            "responsavel" => $pa->getResponsavel(),
            "saldoCusteio" => $pa->getSaldoCusteio(),
            "saldoInvestimento" => $pa->getSaldoInvestimento()
                ) :
                NULL;
    }

    function retornoListaJson($listaPA) {
        if ($listaPA instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaPA as $pa) {
                $novoArray->append($this->retornoJson($pa));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
