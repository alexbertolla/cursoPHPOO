<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\compras;

use modelo\compras\PedidoSPS,
    visao\json\compras\PedidoJson,
    visao\json\FuncionarioJson,
    visao\json\RetornoJson,
    ArrayObject;

/**
 * Description of PedidoSPSJson
 *
 * @author alex.bertolla
 */
class PedidoSPSJson extends RetornoJson {

    function retornoJson($pedidoSPS) {
        if ($pedidoSPS instanceof PedidoSPS) {
            $pedidoJson = new PedidoJson();
            $responsavel = new FuncionarioJson();
            return array(
                "id" => $pedidoSPS->getId(),
                "pedido" => $pedidoJson->retornoJson($pedidoSPS->getPedido()),
                "recebido" => $pedidoSPS->getRecebido(),
                "dataRecebido" => $pedidoSPS->getDataRecebido(),
                "matriculaResponsavel" => $pedidoSPS->getMatriculaResponsavel(),
                "responsavel" => $responsavel->retornoJson($pedidoSPS->getResponsavel())
            );
        }
    }

    function retornoListaJson($listaPedidoSPS) {
        if ($listaPedidoSPS instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaPedidoSPS as $pedidoSPS) {
                $novoArray->append($this->retornoJson($pedidoSPS));
            }
            return $novoArray->getArrayCopy();
        }
    }

}
