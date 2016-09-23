<?php

/* * 
 * ***************************************************************************
 * Classe que controla o acesso ao banco de dados.
 * Sistema Gerenciador de Banco de dados: MySQL 5.
 * 
 * Resumo: Subclasse da classe ItemDao.Nesta classe estão as instruções SQLs 
 * referentes a classe modelo MaterialPermanente, e também chamas à super classe.
 * 
 * As isntruções são enviadas através da classe BD que é importada como uma
 * biblioteca e está bo pacote biblioteca\persistencia
 * Os metétodos desta classe devem ser chamados somente através da classe de
 * controle ManterMaterialPermanente.
 * 
 * Alex Bisetto Bertolla
 * alex.bertolla@embrapa.br
 * (85)3391-7163
 * Núcleo de Tecnologia da Informação
 * Embrapa Agroidústria Tropical
 * 
 * ***************************************************************************
 */

namespace dao\cadastros;

class MaterialPermanenteDao extends ItemDao {

    public function __construct() {
        parent::__construct();
        $this->classeModelo = "modelo\cadastros\MaterialPermanente";
    }

    public function __destruct() {
        parent::__destruct();
        unset($this->classeModelo);
    }

    function inserirMaterialPermanenteDao($id, $marca, $modelo, $partNumber) {
        $this->sql = "INSERT INTO bd_siga.materialPermanente (id, marca, modelo, partNumber) "
                . " VALUES ({$id}, \"{$marca}\", \"{$modelo}\", \"{$partNumber}\");";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function alterarMaterialPermanenteDao($id, $marca, $modelo, $partNumber) {
        $this->sql = "UPDATE bd_siga.materialPermanente SET marca=\"{$marca}\", modelo=\"{$modelo}\", partNumber=\"{$partNumber}\" WHERE id={$id} ";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirMaterialPermanenteDao($id) {
        $this->sql = "DELETE FROM bd_siga.materialPermanente WHERE id={$id} ";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarDao() {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.materialPermanente P ON I.id=P.id ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarAtivosDao() {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.materialPermanente P ON I.id=P.id WHERE situacao=TRUE ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorGrupoAtivoDao($grupoId) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.materialPermanente P ON I.id=P.id WHERE situacao=TRUE AND I.grupoId={$grupoId} ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.materialPermanente P ON I.id=P.id WHERE nome LIKE \"%{$nome}%\" ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeAtivoDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.materialPermanente P ON I.id=P.id WHERE nome LIKE \"%{$nome}%\" AND situacao=TRUE ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarPorCodigoDao($codigo) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.materialPermanente P ON I.id=P.id WHERE I.codigo = {$codigo}";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarPorCodigoAtivoDao($codigo) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.materialPermanente P ON I.id=P.id WHERE I.codigo = {$codigo} AND situacao=TRUE;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.materialPermanente P ON I.id=P.id WHERE I.id = {$id}";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function listarPorNomeDescricaoOuCodigoDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.item I "
                . " INNER JOIN bd_siga.materialPermanente P ON I.id=P.id "
                . " WHERE (nome LIKE \"%{$nome}%\") "
                . " OR (descricao LIKE \"%{$nome}%\") "
                . " OR (codigo LIKE \"%{$nome}%\") "
                . " ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeDescricaoOuCodigoAtivoDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.item I "
                . " INNER JOIN bd_siga.materialPermanente P ON I.id=P.id "
                . " WHERE (nome LIKE \"%{$nome}%\") "
                . " OR (descricao LIKE \"%{$nome}%\") "
                . " OR (codigo LIKE \"%{$nome}%\") "
                . " AND (I.situacao=true)"
                . " ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeDescricaoOuCodigoEGrupoAtivoDao($nome, $grupoId) {
        $this->sql = "SELECT * FROM bd_siga.item I "
                . " INNER JOIN bd_siga.materialPermanente P ON I.id=P.id "
                . " WHERE ((I.nome LIKE \"%{$nome}%\") "
                . " OR (I.descricao LIKE \"%{$nome}%\") "
                . " OR (I.codigo LIKE \"%{$nome}%\") )"
                . " AND (I.situacao=true)"
                . " AND (I.grupoId={$grupoId})"
                . " ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

}
