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
 * Description of RequisicaoAtividadeDao
 *
 * @author alex.bertolla
 */
class RequisicaoAtividadeDao {

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
        return $this->bd->fetch_object("modelo\almoxarifado\RequisicaoAtividade");
    }

    function inserirDao($matriculaResponsavel, $requisicaoId, $situacaoId) {
        $this->sql = "INSERT INTO bd_siga.atividadeRequisicao (data, matriculaResponsavel, requisicaoId, situacaoId) "
                . " VALUES(DATE(NOW()), \"{$matriculaResponsavel}\", {$requisicaoId}, {$situacaoId});";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarPorRequisicaoIdDao($requisicaoId) {
        $this->sql = "SELECT * FROM bd_siga.atividadeRequisicao WHERE requisicaoId={$requisicaoId} ORDER BY data DESC;";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    public function __destruct() {
        unset($this->bd);
    }

}
