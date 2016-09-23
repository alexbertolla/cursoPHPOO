<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\compras;

use modelo\compras\PedidoAtividade,
    visao\json\FuncionarioJson,
    ArrayObject,
    visao\json\RetornoJson;

/**
 * Description of PedidoAtividadeJson
 *
 * @author alex.bertolla
 */
class PedidoAtividadeJson extends RetornoJson {

    function retornoJson($pedidoAtividade) {
        $funcionarioJson = new FuncionarioJson();
        if ($pedidoAtividade instanceof PedidoAtividade) {
            return array(
                "id" => $pedidoAtividade->getId(),
                "data" => $pedidoAtividade->getData(),
                "hora" => $pedidoAtividade->getHora(),
                "responsavel" => $pedidoAtividade->getResponsavel(),
                "pedidoId" => $pedidoAtividade->getPedidoId(),
                "atividade" => $pedidoAtividade->getAtividade(),
                "responsavelClass" => $funcionarioJson->retornoJson($pedidoAtividade->getResposavelClass())
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaPedidoAtividade) {
        if ($listaPedidoAtividade instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaPedidoAtividade as $pedidoAtividade) {
                $novoArray->append($this->retornoJson($pedidoAtividade));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
