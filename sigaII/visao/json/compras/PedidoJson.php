<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PedidoJson
 *
 * @author alex.bertolla
 */

namespace visao\json\compras;

use visao\json\RetornoJson,
    modelo\compras\Pedido,
    visao\json\compras\ItemPedidoJson,
    visao\json\FuncionarioJson,
    visao\json\LotacaoJson,
    visao\json\cadastros\GrupoJson,
    visao\json\PAJson,
    visao\json\cadastros\NaturezaDespesaJson,
    visao\json\compras\SituacaoPedidoJson,
    ArrayObject;

class PedidoJson extends RetornoJson {

    function retornoJson($pedido) {
        if ($pedido instanceof Pedido) {
            $solicitante = new FuncionarioJson();
            $lotacao = new LotacaoJson();
            $grupo = new GrupoJson();
            $itemPedidoJson = new ItemPedidoJson();
            $pa = new PAJson();
            $naturezaDespesa = new NaturezaDespesaJson();
            $situacaoPedido = new SituacaoPedidoJson();
            return
                    array(
                        "id" => $pedido->getId(),
                        "numero" => $pedido->getNumero(),
                        "matriculaSolicitante" => $pedido->getMatriculaSolicitante(),
                        "solicitante" => $solicitante->retornoJson($pedido->getSolicitante()),
                        "paId" => $pedido->getPaId(),
                        "pa" => $pa->retornoJson($pedido->getPa()),
                        "lotacaoId" => $pedido->getLotacaoId(),
                        "lotacao" => $lotacao->retornoJson($pedido->getLotacao()),
                        "justificativa" => $pedido->getJustificativa(),
                        "grupoId" => $pedido->getGrupoId(),
                        "grupo" => $grupo->retornoJson($pedido->getGrupo()),
                        "naturezaDespesa" => $naturezaDespesa->retornoJson($pedido->getNaturezaDespesa()),
                        "naturezaDespesaId" => $pedido->getNaturezaDespesaId(),
                        "bloqueado"=>$pedido->getBloqueado(),
                        "dataCriacao"=>$pedido->getDataCriacao(),
                        "dataEnvio"=>$pedido->getDataEnvio(),
                        "ano" => $pedido->getAno(),
                        'tipo' => $pedido->getTipo(),
                        "situacaoId"=>$pedido->getSituacaoId(),
                        "situacao"=>$situacaoPedido->retornoJson($pedido->getSituacao()),
                        "listaItemPedido" => $itemPedidoJson->retornoListaJson($pedido->getListaItemPedido())
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaPedido) {
        if ($listaPedido instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaPedido as $pedido) {
                $novoArray->append($this->retornoJson($pedido));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
