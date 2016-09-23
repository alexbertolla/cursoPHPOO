<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FornecedorDao
 *
 * @author alex.bertolla
 */

namespace dao\cadastros;

use bibliotecas\persistencia\BD,
    ArrayObject;

class FornecedorDao {

    protected $sql;
    protected $bd;
    protected $resultado;
    protected $classeModelo;

    public function __construct() {
        $this->bd = new BD();
    }

    public function __destruct() {
        unset($this->bd);
    }

    protected function fetchListaObject() {
        $arrFornecedor = new ArrayObject();
        while ($fornecedor = $this->fetchObject()) {
            $arrFornecedor->append($fornecedor);
        }
        return $arrFornecedor;
    }

    protected function fetchObject() {
        return $this->bd->fetch_object($this->classeModelo);
    }

    function inserirFornecedorDao($nome, $site, $situacao, $tipo) {
        $this->sql = "INSERT INTO bd_siga.fornecedor (nome, site, situacao, tipo) VALUES (\"{$nome}\",\"{$site}\", {$situacao}, \"{$tipo}\");";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function alterarFornecedorDao($id, $nome, $site, $situacao) {
        $this->sql = "UPDATE bd_siga.fornecedor SET nome=\"{$nome}\", site=\"{$site}\", situacao={$situacao} WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirFornecedorDao($id) {
        $this->sql = "DELETE FROM bd_siga.fornecedor WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function inserirDadosBancarios($bancoId, $fornecedorId, $agencia, $conta, $situacao) {
        $this->sql = "INSERT INTO bd_siga.dadosBancario (bancoId, fornecedorId, agencia, conta, situacao) "
                . "VALUES ({$bancoId}, {$fornecedorId}, \"{$agencia}\", \"{$conta}\", {$situacao});";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function listarPorProcessoCompraDao($processoCompraId) {
        $this->classeModelo = "modelo\cadastros\Fornecedor";
        $this->sql = "SELECT * FROM bd_siga.fornecedor F "
                . " INNER JOIN bd_siga.loteHasItemPedido ON fornecedorId=F.id "
                . " WHERE processoCompraId={$processoCompraId} "
                . " GROUP BY fornecedorId";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

}
