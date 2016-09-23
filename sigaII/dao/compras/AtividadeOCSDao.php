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
 * Description of AtividadeOCSDao
 *
 * @author alex.bertolla
 */
class AtividadeOCSDao {

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
        return $this->bd->fetch_object("modelo\compras\AtividadeOCS");
    }

    function registrarAtividadeDao($atividade, $ordemCompraId) {
        $this->sql = "INSERT INTO bd_siga.atividadeOCS (atividade, data, ordemCompraId) VALUES (\"{$atividade}\", DATE(NOW()),{$ordemCompraId});";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarAtividadeDao($ordemDeCompraId) {
        $this->sql = "SELECT * FROM bd_siga.atividadeOCS WHERE ordemCompraId={$ordemDeCompraId}  ORDER BY data ASC;";
        $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    public function __destruct() {
        unset($this->bd);
    }

}
