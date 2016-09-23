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
 * Description of PedidoAtividadeDao
 *
 * @author alex.bertolla
 */
class PedidoAtividadeDao {

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
        return $this->bd->fetch_object("modelo\compras\PedidoAtividade");
    }

    private function fetchListObject() {
        $arrPedidoAtividade = new ArrayObject();
        while ($pedidoAtividade = $this->fetchObject()) {
            $arrPedidoAtividade->append($pedidoAtividade);
        }
        return $arrPedidoAtividade;
    }

    function inserirDao($responsavel, $pedidoId, $atividade) {
        $this->sql = "INSERT INTO bd_siga.pedidoAtividade (data, hora, responsavel, pedidoId, atividade) "
                . " VALUES (DATE(NOW()), TIME(NOW()), \"{$responsavel}\", {$pedidoId}, \"{$atividade}\");";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function listarAtividadePorPedidoDao($pedidoId) {
        $this->sql = "SELECT * FROM bd_siga.pedidoAtividade WHERE pedidoId={$pedidoId} ORDER BY data, hora DESC;";
        $this->bd->query($this->sql);
        return $this->fetchListObject();
    }

}
