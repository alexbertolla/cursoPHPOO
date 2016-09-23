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
 * Description of OrdemDeCompra
 *
 * @author alex.bertolla
 */
class OrdemDeCompraDao {

    private $sql;
    private $bd;

    public function __construct() {
        $this->bd = new BD();
    }

    private function fetchListaObject() {
        $arrPedio = new ArrayObject();
        while ($pedido = $this->fetchObject()) {
            $arrPedio->append($pedido);
        }
        return $arrPedio;
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\compras\OrdemDeCompra");
    }

    public function __destruct() {
        unset($this->bd);
    }

    function novaOrdemDeCompraDao($tipoFornecedor, $processoCompraId, $fornecedorId, $situacaoId) {
        $numeroOrdem = "(SELECT CONCAT(CONCAT(CONCAT(REPEAT(\"0\",4-LENGTH(COUNT(O.id)+1)),COUNT(O.id)+1),\"/\"),YEAR(NOW())) FROM bd_siga.ordemCompra O WHERE O.processoCompraid={$processoCompraId})";
        $sequencia = "(SELECT CONCAT(REPEAT(\"0\",3),1))";
        $this->sql = "INSERT INTO bd_siga.ordemCompra (sequencia, tipoFornecedor, processoCompraId, fornecedorId, situacaoId) "
                . " VALUES ({$sequencia}, \"{$tipoFornecedor}\", {$processoCompraId}, {$fornecedorId},{$situacaoId});";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function gerarNumeroDao($id) {
        $this->sql = "UPDATE bd_siga.ordemCompra SET numero=CONCAT(CONCAT(REPEAT(\"0\",4-LENGTH(id)),id),YEAR(NOW())) WHERE id={$id}";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function novaSequenciaDao($id, $numero, $situacaoId) {
        $sequencia = "(SELECT CONCAT(REPEAT(\"0\",4-LENGTH(COUNT(*)+1)),COUNT(*)+1) FROM bd_siga.ordemCompra where numero=\"{$numero}\")";
        $this->sql = "INSERT INTO bd_siga.ordemCompra (numero, sequencia, tipoFornecedor, processoCompraId, fornecedorId, situacaoId) "
                . "(SELECT numero, {$sequencia}, tipoFornecedor, processoCompraId, fornecedorId, {$situacaoId} as situacaoId FROM bd_siga.ordemCompra WHERE id={$id});";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function efetivarEmissaoDao($id, $dadosBancarioId, $valor, $prazo, $situacaoId) {
        $this->sql = "UPDATE bd_siga.ordemCompra SET dadosBancarioId={$dadosBancarioId}, dataEmissao=DATE(NOW()), valor={$valor}, prazo={$prazo}, situacaoId={$situacaoId} WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function assinaturaFornecedorDao($dataAssinatura, $dataPrazoEntrega, $id, $situacaoId) {
        $this->sql = "UPDATE bd_siga.ordemCompra SET dataAssinatura=\"{$dataAssinatura}\", dataPrazoEntrega=\"{$dataPrazoEntrega}\", situacaoId={$situacaoId} WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function atualizarPrazoDao($prazo, $dataPrazoEntrega, $id) {
        $this->sql = "UPDATE bd_siga.ordemCompra SET prazo=\"{$prazo}\", dataPrazoEntrega=\"{$dataPrazoEntrega}\" WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.ordemCompra WHERE id={$id}";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarPorNumeroESequenciaDao($numero, $sequencia) {
        $this->sql = "SELECT * FROM bd_siga.ordemCompra WHERE numero=\"{$numero}\" AND sequencia=\"{$sequencia}\";";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function listarPorNumeroDao($numero) {
        $this->sql = "SELECT * FROM bd_siga.ordemCompra WHERE numero=\"{$numero}\"";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorFornecedorIdDao($processoCompraId, $fornecedorId) {
        $this->sql = "SELECT * FROM bd_siga.ordemCompra WHERE processoCompraId={$processoCompraId} AND fornecedorId={$fornecedorId}";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarAgrupadasPorFornecedorDao($processoCompraId) {
        $this->sql = "SELECT OC.* FROM bd_siga.ordemCompra OC "
                . " INNER JOIN bd_siga.fornecedor F ON OC.fornecedorId = F.id "
                . " WHERE OC.processoCompraId={$processoCompraId} "
                . " GROUP BY OC.fornecedorId "
                . " ORDER BY F.nome ASC;";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

}
