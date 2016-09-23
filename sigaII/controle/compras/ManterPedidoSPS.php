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
    configuracao\DataSistema,
    configuracao\Usuario,
    controle\email\EmailPedido,
    modelo\compras\EnumSituacaoPedido,
    controle\compras\GerarPedidoAtividade;

/**
 * Description of ManterPedidoSPS
 *
 * @author alex.bertolla
 */
class ManterPedidoSPS {

    private $pedidoSPS;
    private $pedidoSPSDao;
    private $dataSistema;
    private $manterPedido;

    public function __construct() {
        $this->pedidoSPS = new PedidoSPS();
        $this->pedidoSPSDao = new PedidoSPSDao();
        $this->dataSistema = new DataSistema();
        $this->manterPedido = new ManterPedido();
    }

    function encaminharParaSPS($id) {
        return $this->pedidoSPSDao->inserirDao($id);
    }

    function setInfoPedidoSPS() {
        if ($this->getPedidoSPS()) {
            $this->setResponsavel();
            $this->setPedido();
            $this->setListaItensPedido();
        }
    }

    private function setPedido() {
        $this->pedidoSPS->setPedido($this->manterPedido->buscarPorId($this->pedidoSPS->getId()));
        $this->manterPedido->setInfoPedido();
    }

    private function setListaItensPedido() {
        $this->manterPedido->setListaItemPedido();
    }

    private function setResponsavel() {
        $usuario = new Usuario();
        $this->pedidoSPS->setResponsavel($usuario->buscarPorMatricula($this->pedidoSPS->getMatriculaResponsavel()));
        unset($usuario);
    }

    function listarPedidoAReceber() {
        $lista = $this->pedidoSPSDao->listarPedidosAReceberDao();
        $this->listaBdToForm($lista);
        return $lista;
    }

    function listarPedidosRecebido() {
        $lista = $this->pedidoSPSDao->listarPedidosRecebidoDao();
        $this->listaBdToForm($lista);
        return $lista;
    }

    function buscarPorId($id) {
        $this->setPedidoSPS($this->pedidoSPSDao->buscarPorIdDao($id));
        $this->bdToForm();
        return $this->getPedidoSPS();
    }

    function buscarPedidoRecebidoPorNumeroAno($numero, $ano) {
        $this->setPedidoSPS($this->pedidoSPSDao->buscarPedidoRecebidoPorNumeroAnoDao($numero, $ano));
        $this->bdToForm();
        return $this->getPedidoSPS();
    }

    function receberPedido() {
        $recebido = $this->pedidoSPSDao->receberPedidoDao($this->pedidoSPS->getId(), $this->pedidoSPS->getMatriculaResponsavel());
        if ($recebido) {
            return $this->manterPedido->alterarSituacao(EnumSituacaoPedido::RecebidoSPS);
        } else {
            return FALSE;
        }
    }

    function enviarEmail() {
        $email = new EmailPedido();
        $email->emailPedidoEnviado($this->pedidoSPS->getPedido());
        unset($email);
    }

    function gerarAtividadePedido() {
        $gerarAtividade = new GerarPedidoAtividade();
        $situacao = $this->pedidoSPS->getPedido()->getSituacao();
        $gerarAtividade->registarAtividade($this->pedidoSPS->getId(), $situacao->getMensagem(), $this->pedidoSPS->getMatriculaResponsavel());
    }

    private function formToBd() {
        $manterPedido = new ManterPedido();
        $manterPedido->setPedido($this->pedidoSPS);
        $manterPedido->formToBd();
    }

    private function listaBdToForm($listaPedido) {
        if (count($listaPedido) > 0) {
            foreach ($listaPedido as $pedidoSPS) {
                $this->setPedidoSPS($pedidoSPS);
                $this->bdToForm();
            }
        }
        return $listaPedido;
    }

    private function bdToForm() {
        if ($this->pedidoSPS) {
            $this->pedidoSPS->setDataRecebido($this->dataSistema->ISOtoBR($this->pedidoSPS->getDataRecebido()));
            $this->setInfoPedidoSPS();
        }
    }

    function getPedidoSPS() {
        return $this->pedidoSPS;
    }

    function setPedidoSPS($pedidoSPS) {
        $this->pedidoSPS = $pedidoSPS;
    }

    function setAtributos($atributos) {
        $this->pedidoSPS->setId($atributos->id);
        $this->pedidoSPS->setMatriculaResponsavel($atributos->matriculaResponsavel);
        $this->pedidoSPS->setPedido($this->manterPedido->buscarPorId($atributos->id));
//        $this->pedidoSPS->setRecebido($atributos->recebido);
    }

    public function __destruct() {
        unset($this->pedidoSPS, $this->pedidoSPSDaos, $this->manterPedido);
    }

}
