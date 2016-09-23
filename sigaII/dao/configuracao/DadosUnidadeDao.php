<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace dao\configuracao;

use bibliotecas\persistencia\BD;

/**
 * Description of DadosUnidadeDao
 *
 * @author alex.bertolla
 */
class DadosUnidadeDao {

    private $sql;
    private $bd;

    public function __construct() {
        $this->bd = new BD();
    }

    function salvarDadosUnidade($nome, $sigla, $cnpj, $inscricaoEstadual, $inscricaoMunicipal, $codigoSiged, $codigoUasg, $telefone, $chefeGeral, $chefeAdministrativo) {
        $this->sql = "UPDATE bd_siga.unidade SET nome=\"{$nome}\", sigla=\"{$sigla}\", cnpj=\"{$cnpj}\", inscricaoEstadual=\"{$inscricaoEstadual}\", inscricaoMunicipal=\"{$inscricaoMunicipal}\", "
                . "codigoSiged=\"{$codigoSiged}\", codigoUasg=\"{$codigoUasg}\", telefone=\"{$telefone}\", chefeGeral=\"{$chefeGeral}\", chefeAdministrativo=\"{$chefeAdministrativo}\" ; ";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function salvarEnderecoUnidade($logradouro, $numero, $complemento, $bairro, $cidade, $estado, $cep) {
        $this->sql = "UPDATE bd_siga.enderecoUnidade SET logradouro=\"{$logradouro}\", numero=\"{$numero}\", complemento=\"{$complemento}\", bairro=\"{$bairro}\", cidade=\"{$cidade}\", estado=\"{$estado}\", cep=\"{$cep}\"  ";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function buscarDadosUnidadeDao() {
        $this->sql = "SELECT * FROM bd_siga.unidade";
        $this->bd->query($this->sql);
        return $this->bd->fetch_object("configuracao\DadosUnidade");
    }

    function buscarEnderecoUnidadeDao() {
        $this->sql = "SELECT * FROM bd_siga.enderecoUnidade";
        $this->bd->query($this->sql);
        return $this->bd->fetch_object("configuracao\EnderecoUnidade");
    }

    public function __destruct() {
        unset($this->bd);
    }

}
