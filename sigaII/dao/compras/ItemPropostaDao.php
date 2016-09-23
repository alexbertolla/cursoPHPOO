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
 * Description of ItemPropostaDao
 *
 * @author alex.bertolla
 */
class ItemPropostaDao {

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
        return $this->bd->fetch_object("modelo\compras\ItemProposta");
    }

    function inserirDao($propostaId, $fornecedorId, $processoCompraId, $loteId, $pedidoId, $itemId, $quantidade, $valorUnitario, $valorTotal, $tipoFornecedor) {
        $this->sql = "INSERT INTO bd_siga.propostaHasLoteItemPedido (propostaId, fornecedorId, processoCompraId, loteId, itemId, pedidoId, quantidade, valorUnitario, valorTotal, tipoFornecedor) "
                . " VALUES ({$propostaId}, {$fornecedorId}, {$processoCompraId}, {$loteId}, {$itemId}, {$pedidoId}, {$quantidade}, {$valorUnitario}, {$valorTotal}, \"{$tipoFornecedor}\");";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirDao($propostaId) {
        $this->sql = "DELETE FROM bd_siga.propostaHasLoteItemPedido WHERE propostaId={$propostaId};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarPorPropostaDao($propostaId) {
        $this->sql = "SELECT * FROM bd_siga.propostaHasLoteItemPedido WHERE propostaId={$propostaId};";
        $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    function listarPorLoteDao($loteId) {
        $this->sql = "SELECT * FROM bd_siga.propostaHasLoteItemPedido WHERE loteId={$loteId};";
        $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    function listarPorProcessoCompraDao($processoCompraId, $itemId) {
        $this->sql = "SELECT PHLI.* FROM bd_siga.propostaHasLoteItemPedido PHLI "
                . " INNER JOIN bd_siga.item I ON PHLI.itemId=I.id "
                . " WHERE PHLI.processoCompraId={$processoCompraId} AND PHLI.itemId={$itemId} "
                . " ORDER BY I.codigo, PHLI.valorUnitario ASC";
        $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    function listarItensMapaDao($proessoCompraId, $itemId) {
        $this->sql = "SELECT PHLI.* FROM bd_siga.propostaHasLoteItemPedido PHLI "
                . " INNER JOIN bd_siga.item I ON PHLI.itemId=I.id "
                . " WHERE processoCompraId={$proessoCompraId} AND PHLI.itemId={$itemId} "
                . " ORDER BY I.codigo, PHLI.valorUnitario ASC";
        $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    function listarFornecedoresVencedoresDao($processoCompraId) {
        $this->sql = "SELECT PHLI.* FROM bd_siga.propostaHasLoteItemPedido PHLI "
                . " INNER JOIN bd_siga.item I ON PHLI.itemId=I.id "
                . " INNER JOIN bd_siga.fornecedor F ON PHLI.fornecedorId=F.id "
                . " WHERE PHLI.processoCompraId={$processoCompraId} AND "
                . " PHLI.valorUnitario="
                . " (SELECT MIN(valorUnitario) FROM bd_siga.propostaHasLoteItemPedido WHERE processoCompraId=PHLI.processoCompraId AND itemId=PHLI.itemId GROUP BY itemId) "
                . " GROUP BY PHLI.fornecedorId "
                . " ORDER BY F.nome, I.codigo ASC";
        $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    function listarItemVencedorPorFornecedorDao($processoCompraId, $fornecedorId) {
        $this->sql = "SELECT PHLI.* FROM bd_siga.propostaHasLoteItemPedido PHLI "
                . " INNER JOIN bd_siga.item I ON PHLI.itemId=I.id "
                . " INNER JOIN bd_siga.fornecedor F ON PHLI.fornecedorId=F.id "
                . " WHERE PHLI.processoCompraId={$processoCompraId} AND PHLI.fornecedorId={$fornecedorId} AND "
                . " PHLI.valorUnitario="
                . " (SELECT MIN(valorUnitario) FROM bd_siga.propostaHasLoteItemPedido WHERE processoCompraId=PHLI.processoCompraId AND itemId=PHLI.itemId GROUP BY itemId) "
                . " ORDER BY F.nome, I.codigo ASC";
        $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    public function __destruct() {
        unset($this->bd);
    }

}
