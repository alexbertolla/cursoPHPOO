<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace dao\configuracao;

/**
 * Description of LogDao
 *
 * @author alex.bertolla
 */

namespace dao\configuracao;

use bibliotecas\persistencia\BD,
    ArrayObject;

class LogDao {

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
        $arrayObject = new ArrayObject();
        while ($log = $this->bd->fetch_object("configuracao\Log")) {
            $arrayObject->append($log);
        }
        return $arrayObject;
    }

    function inserirDao($usuario, $tipoAcao, $acao, $dados) {
        $this->sql = "INSERT INTO bd_siga.log (data, hora, usuario, tipoAcao, acao, dados) "
                . " VALUES (DATE(NOW()), TIME(NOW()), \"{$usuario}\", \"{$tipoAcao}\", \"{$acao}\", \"{$dados}\" );";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarDao() {
        $this->sql = "SELECT * FROM bd_siga.log ORDER BY data, hora DESC";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function listarPorPeriodoSQL($dataInicial, $dataFinal) {
        $this->sql = "SELECT * FROM bd_siga.log "
                . "WHERE data BETWEEN CAST(\"{$dataInicial}\" AS DATE) AND CAST(\"{$dataFinal}\" AS DATE) "
                . "ORDER BY data DESC, hora DESC";
        return $this->fetchObject();
    }

    function excluirPorTempoDao() {
        $this->sql = "DELETE FROM bd_siga.log WHERE DATEDIFF(DATE(NOW()),DATE(data)) >=90";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

}
