<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use modelo\compras\PedidoAtividade,
    dao\compras\PedidoAtividadeDao,
    configuracao\DataSistema,
    sgp\Funcionario;

/**
 * Description of GerarPedidoAtividade
 *
 * @author alex.bertolla
 */
class GerarPedidoAtividade {

    private $pedidoAtividade;
    private $pedidoAtividadeDao;
    private $dataSistema;

    public function __construct() {
        $this->pedidoAtividade = new PedidoAtividade();
        $this->pedidoAtividadeDao = new PedidoAtividadeDao();
        $this->dataSistema = new DataSistema();
    }

    function listarAtividadePorPedido($pedidoId) {
        $listaPedidoAtividade = $this->pedidoAtividadeDao->listarAtividadePorPedidoDao($pedidoId);
        $this->listaBdToForm($listaPedidoAtividade);
        return $listaPedidoAtividade;
    }

    function registarAtividade($pedidoId, $atividade, $responsavel) {
        $this->pedidoAtividade->setPedidoId($pedidoId);
        $this->pedidoAtividade->setAtividade($atividade);
        $this->pedidoAtividade->setResponsavel($responsavel);
        $this->pedidoAtividade->addSlaches();
        return $this->inserir();
    }

    function salvar() {
        return $this->inserir();
    }

    private function inserir() {
        $id = $this->pedidoAtividadeDao->inserirDao($this->pedidoAtividade->getResponsavel(), $this->pedidoAtividade->getPedidoId(), $this->pedidoAtividade->getAtividade());
        $this->pedidoAtividade->setId($id);
        return(($id) ? TRUE : FALSE);
    }

    function listaBdToForm($listaPedidoAtividade) {
        foreach ($listaPedidoAtividade as $pedidoAtividade) {
            $this->setPedidoAtividade($pedidoAtividade);
            $this->bdToForm();
            $this->setResponsavel();
        }
        return $listaPedidoAtividade;
    }

    function setResponsavel() {
        $funcionario = new Funcionario();
        $this->pedidoAtividade->setResposavelClass($funcionario->buscarPorMatricula($this->pedidoAtividade->getResponsavel()));
        unset($funcionario);
    }

    function bdToForm() {
        $this->decode();
    }

    function decode() {
        $this->pedidoAtividade->setAtividade($this->utf8Decode($this->pedidoAtividade->getAtividade()));
    }

    function encode() {
        $this->pedidoAtividade->setAtividade($this->utf8Encode($this->pedidoAtividade->getAtividade()));
    }

    function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    function setAtributos($atributos) {
        $this->pedidoAtividade->setId($atributos->id);
        $this->pedidoAtividade->setResponsavel($atributos->responsavel);
        $this->pedidoAtividade->setPedidoId($atributos->pedidoId);
        $this->pedidoAtividade->setAtividade($atributos->atividade);
    }

    function getPedidoAtividade() {
        return $this->pedidoAtividade;
    }

    function setPedidoAtividade($pedidoAtividade) {
        $this->pedidoAtividade = $pedidoAtividade;
    }

    public function __destruct() {
        unset($this->dataSistema, $this->pedidoAtividade, $this->pedidoAtividadeDao);
    }

}
