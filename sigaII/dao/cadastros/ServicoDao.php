<?php

/* * 
 * ***************************************************************************
 * Classe que controla o acesso ao banco de dados.
 * Sistema Gerenciador de Banco de dados: MySQL 5.
 * 
 * Resumo: Subclasse da classe ItemDao.Nesta classe estão as instruções SQLs 
 * referentes a classe modelo Servico, e também chamas à super classe.
 * 
 * As isntruções são enviadas através da classe BD que é importada como uma
 * biblioteca e está bo pacote biblioteca\persistencia
 * Os metétodos desta classe devem ser chamados somente através da classe de
 * controle ManterServico.
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

class ServicoDao extends ItemDao {

    public function __construct() {
        parent::__construct();
        $this->classeModelo = "modelo\cadastros\Servico";
    }

    public function __destruct() {
        parent::__destruct();
    }

    function inserirServicoDao($id, $tipo) {
        $this->sql = "INSERT INTO bd_siga.servico (id, tipo) VALUES ({$id},\"{$tipo}\");";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function alterarServicoDao($id, $tipo) {
        $this->sql = "UPDATE bd_siga.servico SET tipo=\"{$tipo}\" WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarDao() {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.servico S ON S.id=I.id ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarAtivosDao() {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.servico S ON S.id=I.id WHERE I.situacao = true ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarAtivosPorGrupoDao($grupoId) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.servico S ON S.id=I.id "
                . " WHERE I.situacao = true "
                . " AND I.grupoId = {$grupoId}"
                . " ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.servico S ON S.id=I.id WHERE I.nome LIKE \"%{$nome}%\" ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeAtivoDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.servico S ON S.id=I.id WHERE LIKE \"%{$nome}%\" AND I.situacao = true ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarPorCodigoDao($codigo) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.servico S ON S.id=I.id WHERE I.codigo={$codigo}";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarPorCodigoAtivoDao($codigo) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.servico S ON S.id=I.id WHERE I.codigo={$codigo} AND I.situacao = true";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function listarPorTipoDao($tipo) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.servico S ON S.id=I.id WHERE S.tipo=\"{$tipo}\" ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.servico S ON S.id=I.id WHERE I.id={$id}";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function listarPorNomeDescricaoOuCodigoDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.item I "
                . " INNER JOIN bd_siga.servico S ON S.id=I.id "
                . " WHERE (I.nome LIKE \"%{$nome}%\") "
                . " OR (I.descricao LIKE \"%{$nome}%\") "
                . " OR (I.codigo LIKE \"%{$nome}%\") "
                . " ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeDescricaoOuCodigoAitvoDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.item I "
                . " INNER JOIN bd_siga.servico S ON S.id=I.id "
                . " WHERE (I.nome LIKE \"%{$nome}%\") "
                . " OR (I.descricao LIKE \"%{$nome}%\") "
                . " OR (I.codigo LIKE \"%{$nome}%\") "
                . " AND (I.situacao=true) "
                . " ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }
    
   function listarPorNomeDescricaoOuCodigoEGrupoAtivoDao($nome, $grupoId) {
        $this->sql = "SELECT * FROM bd_siga.item I "
                . " INNER JOIN bd_siga.servico S ON I.id=S.id "
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
