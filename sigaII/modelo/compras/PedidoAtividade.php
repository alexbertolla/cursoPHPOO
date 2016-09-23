<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\compras;

use sgp\Funcionario;

/**
 * Description of PedidoAtividade
 *
 * @author alex.bertolla
 */
class PedidoAtividade {

    private $id;
    private $data;
    private $hora;
    private $responsavel;
    private $pedidoId;
    private $atividade;
    private $resposavelClass;

    public function __construct() {
        $this->resposavelClass = new Funcionario();
    }

    function addSlaches() {
        $this->atividade = addslashes($this->atividade);
    }

    function stripSlaches() {
        $this->atividade = stripslashes($this->atividade);
    }

    function getId() {
        return $this->id;
    }

    function getData() {
        return $this->data;
    }

    function getHora() {
        return $this->hora;
    }

    function getResponsavel() {
        return $this->responsavel;
    }

    function getPedidoId() {
        return $this->pedidoId;
    }

    function getAtividade() {
        return $this->atividade;
    }

    function getResposavelClass() {
        return $this->resposavelClass;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setHora($hora) {
        $this->hora = $hora;
    }

    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    function setPedidoId($pedidoId) {
        $this->pedidoId = $pedidoId;
    }

    function setAtividade($atividade) {
        $this->atividade = $atividade;
    }

    function setResposavelClass($resposavelClass) {
        $this->resposavelClass = $resposavelClass;
    }

    public function __destruct() {
        unset($this->resposavelClass);
    }

}
