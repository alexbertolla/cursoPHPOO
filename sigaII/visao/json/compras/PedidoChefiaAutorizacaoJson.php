<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\compras;

use modelo\compras\PedidoChefiaAutorizacao,
    visao\json\compras\PedidoJson,
    visao\json\FuncionarioJson,
    visao\json\RetornoJson,
    ArrayObject;

/**
 * Description of PedidoChefiaAutorizacao
 *
 * @author alex.bertolla
 */
class PedidoChefiaAutorizacaoJson extends RetornoJson {

    function retornoJson($pedidoAutorizacao) {
        if ($pedidoAutorizacao instanceof PedidoChefiaAutorizacao) {
            $pedidoJson = new PedidoJson();
            $responsavel = new FuncionarioJson();
            return array(
                "id" => $pedidoAutorizacao->getId(),
                "recebido" => $pedidoAutorizacao->getRecebido(),
                "autorizado" => $pedidoAutorizacao->getAutorizado(),
                "justificativa" => $pedidoAutorizacao->getJustificativa(),
                "matriculaResponsavel" => $pedidoAutorizacao->getMatriculaResponsavel(),
                "pedido" => $pedidoJson->retornoJson($pedidoAutorizacao->getPedido()),
                "responsavel" => $responsavel->retornoJson($pedidoAutorizacao->getResponsavel())
            );
        }
    }

    function retornoListaJson($listaPedidoAutorizacao) {
        if ($listaPedidoAutorizacao instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaPedidoAutorizacao as $pedidoAutorizacao) {
                $novoArray->append($this->retornoJson($pedidoAutorizacao));
            }
            return $novoArray->getArrayCopy();
        }
    }

}
