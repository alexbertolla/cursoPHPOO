<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace dao\almoxarifado;

use bibliotecas\persistencia\BD,
    ArrayObject,
    Exception;

/**
 * Description of RequisicaoMaterialDao
 *
 * @author alex.bertolla
 */
class RequisicaoMaterialDao {

    private $sql;
    private $bd;

    public function __construct() {
        $this->bd = new BD();
    }

    private function fetchListaObject() {
        $arrRequisicao = new ArrayObject();
        while ($requisicaoMaterial = $this->fetchObject()) {
            $arrRequisicao->append($requisicaoMaterial);
        }
        return $arrRequisicao;
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\almoxarifado\RequisicaoMaterial");
    }

    function inserirDao($matriculaRequisitante, $paId, $lotacaoId, $situacaoId, $ano) {
        $numero = "(SELECT COUNT(*)+1 FROM bd_siga.requisicao R WHERE R.ano={$ano} GROUP BY R.ano)";
        $this->sql = "INSERT INTO bd_siga.requisicao (numero, matriculaRequisitante, paId, lotacaoId,situacaoId, ano, dataRequisicao) "
                . " VALUES (IFNULL({$numero},1), \"{$matriculaRequisitante}\", {$paId}, {$lotacaoId}, {$situacaoId}, \"{$ano}\", DATE(NOW()));";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function alterarDao($id, $paId, $lotacaoId) {
        $this->sql = "UPDATE bd_siga.requisicao SET paId={$paId}, lotacaoId={$lotacaoId} "
                . " WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function alterarSituacaoIdDao($id, $situacaoId) {
        $this->sql = "UPDATE bd_siga.requisicao SET situacaoId={$situacaoId} "
                . " WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirDao($id) {
        $this->sql = "DELETE FROM bd_siga.requisicao WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function alterarValorDao($id, $valor) {
        $this->sql = "UPDATE bd_siga.requisicao SET valor={$valor} "
                . " WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function enviarDao($id) {
        $this->sql = "UPDATE bd_siga.requisicao SET enviada=1 "
                . " WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function receberDao($id, $matriculaResponsavel) {
        $this->sql = "UPDATE bd_siga.requisicao SET recebida=1, "
                . " matriculaResponsavel={$matriculaResponsavel} "
                . " WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function atendidaDao($id) {
        $this->sql = "UPDATE bd_siga.requisicao SET atendida=1, "
                . " dataAtendimento=DATE(NOW()) "
                . " WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function encerrarDao($id) {
        $this->sql = "UPDATE bd_siga.requisicao SET encerrada=1 "
                . " WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function devolvidaDao($id) {
        $this->sql = "UPDATE bd_siga.requisicao SET enviada=0, recebida=0 "
                . " WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.requisicao WHERE id={$id};";
        $this->bd->query($this->sql);

        return $this->fetchObject();
    }

    function listarPorRequisitanteDao($matriculaRequisitante) {
        $this->sql = "SELECT * FROM bd_siga.requisicao "
                . " WHERE matriculaRequisitante={$matriculaRequisitante} "
                . " ORDER BY dataRequisicao DESC;";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorSituacaoIdDao($situacaoId) {
        $this->sql = "SELECT * FROM bd_siga.requisicao "
                . " WHERE situacaoId={$situacaoId} "
                . " ORDER BY dataRequisicao DESC;";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    public function __destruct() {
        unset($this->bd);
    }

}