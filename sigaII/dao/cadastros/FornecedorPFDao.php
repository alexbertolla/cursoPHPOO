<?php

namespace dao\cadastros;

class FornecedorPFDao extends FornecedorDao {

    public function __construct() {
        parent::__construct();
        $this->classeModelo = "modelo\cadastros\FornecedorPessoaFisica";
    }

    public function __destruct() {
        parent::__destruct();
    }

    function inserirDao($id, $cpf, $pis, $rg, $orgaoExpeditor, $dataExpedicao) {
        $this->sql = "INSERT INTO bd_siga.fornecedorPessoaFisica (id, cpf, pis, rg, orgaoExpeditor, dataExpedicao) "
                . " VALUES ({$id}, \"{$cpf}\", \"{$pis}\", \"{$rg}\", \"{$orgaoExpeditor}\", \"{$dataExpedicao}\");";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function alterarDao($id, $cpf, $pis, $rg, $orgaoExpeditor, $dataExpedicao) {
        $this->sql = "UPDATE bd_siga.fornecedorPessoaFisica SET cpf=\"{$cpf}\", pis=\"{$pis}\", rg=\"{$rg}\", orgaoExpeditor=\"{$orgaoExpeditor}\", dataExpedicao=\"{$dataExpedicao}\" "
                . " WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarDao() {
        $this->sql = "SELECT * FROM bd_siga.fornecedor F "
                . " INNER JOIN bd_siga.fornecedorPessoaFisica PF ON F.id=PF.id"
                . " ORDER BY F.nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarAtivosDao() {
        $this->sql = "SELECT * FROM bd_siga.fornecedor F "
                . " INNER JOIN bd_siga.fornecedorPessoaFisica PF ON F.id=PF.id "
                . " WHERE F.situacao=true"
                . " ORDER BY F.nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.fornecedor F "
                . " INNER JOIN bd_siga.fornecedorPessoaFisica PF ON F.id=PF.id"
                . " WHERE F.nome LIKE \"%{$nome}%\" "
                . " ORDER BY F.nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.fornecedor F "
                . " INNER JOIN bd_siga.fornecedorPessoaFisica PF ON F.id=PF.id"
                . " WHERE F.id={$id} "
                . " ORDER BY F.nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarPorCPFDao($cpf) {
        $this->sql = "SELECT * FROM bd_siga.fornecedor F "
                . " INNER JOIN bd_siga.fornecedorPessoaFisica PF ON F.id=PF.id"
                . " WHERE PF.cpf=\"{$cpf}\" "
                . " ORDER BY F.nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

}
