<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\configuracao;

use configuracao\DadosUnidade,
    configuracao\EnderecoUnidade,
    dao\configuracao\DadosUnidadeDao;

/**
 * Description of ManterDadosUnidade
 *
 * @author alex.bertolla
 */
class ManterDadosUnidade {

    private $dadosUnidade;
    private $enderecoUnidade;
    private $dadosUnidadeDao;

    public function __construct() {
        $this->dadosUnidade = new DadosUnidade();
        $this->enderecoUnidade = new EnderecoUnidade();
        $this->dadosUnidadeDao = new DadosUnidadeDao();
    }

    function buscarDadosUnidade() {
        $this->setDadosUnidade($this->dadosUnidadeDao->buscarDadosUnidadeDao());
        $this->dadosUnidade->setEndereco($this->dadosUnidadeDao->buscarEnderecoUnidadeDao());
        $this->encode();
        return $this->getDadosUnidade();
    }

    function salvarDadosUnidade() {
        $this->decode();
        $salvar = $this->dadosUnidadeDao->salvarDadosUnidade($this->dadosUnidade->getNome(), $this->dadosUnidade->getSigla(), $this->dadosUnidade->getCnpj(), $this->dadosUnidade->getInscricaoEstadual(), $this->dadosUnidade->getInscricaoMunicipal(), $this->dadosUnidade->getCodigoSiged(), $this->dadosUnidade->getCodigoUasg(), $this->dadosUnidade->getTelefone(), $this->dadosUnidade->getChefeGeral(), $this->dadosUnidade->getChefeAdministrativo());
        if ($salvar) {
            $this->dadosUnidadeDao->salvarEnderecoUnidade($this->enderecoUnidade->getLogradouro(), $this->enderecoUnidade->getNumero(), $this->enderecoUnidade->getComplemento(), $this->enderecoUnidade->getBairro(), $this->enderecoUnidade->getCidade(), $this->enderecoUnidade->getEstado(), $this->enderecoUnidade->getCep());
        }
        $this->encode();
        return $salvar;
    }

    function getDadosUnidade() {
        return $this->dadosUnidade;
    }

    function getEnderecoUnidade() {
        return $this->enderecoUnidade;
    }

    function setDadosUnidade($dadosUnidade) {
        $this->dadosUnidade = $dadosUnidade;
    }

    function setEnderecoUnidade($enderecoUnidade) {
        $this->enderecoUnidade = $enderecoUnidade;
    }

    private function encode() {
        $this->dadosUnidade->setNome($this->utf8Encode($this->dadosUnidade->getNome()));
        $this->dadosUnidade->setChefeGeral($this->utf8Encode($this->dadosUnidade->getChefeGeral()));
        $this->dadosUnidade->setChefeAdministrativo($this->utf8Encode($this->dadosUnidade->getChefeAdministrativo()));

        $this->enderecoUnidade->setLogradouro($this->utf8Encode($this->enderecoUnidade->getLogradouro()));
        $this->enderecoUnidade->setComplemento($this->utf8Encode($this->enderecoUnidade->getComplemento()));
        $this->enderecoUnidade->setBairro($this->utf8Encode($this->enderecoUnidade->getBairro()));
        $this->enderecoUnidade->setCidade($this->utf8Encode($this->enderecoUnidade->getCidade()));
    }

    private function decode() {
        $this->dadosUnidade->setNome($this->utf8Decode($this->dadosUnidade->getNome()));
        $this->dadosUnidade->setChefeGeral($this->utf8Decode($this->dadosUnidade->getChefeGeral()));
        $this->dadosUnidade->setChefeAdministrativo($this->utf8Decode($this->dadosUnidade->getChefeAdministrativo()));

        $this->enderecoUnidade->setLogradouro($this->utf8Decode($this->enderecoUnidade->getLogradouro()));
        $this->enderecoUnidade->setComplemento($this->utf8Decode($this->enderecoUnidade->getComplemento()));
        $this->enderecoUnidade->setBairro($this->utf8Decode($this->enderecoUnidade->getBairro()));
        $this->enderecoUnidade->setCidade($this->utf8Decode($this->enderecoUnidade->getCidade()));
    }

    private function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    private function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    function setAtributos($atributos) {
        $this->dadosUnidade->setNome($atributos->nome);
        $this->dadosUnidade->setSigla($atributos->sigla);
        $this->dadosUnidade->setCnpj($atributos->cnpj);
        $this->dadosUnidade->setInscricaoEstadual($atributos->inscricaoEstadual);
        $this->dadosUnidade->setInscricaoMunicipal($atributos->inscricaoMunicipal);
        $this->dadosUnidade->setCodigoSiged($atributos->codigoSiged);
        $this->dadosUnidade->setCodigoUasg($atributos->codigoUasg);
        $this->dadosUnidade->setTelefone($atributos->telefone);
        $this->dadosUnidade->setChefeGeral($atributos->chefeGeral);
        $this->dadosUnidade->setChefeAdministrativo($atributos->chefeAdministrativo);
        $this->enderecoUnidade->setLogradouro($atributos->logradouro);
        $this->enderecoUnidade->setNumero($atributos->numero);
        $this->enderecoUnidade->setComplemento($atributos->complemento);
        $this->enderecoUnidade->setBairro($atributos->bairro);
        $this->enderecoUnidade->setCidade($atributos->cidade);
        $this->enderecoUnidade->setEstado($atributos->estado);
        $this->enderecoUnidade->setCep($atributos->cep);
        $this->dadosUnidade->setEndereco($this->enderecoUnidade);
    }

    public function __destruct() {
        unset($this->dadosUnidade, $this->dadosUnidadeDao, $this->enderecoUnidade);
    }

}
