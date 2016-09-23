<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DocumentosProcessoDeCompra
 *
 * @author alex.bertolla
 */

namespace dao\compras\impressao;

use bibliotecas\persistencia\BD,
    ArrayObject;

class DocumentosProcessoDeCompraDao {

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

    function listarAgrupadosPorFornecedoresVencedoresDao($processoCompraId) {
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

    function listarGastosAgrupadoPorPADao($processoCompraId) {
        $this->sql = "SELECT SUM(PHLI.valorTotal) as valorTotal, P.paId, PHLI.pedidoId FROM bd_siga.propostaHasLoteItemPedido PHLI "
                . " INNER JOIN bd_siga.item I ON PHLI.itemId=I.id "
                . " INNER JOIN bd_siga.pedido P ON PHLI.pedidoId=P.id "
                . " WHERE PHLI.processoCompraId={$processoCompraId} AND "
                . " PHLI.valorUnitario= (SELECT MIN(valorUnitario) FROM bd_siga.propostaHasLoteItemPedido WHERE processoCompraId=PHLI.processoCompraId AND itemId=PHLI.itemId GROUP BY itemId) "
                . " GROUP BY P.paId";
        $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    function listarGastosAgrupadoPorGrupoDao($processoCompraId) {
        $this->sql = "SELECT SUM(PHLI.valorTotal) as valorTotal, PHLI.grupoId FROM bd_siga.propostaHasLoteItemPedido PHLI "
                . " INNER JOIN bd_siga.item I ON PHLI.itemId=I.id "
                . " INNER JOIN bd_siga.pedido P ON PHLI.pedidoId=P.id "
                . " WHERE PHLI.processoCompraId={$processoCompraId} AND "
                . " PHLI.valorUnitario= (SELECT MIN(valorUnitario) FROM bd_siga.propostaHasLoteItemPedido WHERE processoCompraId=PHLI.processoCompraId AND itemId=PHLI.itemId GROUP BY itemId) "
                . " GROUP BY PHLI.grupoId";
        $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    function listarGastosAgrupadoPorNaturezaDespesaDao($processoCompraId) {
        $this->sql = "SELECT SUM(PHLI.valorTotal) as valorTotal, PHLI.naturezaDespesaId FROM bd_siga.propostaHasLoteItemPedido PHLI "
                . " INNER JOIN bd_siga.item I ON PHLI.itemId=I.id "
                . " INNER JOIN bd_siga.pedido P ON PHLI.pedidoId=P.id "
                . " WHERE PHLI.processoCompraId={$processoCompraId} AND "
                . " PHLI.valorUnitario= (SELECT MIN(valorUnitario) FROM bd_siga.propostaHasLoteItemPedido WHERE processoCompraId=PHLI.processoCompraId AND itemId=PHLI.itemId GROUP BY itemId) "
                . " GROUP BY PHLI.naturezaDespesaId";
        $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    function listarItemPreEmpenhoDao($processoCompraId) {
        $this->sql = "SELECT LHIP.* FROM bd_siga.loteHasItemPedido LHIP "
                . " INNER JOIN bd_siga.pedido P ON LHIP.pedidoId=P.id "
                . " WHERE LHIP.processoCompraId={$processoCompraId} "
                . " GROUP BY P.paId";
        $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    public function __destruct() {
        unset($this->bd);
    }

}
