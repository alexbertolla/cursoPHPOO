<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\email;

use controle\email\EnviarEmail,
    modelo\compras\Pedido,
    modelo\compras\ItemPedido;

/**
 * Description of EmailPedido
 *
 * @author alex.bertolla
 */
class EmailPedido extends EnviarEmail {

    function __construct() {
        parent::__construct();
    }

    function emailPedidoEnviado(Pedido $pedido) {
        $destinatario = $pedido->getSolicitante()->getEmail();
        $situacao = $pedido->getSituacao();
        $this->setDestinatario($destinatario);
        $this->setAssunto($situacao->getSituacao());

        $mensagem = $situacao->getMensagem();
        $mensagem.= $this->montaDetalhesPedido($pedido);
        $this->setMensagem($mensagem);
        return $this->envairEmail();
    }

    private function montaDetalhesPedido(Pedido $pedido) {
        $detalhesPedido = "<pre>"
                . "Detalhes do pedido \n"
                . "Número: " . $pedido->getNumero() . " \n"
                . "Solicitante: " . $pedido->getSolicitante()->getNome() . " \n"
                . "Lotação (pedido): " . $pedido->getLotacao()->getNome() . " \n"
                . "Plano de Ação: " . $pedido->getPa()->getTitulo() . " \n"
                . "Justificativa: " . $pedido->getJustificativa() . " \n"
                . "</pre>";
        $detalhesPedido.= $this->montaListaItensPedido($pedido->getListaItemPedido());
        return $detalhesPedido;
    }

    private function montaListaItensPedido($listaItemPedido) {
        $listaItens = "<pre>";
        foreach ($listaItemPedido as $itensPedidos) {
            $itensPedidos instanceof ItemPedido;
            $listaItens .= "<p>Código Item: " . $itensPedidos->getItem()->getCodigo() . "\n";
            $listaItens .= "Nome Item: " . $itensPedidos->getItem()->getNome() . "\n";
            $listaItens .= "Quantidade Item: " . $itensPedidos->getQuantidade() . "\n </p>";
        }
        $listaItens .="</pre>";
        return $listaItens;
    }

    function __destruct() {
        parent::__destruct();
    }

}
