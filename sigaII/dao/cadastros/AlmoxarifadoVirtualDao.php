<?php

/* * 
 * ***************************************************************************
 * Classe que controla o acesso ao banco de dados.
 * Sistema Gerenciador de Banco de dados: MySQL 5.
 * 
 * Resumo: Nesta classe estão as instruções SQLs referentes a classe modelo
 * AlmoxarifadoVirtual.
 * 
 * As isntruções são enviadas através da classe BD que é importada como uma
 * biblioteca e está bo pacote biblioteca\persistencia
 * Os metétodos desta classe devem ser chamados somente através da classe de
 * controle ManterAlmoxarifadoVirtual.
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

class AlmoxarifadoVirtualDao {

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
        $arrAlmoxarifadoVirtual = new ArrayObject();
        while ($almoxarifadoVirtual = $this->fetchObject()) {
            $arrAlmoxarifadoVirtual->append($almoxarifadoVirtual);
        }
        return $arrAlmoxarifadoVirtual;
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\cadastros\AlmoxarifadoVirtual");
    }

    function inserirDao($nome, $situacao) {
        $this->sql = "INSERT INTO bd_siga.almoxarifadoVirtual (nome, situacao) VALUES (\"{$nome}\", {$situacao});";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function alterarDao($id, $nome, $situacao) {
        $this->sql = "UPDATE bd_siga.almoxarifadoVirtual SET nome=\"{$nome}\", situacao={$situacao} WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirDao($id) {
        $this->sql = "DELETE FROM bd_siga.almoxarifadoVirtual WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarDao() {
        $this->sql = "SELECT * FROM bd_siga.almoxarifadoVirtual ORDER by nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarAtivosDao() {
        $this->sql = "SELECT * FROM bd_siga.almoxarifadoVirtual WHERE situacao=true ORDER by nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.almoxarifadoVirtual WHERE nome LIKE \"%{$nome}%\" ORDER by nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeAtivoDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.almoxarifadoVirtual WHERE nome LIKE \"%{$nome}%\" AND situacao=true ORDER by nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.almoxarifadoVirtual WHERE id={$id}";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

}
