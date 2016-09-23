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
 * Description of ItemPedidoProcessoDao
 *
 * @author alex.bertolla
 */
class ItemProcessoCompraDao {

    private $sql;
    private $bd;

    public function __construct() {
        $this->bd = new BD();
    }

    private function fetchListaObject() {
        $arrPedio = new ArrayObject();
        while ($pedido = $this->fetchObject()) {
            $arrPedio->append($pedido);
        }
        return $arrPedio;
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\compras\ItemProcessoCompra");
    }

    function inserirDao($loteId, $processoCompraId, $pedidoId, $itemId, $quantidade) {
        $this->sql = "INSERT INTO bd_siga.loteHasItemPedido (loteId, processoCompraId, pedidoId, itemId, quantidade) "
                . " VALUES ({$loteId}, {$processoCompraId}, {$pedidoId}, {$itemId}, {$quantidade});";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirPorProcessoDao($processoCompraId) {
        $this->sql = "DELETE FROM bd_siga.loteHasItemPedido "
                . " WHERE processoCompraId={$processoCompraId};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirPorProcessoIdEItemIdDao($processoCompraId, $itemId) {
        $this->sql = "DELETE FROM bd_siga.loteHasItemPedido "
                . " WHERE processoCompraId={$processoCompraId} AND itemId={$itemId};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirDao($processoCompraId, $pedidoId, $itemId) {
        $this->sql = "DELETE FROM bd_siga.loteHasItemPedido "
                . " WHERE processoCompraId={$processoCompraId} "
                . " AND pedidoId={$pedidoId} AND itemId={$itemId};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function alterarLoteDao($loteId, $processoCompraId, $itemId) {
        $this->sql = "UPDATE bd_siga.loteHasItemPedido SET loteId={$loteId} "
                . " WHERE processoCompraId={$processoCompraId} AND itemId={$itemId};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarPorLoteDao($loteId) {
        $this->sql = "SELECT * FROM bd_siga.loteHasItemPedido  LHIP "
                . " INNER JOIN bd_siga.itemPedido IP ON (LHIP.pedidoId=IP.pedidoId AND LHIP.itemId=IP.itemId) "
                . " INNER JOIN bd_siga.item I ON LHIP.itemId=I.id "
                . " WHERE LHIP.loteId={$loteId} "
                . " ORDER BY I.codigo ASC";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorLoteConsolidadoDao($loteId) {
        $this->sql = "SELECT IL.loteId, IL.processoCompraId, IL.pedidoId, IL.itemId, sum(IP.quantidade) as quantidade, IL.valorUnitario, IL.valorTotal, IL.fornecedorId "
                . " FROM bd_siga.loteHasItemPedido IL "
                . " INNER JOIN bd_siga.itemPedido IP ON (IL.pedidoId=IP.pedidoId AND IL.itemId=IP.itemId) "
                . " INNER JOIN bd_siga.item I ON IL.itemId=I.id "
                . " WHERE IL.loteId={$loteId} "
                . " GROUP BY IL.itemId "
                . " ORDER BY I.codigo ASC;";

        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorProcessoCompraDao($processoCompraId) {
        $this->sql = "SELECT * FROM bd_siga.loteHasItemPedido WHERE processoCompraId={$processoCompraId} ORDER BY processoCompraId";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function consolidarValoresEFornecedorDao($processoCompraId, $itemId, $pedidoId) {
        $sqlFornecedor = "SELECT fornecedorId FROM bd_siga.propostaHasLoteItemPedido WHERE processoCompraId={$processoCompraId} AND itemId={$itemId} AND valorUnitario = ( SELECT min(IP.valorUnitario) FROM bd_siga.propostaHasLoteItemPedido IP WHERE IP.processoCompraId={$processoCompraId} AND IP.itemId={$itemId})";
        $sqlTipoFornecedor = "SELECT tipoFornecedor FROM bd_siga.propostaHasLoteItemPedido WHERE processoCompraId={$processoCompraId} AND itemId={$itemId} AND valorUnitario = ( SELECT min(IP.valorUnitario) FROM bd_siga.propostaHasLoteItemPedido IP WHERE IP.processoCompraId={$processoCompraId} AND IP.itemId={$itemId})";
//        $sqlQuantidade = "SELECT quantidade FROM bd_siga.propostaHasLoteItemPedido WHERE processoCompraId={$processoCompraId} AND itemId={$itemId} AND valorUnitario = ( SELECT min(IP.valorUnitario) FROM bd_siga.propostaHasLoteItemPedido IP WHERE IP.processoCompraId={$processoCompraId} AND IP.itemId={$itemId})";
        $sqlValorUnitario = "SELECT valorUnitario FROM bd_siga.propostaHasLoteItemPedido WHERE processoCompraId={$processoCompraId} AND itemId={$itemId} AND valorUnitario = ( SELECT min(IP.valorUnitario) FROM bd_siga.propostaHasLoteItemPedido IP WHERE IP.processoCompraId={$processoCompraId} AND IP.itemId={$itemId})";
//        $sqlValorTotal = "SELECT valorTotal FROM bd_siga.propostaHasLoteItemPedido WHERE processoCompraId={$processoCompraId} AND itemId={$itemId} and valorUnitario = ( SELECT min(IP.valorUnitario) FROM bd_siga.propostaHasLoteItemPedido IP WHERE IP.processoCompraId={$processoCompraId} AND IP.itemId={$itemId})";

        $this->sql = "UPDATE bd_siga.loteHasItemPedido LHIP SET "
                . " LHIP.fornecedorId=({$sqlFornecedor}), "
                . " LHIP.tipoFornecedor=({$sqlTipoFornecedor}),  "
                . " LHIP.valorUnitario=({$sqlValorUnitario}), "
                . " LHIP.valorTotal=({$sqlValorUnitario})* LHIP.quantidade"
                . " WHERE LHIP.processoCompraId={$processoCompraId} AND LHIP.itemId={$itemId} AND LHIP.pedidoId={$pedidoId};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarPorProcessoCompraAgrupadosPorFornecedorDao($processoCompraId) {
        $this->sql = "SELECT * FROM bd_siga.loteHasItemPedido "
                . " INNER JOIN bd_siga.fornecedor F ON fornecedorId=F.id "
                . " WHERE processoCompraId={$processoCompraId} "
                . " GROUP BY fornecedorId "
                . " ORDER BY F.nome";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarParaMontarOrdemDeCompraDao($numeroOrdemDeCompra, $sequencia = '%') {

        $this->sql = "SELECT LHIP.loteId, LHIP.processoCompraId, LHIP.pedidoId, LHIP.itemId, LHIP.fornecedorId, LHIP.tipoFornecedor, LHIP.valorUnitario "
                . " ,LHIP.quantidade - IFNULL(IOC.quantidade,0) as quantidade, LHIP.valorTotal - IFNULL(IOC.valorTotal,0) as valorTotal "
//                . " ,(SELECT SUM(quantidade) FROM bd_siga.loteHasItemPedido WHERE  processoCompraId=LHIP.processoCompraId AND itemId=LHIP.itemId GROUP BY itemId)-(IFNULL(SUM(IOC.quantidade),0)) as quantidade "
//                . " ,(SELECT SUM(valorTotal) FROM bd_siga.loteHasItemPedido WHERE  processoCompraId=LHIP.processoCompraId AND itemId=LHIP.itemId GROUP BY itemId)-(IFNULL(SUM(IOC.valorTotal),0)) as valorTotal "
                . " FROM bd_siga.loteHasItemPedido LHIP "
                . " INNER JOIN bd_siga.item I ON LHIP.itemId=I.id "
                . " INNER JOIN bd_siga.ordemCompra OC ON (LHIP.fornecedorId=OC.fornecedorId AND LHIP.processoCompraId=OC.processoCompraId) "
                . " LEFT JOIN bd_siga.itemOrdemCompra IOC ON (LHIP.itemId=IOC.itemId AND LHIP.processoCompraId=IOC.processoCompraId  AND IOC.pedidoId=LHIP.pedidoId) "
                . " WHERE OC.numero=\"{$numeroOrdemDeCompra}\"  AND OC.sequencia LIKE \"{$sequencia}\" "
//                . " GROUP BY LHIP.itemId "
                . " ORDER BY I.codigo, IOC.ordemCompraId ASC;";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarItemJaCadastradoDao($pedidoId, $itemId) {
        $this->sql = "SELECT * FROM  bd_siga.loteHasItemPedido WHERE "
                . " pedidoId = {$pedidoId} AND "
                . " itemId = {$itemId} ";
        $this->bd->query($this->sql);
        return $this->bd->num_rows();
    }

    public function __destruct() {
        unset($this->bd);
    }

}
