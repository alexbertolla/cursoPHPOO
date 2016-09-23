<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\cadastros;

use modelo\cadastros\NaturezaOperacao,
    dao\cadastros\NaturezaOperacaoDao;

/**
 * Description of ManterNaturezaOperacao
 *
 * @author alex.bertolla
 */
class ManterNaturezaOperacao {

    private $naturezaOperacao;
    private $naturezaOperacaoDao;

    public function __construct() {
        $this->naturezaOperacao = new NaturezaOperacao();
        $this->naturezaOperacaoDao = new NaturezaOperacaoDao();
    }

    function listar() {
        $listaNaturezaOperacao = $this->naturezaOperacaoDao->listar();
        $this->listaBdToForm($listaNaturezaOperacao);
        return $listaNaturezaOperacao;
    }

    function buscarPorId($id) {
        $this->setNaturezaOperacao($this->naturezaOperacaoDao->buscarPorId($id));
        $this->bdToForm();
        return $this->getNaturezaOperacao();
    }

    function salvar($opcao) {
        $this->decode();
        switch ($opcao) {
            case "inserir":
                $resultado = $this->inserir();
                break;
            case "alterar":
                $resultado = $this->alterar();
                break;
            case "excluir":
                $resultado = $this->excluir();
                break;
        }
        return $resultado;
    }

    function inserir() {
        $id = $this->naturezaOperacaoDao->inserirDao($this->naturezaOperacao->getNumero(), $this->naturezaOperacao->getNome());
        if ($id) {
            $this->naturezaOperacao->setId($id);
        }
        return $id;
    }

    function alterar() {
        return $this->naturezaOperacaoDao->alterarDao($this->naturezaOperacao->getId(), $this->naturezaOperacao->getNumero(), $this->naturezaOperacao->getNome());
    }

    function excluir() {
        return $this->naturezaOperacaoDao->excluirDao($this->naturezaOperacao->getId());
    }

    function listaBdToForm($listaNaturezaOperacao) {
        foreach ($listaNaturezaOperacao as $naturezaOperacao) {
            $this->setNaturezaOperacao($naturezaOperacao);
            $this->bdToForm();
        }
        return $listaNaturezaOperacao;
    }

    function bdToForm() {
        $this->encode();
    }

    function encode() {
        $this->naturezaOperacao->setNome(utf8_encode($this->naturezaOperacao->getNome()));
    }

    function decode() {
        $this->naturezaOperacao->setNome(utf8_decode($this->naturezaOperacao->getNome()));
    }

    function getNaturezaOperacao() {
        return $this->naturezaOperacao;
    }

    function setNaturezaOperacao($naturezaOperacao) {
        $this->naturezaOperacao = $naturezaOperacao;
    }
    
    function setAtributos($atributos){
        $this->naturezaOperacao->setId($atributos->id);
        $this->naturezaOperacao->setNome($atributos->nome);
        $this->naturezaOperacao->setNumero($atributos->numero);
    }

    public function __destruct() {
        unset($this->naturezaOperacao, $this->naturezaOperacaoDao);
    }

}
