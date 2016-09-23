<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrgaoControladorJson
 *
 * @author alex.bertolla
 */

namespace visao\json\cadastros;

use modelo\cadastros\OrgaoControlador,
    visao\json\RetornoJson,
    ArrayObject;

class OrgaoControladorJson extends RetornoJson {

    function retornoJson($orgaoControlador) {
        return ($orgaoControlador instanceof OrgaoControlador) ?
                array(
            "id" => $orgaoControlador->getId(),
            "nome" => $orgaoControlador->getNome(),
            "situacao" => $orgaoControlador->getSituacao()
                ) : NULL;
    }

    function retornoListaJson($listaOrgaoControlador) {
        if ($listaOrgaoControlador instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaOrgaoControlador as $orgaoControlador) {
                $novoArray->append($this->retornoJson($orgaoControlador));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
