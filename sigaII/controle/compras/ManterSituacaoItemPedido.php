<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use modelo\compras\SituacaoItemPedido,
    dao\compras\SituacaoItemPedidoDao;

/**
 * Description of ManterSituacaoItemPedido
 *
 * @author alex.bertolla
 */
class ManterSituacaoItemPedido {

    private $situacaoItemPedido;
    private $situacaoItemPedidoDao;

    public function __construct() {
        $this->situacaoItemPedido = new SituacaoItemPedido();
        $this->situacaoItemPedidoDao = new SituacaoItemPedidoDao();
    }

    function listar() {
        $listaSituacaoItemPedido = $this->situacaoItemPedidoDao->listarDao();
        $this->listaBdToForm($listaSituacaoItemPedido);
        return $listaSituacaoItemPedido;
    }

    function buscarPorId($id) {
        $this->setSituacaoItemPedido($this->situacaoItemPedidoDao->buscarPorIdDao($id));
        $this->bdToForm();
        return $this->getSituacaoItemPedido();
    }

    function buscarPorCodigo($codigo) {
        $this->setSituacaoItemPedido($this->situacaoItemPedidoDao->buscarPorCodigoDao($codigo));
        $this->bdToForm();
        return $this->getSituacaoItemPedido();
    }

    function listaBdToForm($listaSituacaoItemPedido) {
        foreach ($listaSituacaoItemPedido as $situacaoItemPedido) {
            $this->setSituacaoItemPedido($situacaoItemPedido);
            $this->bdToForm();
        }
        return $listaSituacaoItemPedido;
    }

    function bdToForm() {
        $this->situacaoItemPedido->setSituacao(utf8_encode($this->situacaoItemPedido->getSituacao()));
        $this->situacaoItemPedido->setMensagem(utf8_encode($this->situacaoItemPedido->getMensagem()));
    }

    function getSituacaoItemPedido() {
        return $this->situacaoItemPedido;
    }

    function setSituacaoItemPedido($situacaoItemPedido) {
        $this->situacaoItemPedido = $situacaoItemPedido;
    }

    public function __destruct() {
        unset($this->situacaoItemPedido, $this->situacaoItemPedidoDao);
    }

}
