<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\compras;

use visao\json\RetornoJson,
    modelo\compras\SituacaoProcessoDeCompra;

/**
 * Description of SituacaoProcessoCompraJson
 *
 * @author alex.bertolla
 */
class SituacaoProcessoCompraJson extends RetornoJson {

    function retornoJson($situacaoProcessoCompra) {
        if ($situacaoProcessoCompra instanceof SituacaoProcessoDeCompra) {
            return array(
                "id" => $situacaoProcessoCompra->getId(),
                "codigo" => $situacaoProcessoCompra->getCodigo(),
                "situacao" => $situacaoProcessoCompra->getSituacao()
            );
        } else {
            return NULL;
        }
    }

}
