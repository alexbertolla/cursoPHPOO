<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\compras;

use visao\json\RetornoJson,
    modelo\compras\SituacaoPedido,
    ArrayObject;

/**
 * Description of SituacaoPedidoJson
 *
 * @author alex.bertolla
 */
class SituacaoPedidoJson extends RetornoJson {

    function retornoJson($situacaoPedido) {
        if ($situacaoPedido instanceof SituacaoPedido) {
            return array(
                "id" => $situacaoPedido->getId(),
                "codigo" => $situacaoPedido->getCodigo(),
                "situacao" => $situacaoPedido->getSituacao(),
                "mensagem" => $situacaoPedido->getMensagem(),
                "enviaEmail" => $situacaoPedido->getEnviaEmail()
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaSituacaoPedido) {
        if ($listaSituacaoPedido instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaSituacaoPedido as $situacaoPedido) {
                $novoArray->append($this->retornoJson($situacaoPedido));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
