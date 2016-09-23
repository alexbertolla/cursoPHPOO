<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ManterFornecedorPessoaFisicao
 *
 * @author alex.bertolla
 */

namespace controle\cadastros;

use modelo\cadastros\FornecedorPessoaJuridica,
    controle\cadastros\ManterFornecedor,
    dao\cadastros\FornecedorPJDao,
    controle\cadastros\ValidarCNPJ,
    controle\cadastros\ManterEndereco;

class ManterFornecedorPessoaJuridica extends ManterFornecedor {

    private $fornecedor;
    private $fornecedorPJDao;
    private $manterEndereco;

    function validarDocumento($documento) {
        return $this->validarCNPJ($documento);
    }

    private function validarCNPJ($cnpj) {
        $validarCNPJ = new ValidarCNPJ();
        return $validarCNPJ->validarCNPJ($cnpj);
    }

    function listar() {
        return $this->listaBdToForm($this->fornecedorPJDao->listarDao());
    }

    function listarPorNome($nome) {
        return $this->listaBdToForm($this->fornecedorPJDao->listarPorNomeOUNomeFantasiaDao($this->utf8Decode($nome)));
    }

    function buscarPorDocumento($documento) {
        $documento = $this->padronizarDocumento($documento);
        $this->setFornecedor($this->buscarPorCNPJ($documento));
        $this->bdToForm();
        return $this->getFornecedor();
    }

    private function buscarPorCNPJ($cnpj) {
        return $this->fornecedorPJDao->buscarPorCNPJDao($cnpj);
    }

    function buscarPorId($id) {
        $this->setFornecedor($this->fornecedorPJDao->buscarPorIdDao($id));
        $this->bdToForm();
        return $this->getFornecedor();
    }

    function salvar($opcao) {
        $this->fornecedor->setCnpj($this->padronizarDocumento($this->fornecedor->getCnpj()));
        $this->formToBd();
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

        $ação = ($resultado) ? "manutenção cadastral realizada com sucesso" : "erro ao realizar manutenção cadastral";
        $this->log->registarLog($opcao, "{$ação} - Fornecedor Pessoa Jurídica", $this->fornecedor->toString());
        return $resultado;
    }

    private function inserir() {
        if ($this->salvarFornecedor("inserir", $this->fornecedor)) {
            return $this->fornecedorPJDao->inserirDao($this->fornecedor->getId(), $this->fornecedor->getNomeFantasia(), $this->fornecedor->getCnpj(), $this->fornecedor->getMicroEmpresa());
        }
    }

    private function alterar() {
        if ($this->salvarFornecedor("alterar", $this->fornecedor)) {
            return $this->fornecedorPJDao->alterarDao($this->fornecedor->getId(), $this->fornecedor->getNomeFantasia(), $this->fornecedor->getCnpj(), $this->fornecedor->getMicroEmpresa());
        }
    }

    private function excluir() {
        return $this->salvarFornecedor("excluir", $this->fornecedor);
    }

    public function __construct() {
        parent::__construct();
        $this->fornecedor = new FornecedorPessoaJuridica();
        $this->fornecedorPJDao = new FornecedorPJDao();
        $this->manterEndereco = new ManterEndereco();
    }

    public function __destruct() {
        parent::__destruct();
        unset($this->fornecedor, $this->fornecedorPJDao);
    }

    function setAtributos($atributos) {
        $this->fornecedor->setId($atributos->id);
        $this->fornecedor->setCnpj($atributos->documento);
        $this->fornecedor->setNome($atributos->nome);
        $this->fornecedor->setNomeFantasia($atributos->nomeFantasia);
        $this->fornecedor->setSite($atributos->site);
        $this->fornecedor->setSituacao(($atributos->situacao) ? $atributos->situacao : 0);
        $this->fornecedor->setMicroEmpresa(($atributos->microEmpresa) ? $atributos->microEmpresa : 0);
        $this->fornecedor->setTipo($atributos->tipoFornecedor);
    }

    function formToBd() {
        $this->decode();
    }

    function bdToForm() {
        if ($this->fornecedor) {
            $this->encode();
            $this->SetDadosFornecedor($this->getFornecedor());
        }
    }

    function listaBdToForm($lista) {
        foreach ($lista as $fornecedor) {
            $this->setFornecedor($fornecedor);
            $this->bdToForm();
        }
        return $lista;
    }

    private function decode() {
        $this->fornecedor->setNome($this->utf8Decode($this->fornecedor->getNome()));
        $this->fornecedor->setNomeFantasia($this->utf8Decode($this->fornecedor->getNomeFantasia()));
    }

    private function encode() {
        $this->fornecedor->setNome($this->utf8Encode($this->fornecedor->getNome()));
        $this->fornecedor->setNomeFantasia($this->utf8Encode($this->fornecedor->getNomeFantasia()));
    }

    private function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    private function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    function getFornecedor() {
        return $this->fornecedor;
    }

    function setFornecedor($fornecedor) {
        $this->fornecedor = $fornecedor;
    }

}
