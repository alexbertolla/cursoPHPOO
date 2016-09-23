<?php

namespace dao\cadastros;

use bibliotecas\persistencia\BD,
    ArrayObject;

class EnderecoDao {

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
        $arrEndereco = new ArrayObject();
        while ($endereco = $this->fetchObject()) {
            $arrEndereco->append($endereco);
        }
        return $arrEndereco;
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\cadastros\Endereco");
    }

    function inserirDao($logradouro, $numero, $complemento, $bairro, $cidade, $estado, $cep, $pais, $fornecedorId) {
        $this->sql = "INSERT INTO bd_siga.endereco (logradouro, numero, complemento, bairro, cidade, estado, cep, pais, fornecedorId) "
                . " VALUES(\"{$logradouro}\", \"{$numero}\", \"{$complemento}\", \"{$bairro}\", \"{$cidade}\", \"{$estado}\", \"{$cep}\", \"{$pais}\", {$fornecedorId});";
        return($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function alterarDao($id, $logradouro, $numero, $complemento, $bairro, $cidade, $estado, $cep, $pais, $fornecedorId) {
        $this->sql = "UPDATE bd_siga.endereco SET logradouro=\"{$logradouro}\", numero= \"{$numero}\", complemento=\"{$complemento}\", bairro=\"{$bairro}\", cidade=\"{$cidade}\", estado=\"{$estado}\", cep=\"{$cep}\", pais=\"{$pais}\", fornecedorId={$fornecedorId} "
                . "WHERE id={$id}";
        return($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirPorFornecedorIdDao($fornecedorId) {
        $this->sql = "DELETE FROM bd_siga.endereco WHERE fornecedorId={$fornecedorId}";
        return($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function buscarPorFornecedorIdDao($fornecedorId) {
        $this->sql = "SELECT * FROM bd_siga.endereco WHERE fornecedorId = {$fornecedorId}";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

}
