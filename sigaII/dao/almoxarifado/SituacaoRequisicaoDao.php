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
 * Description of SituacaoRequisicaoDao
 *
 * @author alex.bertolla
 */
class SituacaoRequisicaoDao {

    private $sql;
    private $bd;

    public function __construct() {
        $this->bd = new BD();
    }

    private function fetchListaObject() {
        $arrSituacao = new ArrayObject();
        while ($SituacaoRequisicao = $this->fetchObject()) {
            $arrSituacao->append($SituacaoRequisicao);
        }
        return $arrSituacao;
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\almoxarifado\SituacaoRequisicao");
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.situacaoRequisicao WHERE id={$id};";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarPorCodigoDao($codigo) {
        $this->sql = "SELECT * FROM bd_siga.situacaoRequisicao WHERE codigo=\"{$codigo}\";";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    public function __destruct() {
        unset($this->bd);
    }

}
