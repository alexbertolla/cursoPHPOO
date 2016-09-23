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
 * Description of SituacaoItemPedidoDao
 *
 * @author alex.bertolla
 */
class SituacaoItemPedidoDao {

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
        return $this->bd->fetch_object("modelo\compras\SituacaoItemPedido");
    }

    function listarDao() {
        $this->sql = "SELECT * FROM bd_siga.situacaoItemPedido ORDER BY codigo ASC;";
        $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.situacaoItemPedido WHERE id={$id};";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarPorCodigoDao($codigo) {
        $this->sql = "SELECT * FROM bd_siga.situacaoItemPedido WHERE codigo={$codigo};";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    public function __destruct() {
        unset($this->bd);
    }

}
