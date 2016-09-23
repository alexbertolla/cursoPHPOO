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
 * Description of ItemPedidoDao
 *
 * @author alex.bertolla
 */
class ItemPedidoDao {

    private $sql;
    private $bd;

    public function __construct() {
        $this->bd = new BD();
    }

    private function fetchLitaObject() {
        $arrPedio = new ArrayObject();
        while ($pedido = $this->fetchObject()) {
            $arrPedio->append($pedido);
        }
        return $arrPedio;
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\compras\ItemPedido");
    }

    function inserirDao($pedidoId, $itemId, $quantidade, $situacaoId) {
        $this->sql = "INSERT INTO bd_siga.itemPedido (pedidoId, itemId, quantidade, situacaoId) "
                . " VALUES ({$pedidoId}, {$itemId}, {$quantidade}, {$situacaoId});";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirDao($pedidoId) {
        $this->sql = "DELETE FROM bd_siga.itemPedido WHERE pedidoId={$pedidoId}";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function atualizarSituacaoPorPedidoDao($pedidoId, $situacaoId) {
        $this->sql = "UPDATE bd_siga.itemPedido SET situacaoId={$situacaoId} WHERE pedidoId={$pedidoId};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function atualizarSituacaoPorItemDao($pedidoId, $itemId, $situacaoId) {
        $this->sql = "UPDATE bd_siga.itemPedido SET situacaoId={$situacaoId} WHERE pedidoId={$pedidoId} AND itemId={$itemId};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    public function listarItemPedidoPorPedidoDao($pedidoId) {
        $this->sql = "SELECT IP.* FROM bd_siga.itemPedido IP "
                . " INNER JOIN bd_siga.item I ON IP.itemId=I.id "
                . " WHERE pedidoId={$pedidoId} "
                . " ORDER BY I.codigo ASC;";
        $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    public function listarItemPedidoConsolidadosPorProcessoCompraDao($processoCompraId, $itemId) {
        $this->sql = "SELECT IP.pedidoId,IP.grupoId,IP.naturezaDespesaId,IP.itemId, SUM(IP.quantidade) as quantidade FROM bd_siga.itemPedido IP "
                . " INNER JOIN bd_siga.processoCompraItemPedido PCI ON (PCI.itemId=IP.itemId AND PCI.pedidoId=IP.pedidoId) "
                . " WHERE PCI.processoCompraId={$processoCompraId} AND PCI.itemId={$itemId} "
                . " GROUP BY PCI.processoCompraId, IP.itemId "
                . " ORDER BY PCI.processoCompraId ASC;";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    public function buscarItemPedidoPorPedidoEItemDao($pedidoId, $itemId) {
        $this->sql = "SELECT * FROM bd_siga.itemPedido WHERE pedidoId={$pedidoId} AND itemId={$itemId};";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    public function __destruct() {
        unset($this->bd);
    }

}
