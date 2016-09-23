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
 * Description of LoteProcessoCompra
 *
 * @author alex.bertolla
 */
class LoteProcessoCompraDao {

    private $sql;
    private $bd;

    public function __construct() {
        $this->bd = new BD();
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\compras\LoteProcessoCompra");
    }

    private function fetchListObject() {
        $arrLote = new ArrayObject();
        while ($loteProcessoCompra = $this->fetchObject()) {
            $arrLote->append($loteProcessoCompra);
        }
        return $arrLote;
    }

    function inserirDao($processoCompraId, $modalidadeId) {
        $numero = "IFNULL((SELECT COUNT(processoCompraId) FROM bd_siga.lote L WHERE L.processoCompraId={$processoCompraId} GROUP BY L.processoCompraId), 0)";

        $this->sql = "INSERT INTO bd_siga.lote (numero, processoCompraId, modalidadeId) "
                . " VALUES ({$numero}, {$processoCompraId}, {$modalidadeId});";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function excluirPorProcessoCompraDao($processoCompraId) {
        $this->sql = "DELETE FROM bd_siga.lote WHERE processoCompraId={$processoCompraId}";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarPorProcessoCompraDao($processoCompraId) {
        $this->sql = "SELECT * FROM bd_siga.lote WHERE processoCompraId={$processoCompraId} ORDER BY numero ASC";
        $this->bd->query($this->sql);
        return $this->fetchListObject();
    }

    public function __destruct() {
        unset($this->bd);
    }

}
