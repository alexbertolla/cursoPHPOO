<?php

namespace dao\almoxarifado;

use bibliotecas\persistencia\BD,
    ArrayObject;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotaFiscalDao
 *
 * @author alex.bertolla
 */
class NotaFiscalDao {

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
        return $this->bd->fetch_object("modelo\almoxarifado\NotaFiscal");
    }

    function inserirDao($numero, $chaveAcesso, $entradaId, $fornecedorId) {
        $this->sql = "INSERT INTO bd_siga.notaFiscal (numero, chaveAcesso, entradaId, fornecedorId) VALUES (\"{$numero}\", \"{$chaveAcesso}\", {$entradaId}, {$fornecedorId});";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function excluirPorEntradaIdDao($entradaId) {
        $this->sql = "DELETE FROM bd_siga.notaFiscal WHERE entradaId={$entradaId};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.notaFiscal WHERE id={$id};";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarPorEntradaIdDao($entradaId) {
        $this->sql = "SELECT * FROM bd_siga.notaFiscal WHERE entradaId={$entradaId};";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    public function __destruct() {
        unset($this->bd);
    }

}
