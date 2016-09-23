<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\configuracao;

use configuracao\Sistema,
    visao\json\RetornoJson;

/**
 * Description of SistemaJson
 *
 * @author alex.bertolla
 */
class SistemaJson extends RetornoJson {

    function retornoJson($sistema) {
        return ($sistema instanceof Sistema) ?
                array(
            "id" => $sistema->getId(),
            "anoSistema" => $sistema->getAnoSistema(),
            "liberado" => $sistema->getLiberado()
                ) : NULL;
    }

}
