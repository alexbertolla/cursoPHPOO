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
 * Description of SituacaoPedido
 *
 * @author alex.bertolla
 */
class SituacaoPedidoDao {

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
        return $this->bd->fetch_object("modelo\compras\SituacaoPedido");
    }

    function alterarDao($id, $mensagem, $enviaEmail) {
        $this->sql = "UPDATE bd_siga.situacaoPedido SET mensagem=\"{$mensagem}\", enviaEmail={$enviaEmail} WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listar() {
        $this->sql = "SELECT * FROM bd_siga.situacaoPedido ORDER BY codigo ASC";
        $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    function buscarPorId($id) {
        $this->sql = "SELECT * FROM bd_siga.situacaoPedido WHERE id={$id}";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }
    
    function buscarPorCodigo($codigo) {
        $this->sql = "SELECT * FROM bd_siga.situacaoPedido WHERE codigo={$codigo}";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    public function __destruct() {
        unset($this->bd);
    }

}
