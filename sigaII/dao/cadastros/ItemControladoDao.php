<?php

/* * 
 * ***************************************************************************
 * Classe que controla o acesso ao banco de dados.
 * Sistema Gerenciador de Banco de dados: MySQL 5.
 * 
 * Resumo: Nesta classe estão as instruções SQLs referentes a classe modelo
 * ItemControlado.
 * As isntruções são enviadas através da classe BD que é importada como uma
 * biblioteca e está bo pacote biblioteca\persistencia
 * Os metétodos desta classe devem ser chamados somente através da classe de
 * controle ManterItemControlado.
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

use bibliotecas\persistencia\BD,
    ArrayObject;

class ItemControladoDao {

    private $sql;
    private $bd;
    private $resultado;

    public function __construct() {
        $this->bd = new BD();
    }

    public function __destruct() {
        unset($this->bd);
    }

    private function fetchListaObject() {
        $arrItemControlado = new ArrayObject();
        while ($itemControlado = $this->fetchObject()) {
            $arrItemControlado->append($itemControlado);
        }
        return $arrItemControlado;
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\cadastros\ItemControlado");
    }

    function inserirDao($nome, $fonte, $quantidade, $apresentacaoComercial, $situacao, $orgaoControladorId, $grupoId) {
        $this->sql = "INSERT INTO bd_siga.itemControlado (nome, fonte, quantidade, apresentacaoComercial, situacao, orgaoControladorId, grupoId) "
                . " VALUES (\"{$nome}\",\"{$fonte}\", {$quantidade},\"{$apresentacaoComercial}\",{$situacao},{$orgaoControladorId},{$grupoId})";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function alterarDao($id, $nome, $fonte, $quantidade, $apresentacaoComercial, $situacao, $orgaoControladorId, $grupoId) {
        $this->sql = "UPDATE bd_siga.itemControlado SET nome=\"{$nome}\", fonte=\"{$fonte}\", quantidade={$quantidade}, apresentacaoComercial=\"{$apresentacaoComercial}\", situacao={$situacao}, orgaoControladorId={$orgaoControladorId}, grupoId={$grupoId} "
                . " WHERE id={$id}";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirDao($id) {
        $this->sql = "DELETE FROM bd_siga.itemControlado WHERE id={$id}";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarDao() {
        $this->sql = "SELECT * FROM bd_siga.itemControlado ORDER BY nome ASC";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarAtivosDao() {
        $this->sql = "SELECT * FROM bd_siga.itemControlado WHERE situacao=true ORDER BY nome ASC";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.itemControlado WHERE nome LIKE \"%{$nome}%\" ORDER BY nome ASC";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeAtivoDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.itemControlado WHERE nome LIKE \"%{$nome}%\" AND situacao=true ORDER BY nome ASC";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorGrupoDao($grupoId) {
        $this->sql = "SELECT * FROM bd_siga.itemControlado WHERE grupoId ={$grupoId} ORDER BY nome ASC";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorGrupoAtivoDao($grupoId) {
        $this->sql = "SELECT * FROM bd_siga.itemControlado WHERE grupoId ={$grupoId} AND situacao=true  ORDER BY nome ASC";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorOrgaoControladorDao($orgaoControladorId) {
        $this->sql = "SELECT * FROM bd_siga.itemControlado WHERE orgaoControladorId ={$orgaoControladorId} ORDER BY nome ASC";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorOrgaoControladorAtivoDao($orgaoControladorId) {
        $this->sql = "SELECT * FROM bd_siga.itemControlado WHERE orgaoControladorId ={$orgaoControladorId} AND situacao=true ORDER BY nome ASC";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorGrupoEOrgaoControladorDao($grupoId, $orgaoControladorId) {
        $this->sql = "SELECT * FROM bd_siga.itemControlado WHERE grupoId={$grupoId} AND orgaoControladorId ={$orgaoControladorId} AND situacao=true ORDER BY nome ASC";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.itemControlado WHERE id ={$id}";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

}
