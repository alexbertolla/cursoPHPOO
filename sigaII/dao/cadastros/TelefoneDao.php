<?php

namespace dao\cadastros;

use bibliotecas\persistencia\BD,
    ArrayObject;

class TelefoneDao {

    private $sql;
    private $bd;
    private $resultado;

    public function __construct() {
        $this->bd = new BD();
    }

    public function __destruct() {
        unset($this->bd);
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\cadastros\Telefone");
    }

    private function fetchListaObject() {
        $arrTelefone = new ArrayObject();
        while ($telefone = $this->fetchObject()) {
            $arrTelefone->append($telefone);
        }
        return $arrTelefone;
    }

    function inserirDao($ddi, $ddd, $numero, $fornecedorId) {
        $this->sql = "INSERT INTO bd_siga.telefone (ddi, ddd, numero, fornecedorId) VALUES (\"{$ddi}\", \"{$ddd}\", \"{$numero}\", {$fornecedorId})";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function excluirDao($id) {
        $this->sql = "DELETE FROM bd_siga.telefone WHERE fornecedorId={$id}";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirPorFornecedorDao($idfornecedor) {
        $this->sql = "DELETE FROM bd_siga.telefone WHERE idfornecedor={$idfornecedor}";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarPorFornencedorIdDao($fornecedorId) {
        $this->sql = "SELECT * FROM bd_siga.telefone WHERE fornecedorId = {$fornecedorId}";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

}
