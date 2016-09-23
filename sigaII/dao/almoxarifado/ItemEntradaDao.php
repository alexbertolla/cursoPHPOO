<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace dao\almoxarifado;

use bibliotecas\persistencia\BD,
    ArrayObject;

/**
 * Description of ItemEntradaDao
 *
 * @author alex.bertolla
 */
class ItemEntradaDao {

    private $sql;
    private $bd;

    public function __construct() {
        $this->bd = new BD();
    }

    private function fetchListaObject() {
        $arrNotaFiscal = new ArrayObject();
        while ($notaFiscal = $this->fetchObject()) {
            $arrNotaFiscal->append($notaFiscal);
        }
        return $arrNotaFiscal;
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\almoxarifado\ItemEntrada");
    }

    function inserirDao($entradaId, $fornecedorId, $itemId, $grupoId, $quantidade, $valorUnitario, $valorTotal) {
        $this->sql = "INSERT INTO bd_siga.entradaHasItem (entradaId, fornecedorId, itemId, grupoId, quantidade, valorUnitario, valorTotal) "
                . " VALUES ({$entradaId}, {$fornecedorId}, {$itemId}, {$grupoId}, {$quantidade}, {$valorUnitario}, {$valorTotal});";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirPorEntradaIdDao($entradaId) {
        $this->sql = "DELETE FROM bd_siga.entradaHasItem WHERE entradaId={$entradaId};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarPorEntradaIdDao($entradaId) {
        $this->sql = "SELECT * FROM bd_siga.entradaHasItem "
                . " INNER JOIN bd_siga.item I ON IHE.itemId=I.id "
                . " INNER JOIN bd_siga.materialConsumo MC ON I.id = MC.itemId "
                . " WHERE EHI.entradaId={$entradaId} "
                . " ORDER BY I.codigo ASC;";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    public function __destruct() {
        unset($this->bd);
    }

}
