<?php

/* * 
 * ***************************************************************************
 * Classe que controla o acesso ao banco de dados.
 * Sistema Gerenciador de Banco de dados: MySQL 5.
 * 
 * Resumo: Nesta classe estão as instruções SQLs referentes a classe modelo
 * NaturezaDespesa.
 * As isntruções são enviadas através da classe BD que é importada como uma
 * biblioteca e está bo pacote biblioteca\persistencia
 * Os metétodos desta classe devem ser chamados somente através da classe de
 * controle ManterNaturezaDespesa.
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

class NaturezaDespesaDao {

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
        $arrNaturezaDespeza = new ArrayObject();
        while ($naturezaDespeza = $this->fetchObject()) {
            $arrNaturezaDespeza->append($naturezaDespeza);
        }
        return $arrNaturezaDespeza;
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\cadastros\NaturezaDespesa");
    }

    function inserirDao($codigo, $nome, $situacao, $tipo) {
        $this->sql = "INSERT INTO bd_siga.naturezaDespesa (codigo, nome, situacao, tipo) "
                . "VALUES (\"{$codigo}\",\"{$nome}\",{$situacao}, \"{$tipo}\");";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function alterarDao($id, $codigo, $nome, $situacao, $tipo) {
        $this->sql = "UPDATE bd_siga.naturezaDespesa SET codigo=\"{$codigo}\", nome=\"{$nome}\", situacao={$situacao}, tipo=\"{$tipo}\" WHERE id={$id} ";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirDao($id) {
        $this->sql = "DELETE FROM bd_siga.naturezaDespesa WHERE id={$id} ";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarDao() {
        $this->sql = "SELECT * FROM bd_siga.naturezaDespesa ORDER BY codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarAtivasDao() {
        $this->sql = "SELECT * FROM bd_siga.naturezaDespesa WHERE situacao=1 ORDER BY codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.naturezaDespesa WHERE nome LIKE \"%{$nome}%\" ORDER BY codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function listarPorNomeAtivoDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.naturezaDespesa WHERE nome LIKE \"%{$nome}%\" AND situacao=true ORDER BY codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.naturezaDespesa WHERE id={$id}";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function listarPorTipoAtivoDao($tipo) {
        $this->sql = "SELECT * FROM bd_siga.naturezaDespesa WHERE tipo =\"{$tipo}\" AND situacao=true ORDER BY codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeOuCodigoDao($pesquisa) {
        $this->sql = "SELECT * FROM bd_siga.naturezaDespesa WHERE (nome LIKE \"%{$pesquisa}%\") OR (codigo LIKE \"%{$pesquisa}%\") ORDER BY codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarPorCodigoAtivoDao($codigo) {
        $this->sql = "SELECT * FROM bd_siga.naturezaDespesa WHERE codigo=\"{$codigo}\" AND situacao=TRUE; ";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

}
