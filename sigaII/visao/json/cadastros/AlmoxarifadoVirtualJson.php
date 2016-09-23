<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AlmoxarifadoVirtualJson
 *
 * @author alex.bertolla
 */

namespace visao\json\cadastros;

use modelo\cadastros\AlmoxarifadoVirtual,
    visao\json\RetornoJson,
    ArrayObject;

class AlmoxarifadoVirtualJson extends RetornoJson {

    function retornoJson($almoxarifadoVirtual) {
        return ($almoxarifadoVirtual instanceof AlmoxarifadoVirtual) ?
                array(
            "id" => $almoxarifadoVirtual->getId(),
            "nome" => $almoxarifadoVirtual->getNome(),
            "situacao" => $almoxarifadoVirtual->getSituacao()
                ) :
                NULL;
    }

    function retornoListaJson($listaAlmoxarifadoVirtual) {
        if ($listaAlmoxarifadoVirtual instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaAlmoxarifadoVirtual as $almoxarifadoVirtual) {
                $novoArray->append($this->retornoJson($almoxarifadoVirtual));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
