<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DadosBancarioDao
 *
 * @author alex.bertolla
 */

namespace dao\cadastros;

use bibliotecas\persistencia\BD,
    ArrayObject;

class DadosBancarioDao {

    private $sql;
    private $resultado;
    private $bd;

    public function __construct() {
        $this->bd = new BD();
    }

    private function fetchListaObject() {
        $arrDadosBancarios = new ArrayObject();
        while ($dadosBancarios = $this->fetchObject()) {
            $arrDadosBancarios->append($dadosBancarios);
        }
        return $arrDadosBancarios;
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\cadastros\DadosBancario");
    }

    function inserirDao($bancoId, $fornecedorId, $agencia, $conta, $situacao) {
        $this->sql = "INSERT INTO bd_siga.dadosBancario (bancoId, fornecedorId, agencia, conta, situacao) "
                . "VALUES ({$bancoId}, {$fornecedorId}, \"{$agencia}\", \"{$conta}\", {$situacao});";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function alterarDao($id, $bancoId, $fornecedorId, $agencia, $conta, $situacao) {
        $this->sql = "UPDATE bd_siga.dadosBancario SET bancoId={$bancoId}, fornecedorId={$fornecedorId}, agencia=\"{$agencia}\", conta=\"{$conta}\", situacao={$situacao} "
                . " WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirDao($id) {
        $this->sql = "DELETE FROM bd_siga.dadosBancario WHERE id = {$id}";
        return($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarPorFornecedorIdDao($fornecedorId) {
        $this->sql = "SELECT * FROM bd_siga.dadosBancario WHERE fornecedorId={$fornecedorId};";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarAtivosPorFornecedorId($fornecedorId) {
        $this->sql = "SELECT * FROM bd_siga.dadosBancario WHERE fornecedorId={$fornecedorId} AND situacao = 1";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarPorIdDar($id) {
echo        $this->sql = "SELECT * FROM bd_siga.dadosBancario WHERE id={$id}";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    public function __destruct() {
        unset($this->bd);
    }

}
