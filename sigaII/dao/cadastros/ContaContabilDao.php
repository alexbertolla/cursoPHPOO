<?php

/* * 
 * ***************************************************************************
 * Classe que controla o acesso ao banco de dados.
 * Sistema Gerenciador de Banco de dados: MySQL 5.
 * 
 * Resumo: Nesta classe estão as instruções SQLs referentes a classe modelo
 * ContaContabil.
 * As isntruções são enviadas através da classe BD que é importada como uma
 * biblioteca e está bo pacote biblioteca\persistencia
 * Os metétodos desta classe devem ser chamados somente através da classe de
 * controle ManterContaContabil.
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

class ContaContabilDao {

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
        $arrContaContabil = new ArrayObject();
        while ($contaContabil = $this->fetchObject()) {
            $arrContaContabil->append($contaContabil);
        }
        return $arrContaContabil;
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\cadastros\ContaContabil");
    }

    function inserirDao($codigo, $nome, $situacao) {
        $this->sql = "INSERT INTO bd_siga.contaContabil (codigo, nome, situacao) VALUES (\"{$codigo}\", \"{$nome}\",{$situacao});";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function alterarDao($id, $codigo, $nome, $situacao) {
        $this->sql = "UPDATE bd_siga.contaContabil SET codigo=\"{$codigo}\", nome=\"{$nome}\", situacao={$situacao} WHERE id = {$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirDao($id) {
        $this->sql = "DELETE FROM bd_siga.contaContabil WHERE id = {$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarDao() {
        $this->sql = "SELECT * from bd_siga.contaContabil ORDER BY codigo;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarAtivasDao() {
        $this->sql = "SELECT * from bd_siga.contaContabil WHERE situacao = true ORDER BY codigo;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeDao($nome) {
        $this->sql = "SELECT * from bd_siga.contaContabil WHERE nome LIKE \"%{$nome}%\" ORDER BY codigo;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeAtivoDao($nome) {
        $this->sql = "SELECT * from bd_siga.contaContabil WHERE nome LIKE \"%{$nome}%\" situacao = true ORDER BY codigo;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * from bd_siga.contaContabil WHERE id = {$id};";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarPorCodigoAtivoDao($codigo) {
        $this->sql = "SELECT * from bd_siga.contaContabil WHERE codigo = {$codigo} AND situacao = true;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

}
