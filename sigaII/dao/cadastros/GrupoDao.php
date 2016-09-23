<?php

/* * 
 * ***************************************************************************
 * Classe que controla o acesso ao banco de dados.
 * Sistema Gerenciador de Banco de dados: MySQL 5.
 * 
 * Resumo: Nesta classe estão as instruções SQLs referentes a classe modelo
 * Grupo.
 * As isntruções são enviadas através da classe BD que é importada como uma
 * biblioteca e está bo pacote biblioteca\persistencia
 * Os metétodos desta classe devem ser chamados somente através da classe de
 * controle ManterGrupo.
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

class GrupoDao {

    private $sql;
    private $resultado;
    private $bd;

    public function __construct() {
        $this->bd = new BD();
    }

    public function __destruct() {
        unset($this->bd);
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\cadastros\Grupo");
    }

    private function fetchListaObject() {
        $arrGrupo = new ArrayObject();
        while ($grupo = $this->fetchObject()) {
            $arrGrupo->append($grupo);
        }
        return $arrGrupo;
    }

    function inserirDao($codigo, $nome, $descricao, $situacao, $naturezaDespesaId, $contaContabilId, $tipo) {
        $this->sql = "INSERT INTO bd_siga.grupo (codigo, nome, descricao, situacao, naturezaDespesaId, contaContabilId, tipo) "
                . " VALUES (\"{$codigo}\",\"{$nome}\",\"{$descricao}\",{$situacao},{$naturezaDespesaId},{$contaContabilId},\"{$tipo}\");";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function alterarDao($id, $codigo, $nome, $descricao, $situacao, $naturezaDespesaId, $contaContabilId, $tipo) {
        $this->sql = "UPDATE bd_siga.grupo SET codigo=\"{$codigo}\", nome=\"{$nome}\", descricao=\"{$descricao}\", situacao={$situacao}, naturezaDespesaId={$naturezaDespesaId}, contaContabilId={$contaContabilId}, tipo=\"{$tipo}\" "
                . " WHERE id = {$id}; ";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirDao($id) {
        $this->sql = "DELETE FROM bd_siga.grupo WHERE id = {$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function inserirGurpoPorFornecedorDao($grupoId, $fornecedorId) {
        $this->sql = "INSERT INTO bd_siga.grupoFornecedor (grupoId, fornecedorId) "
                . " VALUES ({$grupoId}, {$fornecedorId});";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirGurpoPorFornecedorDao($fornecedorId) {
        $this->sql = "DELETE FROM bd_siga.grupoFornecedor WHERE fornecedorId = {$fornecedorId};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarDao() {
        $this->sql = "SELECT * FROM  bd_siga.grupo ORDER BY codigo;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarAtivosDao() {
        $this->sql = "SELECT * FROM  bd_siga.grupo WHERE situacao=true ORDER BY codigo;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorCodigoAtivoDao($codigo) {
        $this->sql = "SELECT * FROM  bd_siga.grupo WHERE codigo = \"{$codigo}\" AND situacao=true ORDER BY codigo;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeDao($nome) {
        $this->sql = "SELECT * FROM  bd_siga.grupo WHERE nome LIKE \"%{$nome}%\" ORDER BY codigo;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeAtivoDao($nome) {
        $this->sql = "SELECT * FROM  bd_siga.grupo WHERE nome LIKE \"%{$nome}%\" AND situacao=true ORDER BY codigo;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarAtivosPorNaturezaDespesaIdDao($naturezaDespesaId) {
        $this->sql = "SELECT * FROM  bd_siga.grupo WHERE naturezaDespesaId={$naturezaDespesaId} AND situacao=true ORDER BY codigo;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarAtivosPorTipoNaturezaDespesaDao($tipo) {
        $this->sql = "SELECT G.* FROM bd_siga.grupo G INNER JOIN bd_siga.naturezaDespesa ND ON G.naturezaDespesaId=ND.id WHERE ND.situacao = TRUE AND ND.tipo=\"{$tipo}\" ORDER BY codigo;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarAtivosPorFornecedorIdDao($fornecedorId) {
        $this->sql = "SELECT * FROM bd_siga.grupo G "
                . " INNER JOIN  bd_siga.grupoFornecedor GF ON G.id=GF.grupoId "
                . " WHERE GF.fornecedorID = {$fornecedorId} AND G.situacao = true;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeOuCodigoDao($pesquisa) {
        $this->sql = "SELECT * FROM  bd_siga.grupo WHERE (nome LIKE \"%{$pesquisa}%\") OR (codigo LIKE \"%{$pesquisa}%\")  ORDER BY codigo ASC;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM  bd_siga.grupo WHERE id ={$id};";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarPorCodigoDao($codigo) {
        $this->sql = "SELECT * FROM  bd_siga.grupo WHERE codigo = \"{$codigo}\" ORDER BY codigo;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarPorCodigoAtivoDao($codigo) {
        $this->sql = "SELECT * FROM  bd_siga.grupo WHERE codigo = \"{$codigo}\" AND situacao=true RDER BY codigo;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function listarGruposEstoqueDao() {
        $this->sql = "SELECT G.* FROM bd_siga.itemEstoque IE "
                . " INNER JOIN bd_siga.item I ON IE.itemId=I.id "
                . " INNER JOIN bd_siga.grupo G ON I.grupoId = G.id "
                . " GROUP BY G.id "
                . " ORDER BY G.id ASC";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

}
