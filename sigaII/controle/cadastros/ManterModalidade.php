<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\cadastros;

use modelo\cadastros\Modalidade,
    dao\cadastros\ModalidadeDao,
    controle\configuracao\GerenciarLog;

/**
 * Description of ManterModalidade
 *
 * @author alex.bertolla
 */
class ManterModalidade {

    private $modalidade;
    private $modalidadeDao;
    private $log;

    public function __construct() {
        $this->modalidade = new Modalidade();
        $this->modalidadeDao = new ModalidadeDao();
        $this->log = new GerenciarLog();
    }

    function listar() {
        return $this->listaBDToForm($this->modalidadeDao->listarDao());
    }

    function listarPorNome($nome) {
        return $this->listaBDToForm($this->modalidadeDao->listarPorNomeDao($this->utf8Decode($nome)));
    }

    function buscarPorId($id) {
        $this->setModalidade($this->modalidadeDao->buscarPorIdDao($id));
        $this->bdToForm();
        return $this->getModalidade();
    }

    function salvar($opcao) {
        $this->formToBD();
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
        $this->log->registarLog($opcao, "{$ação} - Modalidade", $this->modalidade->toString());
        return $resultado;
    }

    private function inserir() {
        return $this->modalidadeDao->inserirDao($this->modalidade->getNome());
    }

    private function alterar() {
        return $this->modalidadeDao->alterarDao($this->modalidade->getId(), $this->modalidade->getNome());
    }

    private function excluir() {
        return $this->modalidadeDao->excluirDao($this->modalidade->getId());
    }

    function listaBDToForm($lista) {
        foreach ($lista as $modalidade) {
            $this->setModalidade($modalidade);
            $this->bdToForm();
        }
        return $lista;
    }

    function formToBD() {
        $this->decode();
    }

    function bdToForm() {
        if (!is_null($this->modalidade)) {
            $this->encode();
        }
    }

    private function encode() {
        $this->modalidade->setNome($this->utf8Encode($this->modalidade->getNome()));
    }

    private function decode() {
        $this->modalidade->setNome($this->utf8Decode($this->modalidade->getNome()));
    }

    private function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    private function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    function setAtributos($atributos) {
        $this->modalidade->setId($atributos->id);
        $this->modalidade->setNome($atributos->nome);
    }

    function getModalidade() {
        return $this->modalidade;
    }

    function setModalidade($modalidade) {
        $this->modalidade = $modalidade;
    }

    public function __destruct() {
        unset($this->modalidade, $this->modalidadeDao);
    }

}
