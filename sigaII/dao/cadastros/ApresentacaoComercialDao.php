<?php

/* * 
 * ***************************************************************************
 * Classe que controla o acesso ao banco de dados.
 * Sistema Gerenciador de Banco de dados: MySQL 5.
 * 
 * Resumo: Nesta classe estão as instruções SQLs referentes a classe modelo
 * ApresentacaoComercial.
 * 
 * As isntruções são enviadas através da classe BD que é importada como uma
 * biblioteca e está bo pacote biblioteca\persistencia
 * Os metétodos desta classe devem ser chamados somente através da classe de
 * controle ManterAApresentacaoComercial.
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

class ApresentacaoComercialDao {

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
        $arrApresentacaoComercial = new ArrayObject();
        while ($apresentacaoComercial = $this->fetchObject()) {
            $arrApresentacaoComercial->append($apresentacaoComercial);
        }
        return $arrApresentacaoComercial;
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\cadastros\ApresentacaoComercial");
    }

    function inserirDao($nome, $apresentacaoComercial, $quantidade, $situacao, $grupoId) {
        $this->sql = "INSERT INTO bd_siga.apresentacaoComercial (nome, apresentacaoComercial, quantidade, situacao, grupoId) "
                . "VALUES (\"{$nome}\",\"{$apresentacaoComercial}\",{$quantidade},{$situacao},{$grupoId});";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function alterarDao($id, $nome, $apresentacaoComercial, $quantidade, $situacao, $grupoId) {
        $this->sql = "UPDATE bd_siga.apresentacaoComercial SET nome=\"{$nome}\", apresentacaoComercial=\"{$apresentacaoComercial}\", quantidade={$quantidade}, situacao={$situacao}, grupoId={$grupoId} "
                . "WHERE id ={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirDao($id) {
        $this->sql = "DELETE FROM bd_siga.apresentacaoComercial WHERE id ={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarDao() {
        $this->sql = "SELECT * FROM bd_siga.apresentacaoComercial ORDER BY nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarAtivasDao() {
        $this->sql = "SELECT * FROM bd_siga.apresentacaoComercial WHERE situacao=true ORDER BY nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorGrupoDao($grupoId) {
        $this->sql = "SELECT * FROM bd_siga.apresentacaoComercial WHERE grupoId={$grupoId} ORDER BY nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorGrupoAtivoDao($grupoId) {
        $this->sql = "SELECT * FROM bd_siga.apresentacaoComercial WHERE grupoId={$grupoId} AND situacao=true ORDER BY nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.apresentacaoComercial WHERE nome LIKE \"%{$nome}%\" ORDER BY nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeAtivoDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.apresentacaoComercial WHERE nome LIKE \"%{$nome}%\" WHERE situacao=true ORDER BY nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.apresentacaoComercial WHERE id={$id}";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

}
