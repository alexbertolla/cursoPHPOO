<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace dao\almoxarifado;

use bibliotecas\persistencia\BD,
    ArrayObject;

/**
 * Description of EntradaMaterialDao
 *
 * @author alex.bertolla
 */
class EntradaMaterialDao {

    private $sql;
    private $bd;

    public function __construct() {
        $this->bd = new BD();
    }

    private function fetchListaObject() {
        $arrEntrada = new ArrayObject();
        while ($entrada = $this->fetchObject()) {
            $arrEntrada->append($entrada);
        }
        return $arrEntrada;
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\almoxarifado\EntradaMaterial");
    }

    function inserirDao($fornecedorId, $almoxarifadoVirtualId, $naturezaOperacaoId, $ordemDeCompraId, $processoCompraId, $valor, $tipoFornecedor, $ano) {
        $numero = "(SELECT COUNT(*)+1 FROM bd_siga.entrada E WHERE E.ano={$ano} GROUP BY E.ano)";
        $this->sql = "INSERT INTO bd_siga.entrada (numero, fornecedorId, almoxarifadoVirtualId, naturezaOperacaoId, ordemCompraId, processoCompraId, valor, data, tipoFornecedor, ano) "
                . " VALUES (IFNULL({$numero},1), {$fornecedorId}, {$almoxarifadoVirtualId}, {$naturezaOperacaoId}, {$ordemDeCompraId}, {$processoCompraId}, {$valor}, DATE(NOW()), \"{$tipoFornecedor}\",\"{$ano}\");";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function alterarDao($id, $numero, $fornecedorId, $almoxarifadoVirtualId, $naturezaOperacaoId, $processoCompraId, $valor, $tipoFornecedor) {
        $this->sql = "UPDATE bd_siga.entrada SET numero=\"{$numero}\", fornecedorId={$fornecedorId}, almoxarifadoVirtualId={$almoxarifadoVirtualId}, naturezaOperacaoId={$naturezaOperacaoId}, processoCompraId={$processoCompraId}, valor={$valor}, tipoFornecedor=\"{$tipoFornecedor}\" "
                . " WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirDao($id) {
        $this->sql = "DELETE FROM bd_siga.entrada WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarDao() {
        $this->sql = "SELECT * FROM bd_siga.entrada ORDER BY data ASC;";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.entrada WHERE id={$id};";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarPorNumeroDao($numero) {
        $this->sql = "SELECT * FROM bd_siga.entrada WHERE numero=\"{$numero}\";";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    public function __destruct() {
        unset($this->bd);
    }

}
