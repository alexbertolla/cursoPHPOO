<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ManterItensDeCompra
 *
 * @author alex.bertolla
 */

namespace controle\configuracao;

use configuracao\ItensDeCompra,
    dao\configuracao\ItensDeCompraDao;

class ManterItensDeCompra {

    private $itensDeCompra;
    private $itensDeCompraDao;

    public function __construct() {
        $this->itensDeCompra = new ItensDeCompra();
        $this->itensDeCompraDao = new ItensDeCompraDao();
    }

    function listar() {
        $lista = $this->itensDeCompraDao->listarDao();
        return $this->listaBdToForm($lista);
    }

    function listarPorNome($nome) {
        $nome = $this->utf8Decode($nome);
        $lista = $this->itensDeCompraDao->listarPorNomeDao($nome);
        return $this->listaBdToForm($lista);
    }

    function buscarPorId($id) {
        return $this->itensDeCompraDao->buscarPorIdDao($id);
    }

    function salvar($opcao) {
        $this->formToBd();
        switch ($opcao) {
            case "inserir":
                $retultado = $this->inserir();
                break;
            case "alterar":
                $retultado = $this->alterar();
                break;
            case "excluir":
                $retultado = $this->excluir();
                break;
        }
        return $retultado;
    }

    private function inserir() {
        return $this->itensDeCompraDao->inserirDao($this->itensDeCompra->getNome(), $this->itensDeCompra->getNomeApresentacao(), $this->itensDeCompra->getDescricao(), $this->itensDeCompra->getNaturezaDespesaId(), $this->itensDeCompra->getArquivo());
    }

    private function alterar() {
        return $this->itensDeCompraDao->alterarDao($this->itensDeCompra->getId(), $this->itensDeCompra->getNome(), $this->itensDeCompra->getNomeApresentacao(), $this->itensDeCompra->getDescricao(), $this->itensDeCompra->getNaturezaDespesaId(), $this->itensDeCompra->getArquivo());
    }

    private function excluir() {
        return $this->itensDeCompraDao->excluirDao($this->itensDeCompra->getId());
    }

    public function __destruct() {
        unset($this->itensDeCompra, $this->itensDeCompraDao);
    }

    function formToBd() {
        $this->decode();
    }

    private function listaBdToForm($lista) {
        foreach ($lista as $itensDeCompra) {
            $this->setItensDeCompra($itensDeCompra);
            $this->bdToForm();
        }
        return $lista;
    }

    function bdToForm() {
        $this->encode();
    }

    private function decode() {
        $this->itensDeCompra->setNome($this->utf8Decode($this->itensDeCompra->getNome()));
        $this->itensDeCompra->setNomeApresentacao($this->utf8Decode($this->itensDeCompra->getNomeApresentacao()));
        $this->itensDeCompra->setDescricao($this->utf8Decode($this->itensDeCompra->getDescricao()));
    }

    private function encode() {
        $this->itensDeCompra->setNome($this->utf8Encode($this->itensDeCompra->getNome()));
        $this->itensDeCompra->setNomeApresentacao($this->utf8Encode($this->itensDeCompra->getNomeApresentacao()));
        $this->itensDeCompra->setDescricao($this->utf8Encode($this->itensDeCompra->getDescricao()));
    }

    private function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    private function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    function setAtributos($atributos) {
        $this->itensDeCompra->setId($atributos->id);
        $this->itensDeCompra->setNome($atributos->nome);
        $this->itensDeCompra->setNomeApresentacao($atributos->nomeApresentacao);
        $this->itensDeCompra->setDescricao($atributos->descricao);
        $this->itensDeCompra->setArquivo($atributos->arquivo);
        $this->itensDeCompra->setNaturezaDespesaId($atributos->naturezaDespesaId);
    }

    function getItensDeCompra() {
        return $this->itensDeCompra;
    }

    function setItensDeCompra($itensDeCompra) {
        $this->itensDeCompra = $itensDeCompra;
    }

}
