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
 * Description of ProcessoCompraDao
 *
 * @author alex.bertolla
 */
class ProcessoCompraDao {

    private $sql;
    private $bd;
    private $resultado;

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
        return $this->bd->fetch_object("modelo\compras\ProcessoCompra");
    }

    function inserirDao($numero, $modalidadeId, $numeroModalidade, $responsavel, $objeto, $justificativa, $situacaoId) {
        $this->sql = "INSERT INTO bd_siga.processoCompra (numero, modalidadeId, numeroModalidade, responsavel, dataAbertura, consolidado, bloqueado, encerrado, objeto, justificativa, situacaoId) "
                . "VALUES (\"{$numero}\", {$modalidadeId}, \"{$numeroModalidade}\", \"{$responsavel}\", DATE(NOW()),0, 0, 0,\"{$objeto}\",\"{$justificativa}\", {$situacaoId});";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function alterarDao($id, $numero, $modalidadeId, $numeroModalidade, $objeto, $justificativa) {
        $this->sql = "UPDATE bd_siga.processoCompra SET numero=\"{$numero}\", modalidadeId={$modalidadeId}, numeroModalidade=\"{$numeroModalidade}\", objeto=\"{$objeto}\", justificativa=\"{$justificativa}\" "
                . " WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirDao($id) {
        $this->sql = "DELETE FROM bd_siga.processoCompra WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function consolidarDao($id, $situacaoId) {
        $this->sql = "UPDATE bd_siga.processoCompra SET consolidado=1, situacaoId={$situacaoId} WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function bloquearDao($id, $bloqueado, $situacaoId) {
        $this->sql = "UPDATE bd_siga.processoCompra SET bloqueado={$bloqueado}, situacaoId={$situacaoId} WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function encerrarDao($id) {
        $this->sql = "UPDATE bd_siga.processoCompra SET encerrado=true, dataEncerramento=DATE(NOW()) WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT *  FROM bd_siga.processoCompra WHERE id={$id}";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarPorNumeroDao($numero) {
        $this->sql = "SELECT *  FROM bd_siga.processoCompra WHERE numero=\"{$numero}\"";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function listarConsolidadosDao() {
        $this->sql = "SELECT *  FROM bd_siga.processoCompra WHERE bloqueado=1";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarConsolidadosPorIdDao($id) {
        $this->sql = "SELECT *  FROM bd_siga.processoCompra WHERE id={$id} AND bloqueado=1";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function listarDao() {
        $this->sql = "SELECT * FROM bd_siga.processoCompra ORDER BY dataAbertura ASC";
        $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    function listarAbertoDao() {
        $this->sql = "SELECT *  FROM bd_siga.processoCompra WHERE encerrado=false ORDER BY dataAbertura ASC";
        $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    public function __destruct() {
        unset($this->bd);
    }

    ##############Itens do processo########################
}
