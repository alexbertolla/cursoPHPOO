<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace dao\compras;

use bibliotecas\persistencia\BD;

/**
 * Description of SituacaoProcessoDeCompraDao
 *
 * @author alex.bertolla
 */
class SituacaoProcessoDeCompraDao {

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
        return $this->bd->fetch_object("modelo\compras\SituacaoProcessoDeCompra");
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.situacaoProcessoCompra WHERE id={$id};";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarPorCodigoDao($codigo) {
        $this->sql = "SELECT * FROM bd_siga.situacaoProcessoCompra WHERE codigo={$codigo};";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    public function __destruct() {
        unset($this->bd);
    }

}
