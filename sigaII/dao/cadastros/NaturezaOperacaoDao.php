<?php

namespace dao\cadastros;

use bibliotecas\persistencia\BD,
    ArrayObject;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NaturezaOperacaoDao
 *
 * @author alex.bertolla
 */
class NaturezaOperacaoDao {

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
        return $this->bd->fetch_object("modelo\cadastros\NaturezaOperacao");
    }

    function inserirDao($numero, $nome) {
        $this->sql = "INSERT INTO bd_siga.naturezaOperacao (numero, nome) VALUES (\"{$numero}\",\"{$nome}\");";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function alterarDao($id, $numero, $nome) {
        $this->sql = "UPDATE bd_siga.naturezaOperacao SET numero=\"{$numero}\", nome =\"{$nome}\" WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirDao($id) {
        $this->sql = "DELETE FROM bd_siga.naturezaOperacao WHERE id ={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listar() {
        $this->sql = "SELECT * FROM bd_siga.naturezaOperacao ORDER BY numero ASC";
        $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    function buscarPorId($id) {
        $this->sql = "SELECT * FROM bd_siga.naturezaOperacao WHERE id={$id}";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    public function __destruct() {
        unset($this->bd);
    }

}
