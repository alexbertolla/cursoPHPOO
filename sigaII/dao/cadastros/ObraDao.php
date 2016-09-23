<?php

/* * 
 * ***************************************************************************
 * Classe que controla o acesso ao banco de dados.
 * Sistema Gerenciador de Banco de dados: MySQL 5.
 * 
 * Resumo: Subclasse da classe ItemDao.Nesta classe estão as instruções SQLs 
 * referentes a classe modelo Obra, e também chamas à super classe.
 * 
 * As isntruções são enviadas através da classe BD que é importada como uma
 * biblioteca e está bo pacote biblioteca\persistencia
 * Os metétodos desta classe devem ser chamados somente através da classe de
 * controle ManterObra.
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

class ObraDao extends ItemDao {

    public function __construct() {
        parent::__construct();
        $this->classeModelo = "modelo\cadastros\Obra";
    }

    public function __destruct() {
        parent::__destruct();
    }

    function inserirObraDao($id, $responsavel, $bemPrincipal, $local) {
        $this->sql = "INSERT INTO bd_siga.obra (id, responsavel, bemPrincipal, local) "
                . " VALUES ({$id}, \"{$responsavel}\",\"{$bemPrincipal}\",\"{$local}\");";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function alterarObraDao($id, $responsavel, $bemPrincipal, $local) {
        $this->sql = "UPDATE bd_siga.obra SET id={$id}, responsavel=\"{$responsavel}\", bemPrincipal=\"{$bemPrincipal}\", local=\"{$local}\" "
                . " WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirObraDao($id) {
        $this->sql = "DELETE FROM bd_siga.obra WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarDao() {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.obra O ON O.id=I.id ORDER BY I.nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarAtivosDao() {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.obra O ON O.id=I.id WHERE I.situacao = true ORDER BY I.nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorGrupoAtivoDao($grupoId) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.obra O ON O.id=I.id WHERE I.situacao = true AND I.grupoId={$grupoId} ORDER BY I.nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.obra O ON O.id=I.id WHERE I.nome LIKE \"%{$nome}%\" ORDER BY I.nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeAtivoDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.obra O ON O.id=I.id WHERE I.nome LIKE \"%{$nome}%\" AND I.situacao = true ORDER BY I.nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.obra O ON O.id=I.id WHERE I.id={$id}";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarPorCodigoDao($codigo) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.obra O ON O.id=I.idWHERE I.codigo={$codigo}";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarPorCodigoAtivoDao($codigo) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.obra O ON O.id=I.idWHERE I.codigo={$codigo} AND I.situacao = true;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function listarPorNomeDescricaoOuCodigoDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.item I "
                . " INNER JOIN bd_siga.obra O ON O.id=I.id "
                . " WHERE (I.nome LIKE \"%{$nome}%\") "
                . " OR (I.descricao LIKE \"%{$nome}%\") "
                . " OR (I.codigo LIKE \"%{$nome}%\") "
                . " ORDER BY I.nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeDescricaoOuCodigoAtivoDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.item I "
                . " INNER JOIN bd_siga.obra O ON O.id=I.id "
                . " WHERE (I.nome LIKE \"%{$nome}%\") "
                . " OR (I.descricao LIKE \"%{$nome}%\") "
                . " OR (I.codigo LIKE \"%{$nome}%\") "
                . " AND (I.situacao=true) "
                . " ORDER BY I.nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeDescricaoOuCodigoEGrupoAtivoDao($nome, $grupoId) {
        $this->sql = "SELECT * FROM bd_siga.item I "
                . " INNER JOIN bd_siga.obra O ON I.id=O.id "
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
