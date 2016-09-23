<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use modelo\compras\SituacaoPedido,
    dao\compras\SituacaoPedidoDao;

/**
 * Description of ManterSituacaoPedido
 *
 * @author alex.bertolla
 */
class ManterSituacaoPedido {

    private $situacaoPedido;
    private $situacaoPedidoDao;

    public function __construct() {
        $this->situacaoPedido = new SituacaoPedido();
        $this->situacaoPedidoDao = new SituacaoPedidoDao();
    }

    function alterar() {
        $this->formToBd();
        return $this->situacaoPedidoDao->alterarDao($this->situacaoPedido->getId(), $this->situacaoPedido->getMensagem(), $this->situacaoPedido->getEnviaEmail());
    }

    function listar() {
        $listaSituacaoPedido = $this->situacaoPedidoDao->listar();
        $this->listaBdToForm($listaSituacaoPedido);
        return $listaSituacaoPedido;
    }

    function buscarPorId($id) {
        $this->setSituacaoPedido($this->situacaoPedidoDao->buscarPorId($id));
        $this->bdToForm();
        return $this->getSituacaoPedido();
    }

    function buscarPorCodigo($codigo) {
        $this->setSituacaoPedido($this->situacaoPedidoDao->buscarPorCodigo($codigo));
        $this->bdToForm();
        return $this->getSituacaoPedido();
    }

    function getSituacaoPedido() {
        return $this->situacaoPedido;
    }

    function setSituacaoPedido($situacaoPedido) {
        $this->situacaoPedido = $situacaoPedido;
    }

    function listaBdToForm($listaSituacaoPedido) {
        foreach ($listaSituacaoPedido as $situacaoPedido) {
            $this->setSituacaoPedido($situacaoPedido);
            $this->bdToForm();
        }
    }

    function bdToForm() {
        $this->stripSlashes();
        $this->encode();
    }

    function formToBd() {
        $this->decode();
        $this->addSlashes();
        
    }

    private function decode() {
        $this->situacaoPedido->setSituacao(utf8_decode($this->situacaoPedido->getSituacao()));
        $this->situacaoPedido->setMensagem(utf8_decode($this->situacaoPedido->getMensagem()));
    }

    private function encode() {
        $this->situacaoPedido->setSituacao(utf8_encode($this->situacaoPedido->getSituacao()));
        $this->situacaoPedido->setMensagem(utf8_encode($this->situacaoPedido->getMensagem()));
    }

    private function addSlashes() {
        $this->situacaoPedido->setSituacao(addslashes($this->situacaoPedido->getSituacao()));
        $this->situacaoPedido->setMensagem(addslashes($this->situacaoPedido->getMensagem()));
    }

    private function stripSlashes() {
        $this->situacaoPedido->setSituacao(stripcslashes($this->situacaoPedido->getSituacao()));
        $this->situacaoPedido->setMensagem(stripslashes($this->situacaoPedido->getMensagem()));
    }

    function setAtributos($atributos) {
        $this->situacaoPedido->setId($atributos->id);
        $this->situacaoPedido->setCodigo($atributos->codigo);
        $this->situacaoPedido->setSituacao($atributos->situacao);
        $this->situacaoPedido->setMensagem($atributos->mensagem);
        $this->situacaoPedido->setEnviaEmail(($atributos->enviaEmail) ? 1 : 0);
    }

    public function __destruct() {
        unset($this->situacaoPedido, $this->situacaoPedidoDao);
    }

}
