<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\compras;

use modelo\compras\Pedido,
    configuracao\Usuario;

/**
 * Description of PedidoChefiaAutorizacao
 *
 * @author alex.bertolla
 */
class PedidoChefiaAutorizacao {

    private $id;
    private $recebido;
    private $autorizado;
    private $justificativa;
    private $matriculaResponsavel;
    private $responsavel;
    private $pedido;

    public function __construct() {
        $this->pedido = new Pedido();
        $this->responsavel = new Usuario();
    }

    function getId() {
        return $this->id;
    }

    function getRecebido() {
        return $this->recebido;
    }

    function getAutorizado() {
        return $this->autorizado;
    }

    function getJustificativa() {
        return $this->justificativa;
    }

    function getMatriculaResponsavel() {
        return $this->matriculaResponsavel;
    }

    function getResponsavel() {
        return $this->responsavel;
    }

    function getPedido() {
        return $this->pedido;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setRecebido($recebido) {
        $this->recebido = $recebido;
    }

    function setAutorizado($autorizado) {
        $this->autorizado = $autorizado;
    }

    function setJustificativa($justificativa) {
        $this->justificativa = $justificativa;
    }

    function setMatriculaResponsavel($matriculaResponsavel) {
        $this->matriculaResponsavel = $matriculaResponsavel;
    }

    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    function setPedido($pedido) {
        $this->pedido = $pedido;
    }

    public function __destruct() {
        unset($this->pedido, $this->responsavel);
    }

}
