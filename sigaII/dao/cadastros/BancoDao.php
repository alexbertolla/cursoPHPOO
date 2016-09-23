<?php

/* * 
 * ***************************************************************************
 * Classe que controla o acesso ao banco de dados.
 * Sistema Gerenciador de Banco de dados: MySQL 5.
 * 
 * Resumo: Nesta classe estão as instruções SQLs referentes a classe modelo
 * Banco.
 * 
 * As isntruções são enviadas através da classe BD que é importada como uma
 * biblioteca e está bo pacote biblioteca\persistencia
 * Os metétodos desta classe devem ser chamados somente através da classe de
 * controle ManterBanco.
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

class BancoDao {

    private $sql;
    private $bd;
    private $resultado;

    public function __construct() {
        $this->bd = new BD();
    }

    public function __destruct() {
        unset($this->bd);
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\cadastros\Banco");
    }

    private function fetchListaObject() {
        $arrBanco = new ArrayObject();
        while ($banco = $this->fetchObject()) {
            $arrBanco->append($banco);
        }
        return $arrBanco;
    }

    function inserirDao($codigo, $nome, $situacao) {
        $this->sql = "INSERT INTO bd_siga.banco (codigo, nome, situacao) VALUES (\"{$codigo}\",\"{$nome}\",{$situacao});";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function alterarDao($id, $codigo, $nome, $situacao) {
        $this->sql = "UPDATE bd_siga.banco SET codigo=\"{$codigo}\", nome=\"{$nome}\", situacao={$situacao} WHERE id = {$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirDao($id) {
        $this->sql = "DELETE FROM bd_siga.banco WHERE id = {$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarDao() {
        $this->sql = "SELECT * FROM bd_siga.banco ORDER BY nome;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarAtivosDao() {
        $this->sql = "SELECT * FROM bd_siga.banco WHERE situacao = 1 ORDER BY nome;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarPorCodigoDao($codigo) {
        $this->sql = "SELECT * FROM bd_siga.banco WHERE codigo=\"{$codigo}\" ORDER BY nome;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarPorCodigoAtivoDao($codigo) {
        $this->sql = "SELECT * FROM bd_siga.banco WHERE codigo=\"{$codigo}\" AND situacao=true ORDER BY nome;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.banco WHERE nome LIKE \"%{$nome}%\" ORDER BY nome;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeAtivoDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.banco WHERE nome LIKE \"%{$nome}%\" AND situacao=true ORDER BY nome;";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.banco WHERE id = {$id};";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

}
