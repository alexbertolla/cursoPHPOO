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

use modelo\cadastros\FornecedorPessoaFisica,
    dao\cadastros\FornecedorPFDao,
    controle\cadastros\ManterFornecedor,
    ArrayObject,
    configuracao\DataSistema;


class ManterFornecedorPessoaFisica extends ManterFornecedor {

    private $fornecedor;
    private $fornecedorPFDao;

    public function __construct() {
        parent::__construct();
        $this->fornecedor = new FornecedorPessoaFisica();
        $this->fornecedorPFDao = new FornecedorPFDao();
    }

    function setDadosListaFornecedores(ArrayObject $lista) {
        foreach ($lista as $fornecedor) {
            $this->setFornecedor($fornecedor);
            $this->SetDadosFornecedor($fornecedor);
        }
        return $lista;
    }

    function listar() {
        return $this->listaBdToForm($this->fornecedorPFDao->listarDao());
    }

    function listarAtivos() {
        return $this->listaBdToForm($this->fornecedorPFDao->listarAtivosDao());
    }

    function listarPorNome($nome) {
        return $this->listaBdToForm($this->fornecedorPFDao->listarPorNomeDao($this->utf8Decode($nome)));
    }

    function buscarPorDocumento($documento) {
        $documento = $this->padronizarDocumento($documento);
        $this->setFornecedor($this->fornecedorPFDao->buscarPorCPFDao($documento));
        $this->bdToForm();
        return $this->getFornecedor();
    }

    function buscarPorId($id) {
        $this->setFornecedor($this->fornecedorPFDao->buscarPorIdDao($id));
        $this->bdToForm();
        return $this->getFornecedor();
    }

    function salvar($opcao) {
//        $this->setFornecedor($fornecedor);
        $this->fornecedor->setCpf($this->padronizarDocumento($this->fornecedor->getCpf()));
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
        $this->log->registarLog($opcao, "{$ação} - Fornecedor Pessoa Física", $this->fornecedor->toString());

        return $resultado;
    }

    private function inserir() {
        if ($this->salvarFornecedor("inserir", $this->fornecedor)) {
            return $this->fornecedorPFDao->inserirDao($this->fornecedor->getId(), $this->fornecedor->getCpf(), $this->fornecedor->getPis(), $this->fornecedor->getRg(), $this->fornecedor->getOrgaoExpeditor(), $this->fornecedor->getDataExpedicao());
        }
    }

    private function alterar() {
        if ($this->salvarFornecedor("alterar", $this->fornecedor)) {
            return $this->fornecedorPFDao->alterarDao($this->fornecedor->getId(), $this->fornecedor->getCpf(), $this->fornecedor->getPis(), $this->fornecedor->getRg(), $this->fornecedor->getOrgaoExpeditor(), $this->fornecedor->getDataExpedicao());
        }
    }

    private function excluir() {
        return $this->salvarFornecedor("excluir", $this->fornecedor);
    }

    function validarDocumento($documento) {
        return $this->validarCPF($documento);
    }

    private function validarCPF($cpf) {
        $validarCPF = new ValidarCpf();
        $cpfValido = $validarCPF->validarCPF($cpf);
        unset($validarCPF);
        return $cpfValido;
    }

    function formToBd() {
        $data = new DataSistema();
        $this->decode();
        $this->fornecedor->setDataExpedicao($data->BRtoISO($this->fornecedor->getDataExpedicao()));
        unset($data);
    }

    function bdToForm() {
        if ($this->fornecedor) {
            $this->encode();
            $this->SetDadosFornecedor($this->getFornecedor());
            $data = new DataSistema();
            $this->fornecedor->setDataExpedicao($data->ISOtoBR($this->fornecedor->getDataExpedicao()));

            unset($data);
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
    }

    private function encode() {
        $this->fornecedor->setNome($this->utf8Encode($this->fornecedor->getNome()));
    }

    private function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    private function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    function setAtributos($atributos) {
        $this->fornecedor->setId($atributos->id);
        $this->fornecedor->setNome($atributos->nome);
        $this->fornecedor->setSite($atributos->site);
        $this->fornecedor->setCpf($atributos->documento);
        $this->fornecedor->setPis($atributos->pis);
        $this->fornecedor->setRg($atributos->rg);
        $this->fornecedor->setOrgaoExpeditor($atributos->orgaoExpeditor);
        $this->fornecedor->setDataExpedicao($atributos->dataExpedicao);
        $this->fornecedor->setSituacao(($atributos->situacao) ? $atributos->situacao : 0);
        $this->fornecedor->setTipo($atributos->tipoFornecedor);
    }

    function getFornecedor() {
        return $this->fornecedor;
    }

    function setFornecedor($fornecedor) {
        $this->fornecedor = $fornecedor;
    }

    public function __destruct() {
        parent::__destruct();
        unset($this->fornecedor, $this->fornecedorPFDao);
    }

}
