<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ManterDadosBancarios
 *
 * @author alex.bertolla
 */

namespace controle\cadastros;

use modelo\cadastros\DadosBancario,
    modelo\cadastros\Banco,
    dao\cadastros\DadosBancarioDao,
    controle\cadastros\ManterBanco,
    controle\configuracao\GerenciarLog;

class ManterDadosBancarios {

    private $dadosBancario;
    private $dadosBancarioDao;
    private $log;

    public function __construct() {
        $this->dadosBancario = new DadosBancario();
        $this->dadosBancarioDao = new DadosBancarioDao();
        $this->log = new GerenciarLog();
    }

    private function setBanco() {
        $manterBanco = new ManterBanco();
        $banco = $manterBanco->buscarPorId($this->dadosBancario->getBancoId());
        $this->dadosBancario->setBanco($banco);
        unset($manterBanco);
    }

    function listarPorFornecedorId($fornecedorId) {
        $lista = $this->dadosBancarioDao->listarPorFornecedorIdDao($fornecedorId);
        foreach ($lista as $dadosBancario) {
            $this->setDadosBancario($dadosBancario);
            $this->setBanco();
        }
        return $lista;
    }

    function listarAtivosPorFornecedorId($fornecedorId) {
        $lista = $this->dadosBancarioDao->listarAtivosPorFornecedorId($fornecedorId);
        foreach ($lista as $dadosBancario) {
            $this->setDadosBancario($dadosBancario);
            $this->setBanco();
        }
        return $lista;
    }

    function buscarPorId($id) {
        $this->setDadosBancario($this->dadosBancarioDao->buscarPorIdDar($id));
        $this->setBanco();
        return $this->getDadosBancario();
    }

    function salvar($opcao) {
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
        $this->log->registarLog($opcao, "{$ação} - Dados Bancários Fornecedor ", $this->dadosBancario->toString());
        return $resultado;
    }

    private function inserir() {
        $id = $this->dadosBancarioDao->inserirDao($this->dadosBancario->getBancoId(), $this->dadosBancario->getFornecedorId(), $this->dadosBancario->getAgencia(), $this->dadosBancario->getConta(), $this->dadosBancario->getSituacao());
        if ($id) {
            $this->dadosBancario->setId($id);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function alterar() {
        return $this->dadosBancarioDao->alterarDao($this->dadosBancario->getId(), $this->dadosBancario->getBancoId(), $this->dadosBancario->getFornecedorId(), $this->dadosBancario->getAgencia(), $this->dadosBancario->getConta(), $this->dadosBancario->getSituacao());
    }

    private function excluir() {
        return $this->dadosBancarioDao->excluirDao($this->dadosBancario->getId());
    }

    function setAtributos($atributos) {
        $this->dadosBancario->setId($atributos->id);
        $this->dadosBancario->setAgencia($atributos->agencia);
        $this->dadosBancario->setConta($atributos->conta);
        $this->dadosBancario->setBancoId($atributos->bancoId);
        $this->dadosBancario->setFornecedorId($atributos->fornecedorId);
        $this->dadosBancario->setSituacao(($atributos->situacao) ? 1 : 0);
    }

    function getDadosBancario() {
        return $this->dadosBancario;
    }

    function setDadosBancario($dadosBancario) {
        $this->dadosBancario = $dadosBancario;
    }

    public function __destruct() {
        unset($this->dadosBancario, $this->dadosBancarioDao, $this->log);
    }

}
