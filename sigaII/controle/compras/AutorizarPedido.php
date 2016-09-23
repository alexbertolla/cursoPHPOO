<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use dao\compras\PedidoChefiaAutorizacaoDao,
    modelo\compras\PedidoChefiaAutorizacao,
    controle\compras\ManterPedido,
    configuracao\DataSistema,
    controle\compras\GerarPedidoAtividade,
    controle\compras\ManterPedidoSPS,
    controle\email\EmailPedido,
    modelo\compras\EnumSituacaoPedido;

/**
 * Description of AutorizarPedido
 *
 * @author alex.bertolla
 */
class AutorizarPedido {

    private $pedidoAutorizacao;
    private $pedidoAutorizacaoDao;
    private $dataSistema;
    private $manterPedido;
    private $gerarAtividade;

    public function __construct() {
        $this->pedidoAutorizacao = new PedidoChefiaAutorizacao();
        $this->pedidoAutorizacaoDao = new PedidoChefiaAutorizacaoDao();
        $this->dataSistema = new DataSistema();
        $this->manterPedido = new ManterPedido();
        $this->gerarAtividade = new GerarPedidoAtividade();
    }

    function listarPedidosAberto() {
        $lista = $this->pedidoAutorizacaoDao->listarPedidosAbertoDao();
        $this->listaBdToForm($lista);
        return $lista;
    }

    private function listaBdToForm($lista) {
        foreach ($lista as $pedidoAutorizacao) {
            $this->setPedidoAutorizacao($pedidoAutorizacao);
            $this->pedidoAutorizacao->setPedido($this->manterPedido->buscarPorId($pedidoAutorizacao->getId()));
            $this->manterPedido->setInfoPedido();
        }
        return $lista;
    }

    function encaminharPedidoParaChefia() {
        return $this->pedidoAutorizacaoDao->inserirDao($this->pedidoAutorizacao->getId());
    }

    function registrarAtividade() {
        $pedidoId = $this->pedidoAutorizacao->getId();
        $responsavel = $this->pedidoAutorizacao->getMatriculaResponsavel();
        $pedido = $this->pedidoAutorizacao->getPedido();
        $situacao = $pedido->getSituacao();
        return $this->gerarAtividade->registarAtividade($pedidoId, $situacao->getMensagem(), $responsavel);
    }

//    function alterarSituacaoPedido($codigoSituacao) {
//        $this->manterPedido->buscarPorId($this->pedidoAutorizacao->getId());
//        return $this->manterPedido->alterarSituacao($codigoSituacao);
//    }

    function receberPedido() {
        $recebido = $this->pedidoAutorizacaoDao->receberDao($this->pedidoAutorizacao->getId(), $this->pedidoAutorizacao->getMatriculaResponsavel());
        if ($recebido) {
            return $this->manterPedido->alterarSituacao(EnumSituacaoPedido::RecebidoChefia);
//            $this->enviarEmail();
//            return $this->registrarAtividade();
        } else {
            return FALSE;
        }
    }

    function autorizarPedido() {
        $autorizado = $this->pedidoAutorizacaoDao->autorizarDao($this->pedidoAutorizacao->getId(), $this->pedidoAutorizacao->getAutorizado(), $this->pedidoAutorizacao->getMatriculaResponsavel(), $this->pedidoAutorizacao->getJustificativa());
        if ($autorizado) {
            $codigoSituacao = ($this->pedidoAutorizacao->getAutorizado()) ? EnumSituacaoPedido::Autorizado : EnumSituacaoPedido::NaoAutorizado;
            $this->manterPedido->alterarSituacao($codigoSituacao);
            return ($this->pedidoAutorizacao->getAutorizado()) ? $this->encaminharAoSPS() : $this->encerrarPedido();
        }
        return FALSE;
    }

    function devolverPedido() {
        $remover = $this->pedidoAutorizacaoDao->excluirDao($this->pedidoAutorizacao->getId());
        if ($remover) {
//            $this->manterPedido->devolverPedido($this->pedidoAutorizacao->getId());
            $this->manterPedido->bloquearPedido(0);
            return $this->manterPedido->alterarSituacao(EnumSituacaoPedido::Devolvido);
//            $this->enviarEmail();
//            return $this->registrarAtividade();
        } else {
            return FALSE;
        }
    }

    private function encerrarPedido() {
        return $this->pedidoAutorizacaoDao->encerrarPedidoDao($this->pedidoAutorizacao->getId());
    }

    private function encaminharAoSPS() {
        $sps = new ManterPedidoSPS();
        $encaminhado = $sps->encaminharParaSPS($this->pedidoAutorizacao->getId());
        unset($sps);
        return $encaminhado;
    }

    function enviarEmail() {
        $email = new EmailPedido();
        $this->pedidoAutorizacao->setPedido($this->manterPedido->buscarPorId($this->pedidoAutorizacao->getId()));
        $this->manterPedido->setInfoPedido();
        $email->emailPedidoEnviado($this->getPedidoAutorizacao()->getPedido());
        unset($email);
    }

    private function enviarEmailPedidoAutorizacao($autorizado) {
        $email = new EmailPedido();
        $this->pedidoAutorizacao->setPedido($this->manterPedido->buscarPorId($this->pedidoAutorizacao->getId()));
        $this->manterPedido->setInfoPedido();
        $email->emailPedidoAutorizado($autorizado, $this->getPedidoAutorizacao()->getPedido());
        unset($email);
    }

    function getPedidoAutorizacao() {
        return $this->pedidoAutorizacao;
    }

    function setPedidoAutorizacao($pedidoAutorizacao) {
        $this->pedidoAutorizacao = $pedidoAutorizacao;
    }

    function setAtributos($atributos) {
        $this->pedidoAutorizacao->setId($atributos->id);
        $this->pedidoAutorizacao->setRecebido($atributos->recebido);
        $this->pedidoAutorizacao->setAutorizado($atributos->autorizado);
        $this->pedidoAutorizacao->setJustificativa($atributos->justificativa);
        $this->pedidoAutorizacao->setMatriculaResponsavel($atributos->matriculaResponsavel);
        $this->pedidoAutorizacao->setPedido($this->manterPedido->buscarPorId($atributos->id));
    }

    public function __destruct() {
        unset($this->dataSistema, $this->pedidoAutorizacao, $this->pedidoAutorizacaoDao);
    }

}
