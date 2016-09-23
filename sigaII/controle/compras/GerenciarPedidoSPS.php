<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use modelo\compras\PedidoSPS,
    dao\compras\PedidoSPSDao,
    controle\compras\ManterPedido,
    controle\email\EmailPedido;

/**
 * Description of GerenciarPedidoSPS
 *
 * @author alex.bertolla
 */
class GerenciarPedidoSPS {

    private $pedidoSPS;
    private $pedidoSPSDao;
    private $manterPedido;

    public function __construct() {
        $this->pedidoSPS = new PedidoSPS();
        $this->pedidoSPSDao = new PedidoSPSDao();
        $this->manterPedido = new ManterPedido();
    }

    function receber() {
        $this->pedidoSPSDao->receberPedidoDao($this->pedidoSPS->getId(), $this->pedidoSPS->getMatriculaResponsavel());
        $this->emailPedidoRecebido();
    }

    private function emailPedidoRecebido() {
        $email = new EmailPedido();
        $email->emailPedidoRecebidoPeloSPS($this->getPedidoSPS()->getPedido());
        unset($email);
    }

    function getPedidoSPS() {
        return $this->pedidoSPS;
    }

    function setPedidoSPS($pedidoSPS) {
        $this->pedidoSPS = $pedidoSPS;
    }

    function setPedido($pedido) {
        $this->pedidoSPS->setPedido($pedido);
    }

    public function __destruct() {
        unset($this->manterPedido, $this->pedidoSPS, $this->pedidoSPSDaos);
    }

}
