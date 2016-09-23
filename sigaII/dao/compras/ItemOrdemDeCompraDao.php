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
 * Description of ItemOrdemDeCompraDao
 *
 * @author alex.bertolla
 */
class ItemOrdemDeCompraDao {

    private $bd;
    private $sql;

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
        return $this->bd->fetch_object("modelo\compras\ItemOrdemDeCompra");
    }

    function inserirDao($ordemCompraId, $processoCompraId, $fornecedorId, $loteId, $pedidoId, $itemId, $quantidade, $valorUnitario, $valorTotal) {
        $this->sql = "INSERT INTO bd_siga.itemOrdemCompra (ordemCompraId, fornecedorId, processoCompraId,  loteId, itemId, pedidoId, quantidade, valorUnitario, valorTotal) "
                . " VALUES ({$ordemCompraId}, {$fornecedorId}, {$processoCompraId}, {$loteId}, {$itemId}, {$pedidoId}, {$quantidade}, {$valorUnitario}, {$valorTotal})";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function atualizarOrdemDeCompraDao($quantidade, $valorTotal, $itemId, $ordemCompraId) {
        $this->sql = "UPDATE bd_siga.itemOrdemCompra SET quantidade = {$quantidade}, valorTotal={$valorTotal} WHERE itemId={$itemId} AND ordemCompraId={$ordemCompraId};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function removerItemDao($itemId, $ordemCompraId) {
        $this->sql = "DELETE FROM bd_siga.itemOrdemCompra WHERE itemId={$itemId} AND ordemCompraId={$ordemCompraId};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarPorOrdemDeCompraDao($ordemCompraId) {
        $this->sql = "SELECT IOC.* FROM bd_siga.itemOrdemCompra IOC "
                . " INNER JOIN bd_siga.item I ON IOC.itemId=I.id "
                . " WHERE IOC.ordemCompraId={$ordemCompraId} "
                . " ORDER BY I.codigo ASC";
        $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    public function __destruct() {
        unset($this->bd);
    }

}
