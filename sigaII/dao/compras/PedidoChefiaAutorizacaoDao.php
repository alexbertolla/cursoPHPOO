<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace dao\compras;

use bibliotecas\persistencia\BD,
    ArrayObject;

/**
 * Description of PedidoAutorizacaoChefia
 *
 * @author alex.bertolla
 */
class PedidoChefiaAutorizacaoDao {

    private $sql;
    private $bd;
    private $resultado;

    public function __construct() {
        $this->bd = new BD();
    }

    public function __destruct() {
        unset($this->bd);
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\compras\PedidoChefiaAutorizacao");
    }

    private function fetchListObject() {
        $arrPedido = new ArrayObject();
        while ($pedido = $this->fetchObject()) {
            $arrPedido->append($pedido);
        }
        return $arrPedido;
    }

    function inserirDao($id) {
        $this->sql = "INSERT INTO bd_siga.pedidoAutorizacao (id, recebido, autorizado, encaminhado) VALUES ({$id},0,0,0);";
        return ($this->bd->query($this->sql) ? TRUE : FALSE);
    }

    function excluirDao($id) {
        $this->sql = "DELETE FROM bd_siga.pedidoAutorizacao WHERE id={$id};";
        return ($this->bd->query($this->sql) ? TRUE : FALSE);
    }

    function receberDao($id, $matriculaResponsavel) {
        $this->sql = "UPDATE bd_siga.pedidoAutorizacao SET recebido=true, matriculaResponsavel=\"{$matriculaResponsavel}\" WHERE id={$id}";
        return ($this->bd->query($this->sql) ? TRUE : FALSE);
    }

    function autorizarDao($id, $autorizado, $matriculaResponsavel, $justificativa) {
        $this->sql = "UPDATE bd_siga.pedidoAutorizacao SET autorizado={$autorizado}, matriculaResponsavel=\"{$matriculaResponsavel}\", justificativa=\"{$justificativa}\", encaminhado=1 WHERE id={$id}";
        return ($this->bd->query($this->sql) ? TRUE : FALSE);
    }

    function listarPedidosAbertoDao() {
        $this->sql = "SELECT * FROM bd_siga.pedidoAutorizacao PA "
                . " INNER JOIN bd_siga.pedido P ON PA.id = P.id "
                . " WHERE PA.encaminhado=0 "
                . " ORDER BY P.dataCriacao ASC";
        $this->bd->query($this->sql);
        return $this->fetchListObject();
    }

    function encerrarPedidoDao($pedidoId) {
        $this->sql = "INSERT INTO bd_siga.pedidoEncerrado (data, pedidoId) VALUES (DATE(NOW()), {$pedidoId});";
        return ($this->bd->query($this->sql) ? TRUE : FALSE);
    }

}
