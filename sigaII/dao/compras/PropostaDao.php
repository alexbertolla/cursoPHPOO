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
 * Description of PropostaDao
 *
 * @author alex.bertolla
 */
class PropostaDao {

    private $sql;
    private $bd;
    private $resultado;

    public function __construct() {
        $this->bd = new BD();
    }

    public function __destruct() {
        unset($this->bd);
    }

    private function fetchLitaObject() {
        $arrPedio = new ArrayObject();
        while ($pedido = $this->fetchObject()) {
            $arrPedio->append($pedido);
        }
        return $arrPedio;
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\compras\Proposta");
    }

    function inserirDao($fornecedorId, $processoCompraId, $data, $numero, $valor, $tipoFornecedor) {
        $this->sql = "INSERT INTO bd_siga.proposta (fornecedorId, processoCompraId, data, numero, valor, tipoFornecedor) "
                . " VALUES ({$fornecedorId},{$processoCompraId}, \"{$data}\", \"{$numero}\", {$valor},\"{$tipoFornecedor}\");";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function excluirDao($propostaId) {
        $this->sql = "DELETE FROM bd_siga.proposta WHERE id={$propostaId}";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarPorProcessoCompraDao($processoCompraId) {
        $this->sql = "SELECT * FROM bd_siga.proposta "
                . " WHERE processoCompraId={$processoCompraId};";
        $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

}
