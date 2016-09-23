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
 * Description of EmpenhoDao
 *
 * @author alex.bertolla
 */
class EmpenhoDao {

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
        return $this->bd->fetch_object("modelo\compras\Empenho");
    }

    function inserirDao($ordemCompraId) {
        /*
          $this->sql = "INSERT INTO bd_siga.empenho (unidadeOrcamentaria, valor, paId, ordemCompraId, naturezaDespesaId) "
          . " SELECT "
          . " (SELECT codigoUasg FROM bd_siga.unidade), "
          . " SUM(IP.valorTotal), P.paId , OC.id , (SELECT I.naturezaDespesaId FROM bd_siga.item I WHERE I.id=IP.itemId) as naturezaDespesaId "
          . " FROM bd_siga.loteHasItemPedido IP "
          . " INNER JOIN bd_siga.ordemCompra OC ON (IP.fornecedorId=OC.fornecedorId AND IP.processoCompraId=OC.processoCompraId) "
          . " INNER JOIN bd_siga.pedido P ON IP.pedidoId=P.id "
          . " WHERE OC.id={$ordemCompraId} "
          . " GROUP BY IP.processoCompraId, IP.fornecedorId, OC.id;";
         * 
         */

        $this->sql = "INSERT INTO bd_siga.empenho (unidadeOrcamentaria, valor, paId, ordemCompraId, naturezaDespesaId, pedidoId) "
                . " SELECT "
                . " (SELECT codigoUasg FROM bd_siga.unidade), "
                . " SUM(LHIP.valorTotal), P.paId , OC.id, G.naturezaDespesaId, P.id "
                . " FROM bd_siga.pedido P "
                . " INNER JOIN bd_siga.loteHasItemPedido LHIP ON P.id = LHIP.pedidoId "
                . " INNER JOIN bd_siga.ordemCompra OC ON LHIP.fornecedorId = OC.fornecedorId AND LHIP.processoCompraId=OC.processoCompraId "
                . " INNER JOIN bd_siga.grupo G ON P.grupoId=G.id "
                . " WHERE OC.id={$ordemCompraId} "
                . " GROUP BY P.id;";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function alterarDao($id, $numero, $data, $unidadeOrcamentaria) {
        $this->sql = "UPDATE bd_siga.empenho SET numero=\"{$numero}\", data=\"{$data}\", unidadeOrcamentaria=\"{$unidadeOrcamentaria}\" "
                . " WHERE id={$id}";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarPorOrdemDeCompraDao($ordemCompraId) {
        $this->sql = "SELECT * FROM bd_siga.empenho WHERE ordemCompraId = {$ordemCompraId};";
        $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    public function __destruct() {
        unset($this->bd);
    }

}
