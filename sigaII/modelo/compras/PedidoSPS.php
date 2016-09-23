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
 * Description of PedidoSPS
 *
 * @author alex.bertolla
 */
class PedidoSPS {

    private $id;
    private $pedido;
    private $recebido;
    private $dataRecebido;
    private $matriculaResponsavel;
    private $responsavel;

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

    function getDataRecebido() {
        return $this->dataRecebido;
    }

    function getMatriculaResponsavel() {
        return $this->matriculaResponsavel;
    }

    function getPedido() {
        return $this->pedido;
    }

    function getResponsavel() {
        return $this->responsavel;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setRecebido($recebido) {
        $this->recebido = $recebido;
    }

    function setDataRecebido($dataRecebido) {
        $this->dataRecebido = $dataRecebido;
    }

    function setMatriculaResponsavel($matriculaResponsavel) {
        $this->matriculaResponsavel = $matriculaResponsavel;
    }

    function setPedido($pedido) {
        $this->pedido = $pedido;
    }

    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    
    public function __destruct() {
        unset($this->responsavel, $this->pedido);
    }

}
