<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ItensDeCompra
 *
 * @author alex.bertolla
 */

namespace configuracao;

use modelo\NaturezaDespesa;

class ItensDeCompra {

    private $id;
    private $nome;
    private $nomeApresentacao;
    private $descricao;
    private $naturezaDespesaId;
    private $naturezaDespesa;
    private $arquivo;
    

    public function __construct() {
        $this->naturezaDespesa = new NaturezaDespesa();
    }

    public function __destruct() {
        unset($this->naturezaDespesa);
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getNomeApresentacao() {
        return $this->nomeApresentacao;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getNaturezaDespesaId() {
        return $this->naturezaDespesaId;
    }

    function getNaturezaDespesa() {
        return $this->naturezaDespesa;
    }

    function getArquivo() {
        return $this->arquivo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setNomeApresentacao($nomeApresentacao) {
        $this->nomeApresentacao = $nomeApresentacao;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setNaturezaDespesaId($naturezaDespesaId) {
        $this->naturezaDespesaId = $naturezaDespesaId;
    }

    function setNaturezaDespesa($naturezaDespesa) {
        $this->naturezaDespesa = $naturezaDespesa;
    }

    function setArquivo($arquivo) {
        $this->arquivo = $arquivo;
    }

}
