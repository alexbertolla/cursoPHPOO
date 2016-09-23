<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ManterEndereco
 *
 * @author alex.bertolla
 */

namespace controle\cadastros;

use modelo\cadastros\Endereco,
    dao\cadastros\EnderecoDao,
    controle\configuracao\GerenciarLog;

class ManterEndereco {

    private $endereco;
    private $enderecoDao;
    private $log;

    public function __construct() {
        $this->endereco = new Endereco();
        $this->enderecoDao = new EnderecoDao();
        $this->log = new GerenciarLog();
    }

    function buscarPorFornecedorId($fornecedorId) {
        $this->setEndereco($this->enderecoDao->buscarPorFornecedorIdDao($fornecedorId));
        $this->bdToFotm();
        return $this->getEndereco();
    }

    function salvar($opcao) {
        $this->formToBd();
                $resultado = $this->inserir();
//        switch ($opcao) {
//            case "inserir":
//                $resultado = $this->inserir();
//                break;
//            case "alterar":
//                $resultado = $this->alterar();
//                break;
//            case "excluir":
//                $resultado = $this->excluir();
//                break;
//        }

        $ação = ($resultado) ? "manutenção cadastral realizada com sucesso" : "erro ao realizar manutenção cadastral";
        $this->log->registarLog($opcao, "{$ação} - Endereço Fornecedor ", $this->endereco->toString());

        return $resultado;
    }

    private function inserir() {
        $this->excluir();
        $id = $this->enderecoDao->inserirDao($this->endereco->getLogradouro(), $this->endereco->getNumero(), $this->endereco->getComplemento(), $this->endereco->getBairro(), $this->endereco->getCidade(), $this->endereco->getEstado(), $this->endereco->getCep(), $this->endereco->getPais(), $this->endereco->getFornecedorId());
        if ($id) {
            $this->endereco->setId($id);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function alterar() {
        return $this->enderecoDao->alterarDao($this->endereco->getId(), $this->endereco->getLogradouro(), $this->endereco->getNumero(), $this->endereco->getComplemento(), $this->endereco->getBairro(), $this->endereco->getCidade(), $this->endereco->getEstado(), $this->endereco->getCep(), $this->endereco->getPais(), $this->endereco->getFornecedorId());
    }

    private function excluir() {
        return $this->enderecoDao->excluirPorFornecedorIdDao($this->endereco->getFornecedorId());
    }

    function formToBd() {
        $this->decode();
    }

    function bdToFotm() {
        if ($this->endereco) {
            $this->encode();
        }
    }

    function listaBdToForm($lista) {
        foreach ($lista as $endereco) {
            $this->setEndereco($endereco);
            $this->encode();
        }
        return $lista;
    }

    private function decode() {
        $this->endereco->setLogradouro($this->utf8Decode($this->endereco->getLogradouro()));
        $this->endereco->setComplemento($this->utf8Decode($this->endereco->getComplemento()));
        $this->endereco->setCidade($this->utf8Decode($this->endereco->getCidade()));
        $this->endereco->setBairro($this->utf8Decode($this->endereco->getBairro()));
        $this->endereco->setPais($this->utf8Decode($this->endereco->getPais()));
    }

    private function encode() {
        $this->endereco->setLogradouro($this->utf8Encode($this->endereco->getLogradouro()));
        $this->endereco->setComplemento($this->utf8Encode($this->endereco->getComplemento()));
        $this->endereco->setCidade($this->utf8Encode($this->endereco->getCidade()));
        $this->endereco->setBairro($this->utf8Encode($this->endereco->getBairro()));
        $this->endereco->setPais($this->utf8Encode($this->endereco->getPais()));
    }

    private function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    private function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    function getEndereco() {
        return $this->endereco;
    }

    function setAtributos($atributos) {
        $this->endereco->setId($atributos->id);
        $this->endereco->setLogradouro($atributos->logradouro);
        $this->endereco->setComplemento($atributos->complemento);
        $this->endereco->setNumero($atributos->numero);
        $this->endereco->setCidade($atributos->cidade);
        $this->endereco->setBairro($atributos->bairro);
        $this->endereco->setCep($atributos->cep);
        $this->endereco->setEstado($atributos->estado);
        $this->endereco->setFornecedorId($atributos->fornecedorId);
        $this->endereco->setPais($atributos->pais);
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function __destruct() {
        unset($this->endereco, $this->enderecoDao, $this->log);
    }

}
