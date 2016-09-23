<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\compras;

use visao\json\RetornoJson,
    modelo\compras\SituacaoOCS;

/**
 * Description of SituacaoOCSJson
 *
 * @author alex.bertolla
 */
class SituacaoOCSJson extends RetornoJson {

    function retornoJson($situacaoOCS) {
        if ($situacaoOCS instanceof SituacaoOCS) {
            return array(
                "id" => $situacaoOCS->getId(),
                "codigo" => $situacaoOCS->getCodigo(),
                "situacao" => $situacaoOCS->getSituacao()
            );
        } else {
            return NULL;
        }
    }

}
