<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\compras;

use visao\json\RetornoJson,
    modelo\compras\SituacaoItemPedido;

/**
 * Description of SituacaoItemPedidoJson
 *
 * @author alex.bertolla
 */
class SituacaoItemPedidoJson extends RetornoJson {

    function retornoJson($situacaoItemPedido) {
        if ($situacaoItemPedido instanceof SituacaoItemPedido) {
            return array(
                "id" => $situacaoItemPedido->getId(),
                "codigo" => $situacaoItemPedido->getCodigo(),
                "situacao" => $situacaoItemPedido->getSituacao(),
                "mensagem" => $situacaoItemPedido->getMensagem(),
                "enviaEmail" => $situacaoItemPedido->getEnviaEmail()
            );
        } else {
            return NULL;
        }
    }

}
