<?php

namespace dao\cadastros;

class FornecedorPJDao extends FornecedorDao {

    public function __construct() {
        parent::__construct();
        $this->classeModelo = "modelo\cadastros\FornecedorPessoaJuridica";
    }

    public function __destruct() {
        parent::__destruct();
    }

    function inserirDao($id, $nomeFantasia, $cnpj, $microEmpresa) {
        $this->sql = "INSERT INTO bd_siga.fornecedorPessoaJuridica (id, nomeFantasia, cnpj, microEmpresa) "
                . " VALUES ({$id}, \"{$nomeFantasia}\", \"{$cnpj}\", {$microEmpresa});";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function alterarDao($id, $nomeFantasia, $cnpj, $microEmpresa) {
        $this->sql = "UPDATE bd_siga.fornecedorPessoaJuridica SET nomeFantasia=\"{$nomeFantasia}\", cnpj=\"{$cnpj}\", microEmpresa={$microEmpresa}  WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarDao() {
        $this->sql = "SELECT * FROM bd_siga.fornecedor F "
                . " INNER JOIN bd_siga.fornecedorPessoaJuridica PJ ON F.id=PJ.id"
                . " ORDER BY F.nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.fornecedor F "
                . " INNER JOIN bd_siga.fornecedorPessoaJuridica PJ ON F.id=PJ.id"
                . " WHERE F.nome LIKE \"%{$nome}%\" "
                . " ORDER BY F.nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeFantasiaDao($nomeFantasia) {
        $this->sql = "SELECT * FROM bd_siga.fornecedor F "
                . " INNER JOIN bd_siga.fornecedorPessoaJuridica PJ ON F.id=PJ.id"
                . " WHERE PJ.nomeFantasia LIKE \"%{$nomeFantasia}%\" "
                . " ORDER BY PJ.nomeFantasia ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeOUNomeFantasiaDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.fornecedor F "
                . " INNER JOIN bd_siga.fornecedorPessoaJuridica PJ ON F.id=PJ.id"
                . " WHERE F.nome LIKE \"%{$nome}%\" OR PJ.nomeFantasia LIKE \"%{$nome}%\" "
                . " ORDER BY PJ.nomeFantasia ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.fornecedor F "
                . " INNER JOIN bd_siga.fornecedorPessoaJuridica PJ ON F.id=PJ.id"
                . " WHERE F.id={$id} "
                . " ORDER BY F.nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarPorCNPJDao($cnpj) {
        $this->sql = "SELECT * FROM bd_siga.fornecedor F "
                . " INNER JOIN bd_siga.fornecedorPessoaJuridica PJ ON F.id=PJ.id"
                . " WHERE PJ.cnpj=\"{$cnpj}\" "
                . " ORDER BY F.nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

}
