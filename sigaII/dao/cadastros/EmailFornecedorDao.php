<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmailDao
 *
 * @author alex.bertolla
 */

namespace dao\cadastros;

use bibliotecas\persistencia\BD,
    ArrayObject;

class EmailFornecedorDao {

    private $sql;
    private $bd;
    private $resultado;

    public function __construct() {
        $this->bd = new BD();
    }

    public function __destruct() {
        unset($this->bd);
    }

    private function fetchListaObject() {
        $arrEmail = new ArrayObject();
        while ($email = $this->fetchObject()) {
            $arrEmail->append($email);
        }
        return $arrEmail;
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\cadastros\EmailFornecedor");
    }

    function inserirDao($email, $fornecedorId) {
        $this->sql = "INSERT INTO bd_siga.email (email, fornecedorId) VALUES (\"{$email}\",{$fornecedorId});";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function excluirDao($id) {
        $this->sql = "DELETE FROM bd_siga.email WHERE fornecedorId={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirPorFornecedorDao($fornecedorId) {
        $this->sql = "DELETE FROM bd_siga.email WHERE fornecedorId={$fornecedorId};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarPorFornecedorIdDao($fornecedorId) {
        $this->sql = "SELECT * FROM bd_siga.email WHERE fornecedorId = {$fornecedorId}";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

}
