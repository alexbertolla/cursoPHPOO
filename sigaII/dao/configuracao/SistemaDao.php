<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace dao\configuracao;

use bibliotecas\persistencia\BD;

/**
 * Description of SistemaDao
 *
 * @author alex.bertolla
 */
class SistemaDao {

    private $sql;
    private $bd;
    private $resultado;

    public function __construct() {
        $this->bd = new BD();
    }

    function inserirDao($anoSistema, $liberado) {
        $this->sql = "INSERT INTO bd_siga.sistema (anoSistema, liberado) VALUES (\"{$anoSistema}\", {$liberado});";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function alterarDao($anoSistema, $liberado) {
        $this->sql = "UPDATE bd_siga.sistema SET anoSistema=\"{$anoSistema}\", liberado={$liberado};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function buscarInfoSistemaDao() {
        $this->sql = "SELECT * FROM bd_siga.sistema;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->bd->fetch_object("configuracao\Sistema");
    }

    public function __destruct() {
        unset($this->bd);
    }

}
