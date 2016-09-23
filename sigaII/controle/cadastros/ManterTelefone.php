<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ManterTelefone
 *
 * @author alex.bertolla
 */

namespace controle\cadastros;

use modelo\cadastros\Telefone,
    dao\cadastros\TelefoneDao,
    controle\configuracao\GerenciarLog,
    ArrayObject;

class ManterTelefone {

    private $telefone;
    private $telefoneDao;
    private $log;

    public function __construct() {
        $this->telefone = new Telefone();
        $this->telefoneDao = new TelefoneDao();
        $this->log = new GerenciarLog();
    }

    function listarPorFornecedorId($fornecedorId) {
        return $this->telefoneDao->listarPorFornencedorIdDao($fornecedorId);
    }

    function salvar($opcao) {
        switch ($opcao) {
            case "inserir":
                $resultado = $this->inserir();
                break;
            case "excluir":
                $resultado = $this->excluir();
                break;
        }

        $ação = ($resultado) ? "manutenção cadastral realizada com sucesso" : "erro ao realizar manutenção cadastral";
        $this->log->registarLog($opcao, "{$ação} - Telefone Fornecedor ", $this->telefone->toString());
        return $resultado;
    }

    private function inserir() {
        $id = $this->telefoneDao->inserirDao($this->telefone->getDdi(), $this->telefone->getDdd(), $this->telefone->getNumero(), $this->telefone->getFornecedorId());
        if ($id) {
            $this->telefone->setId($id);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function excluir() {
        return $this->telefoneDao->excluirDao($this->telefone->getFornecedorId());
    }

    function setAtributos($atributos) {
        $this->telefone->setId($atributos->id);
        $this->telefone->setDdi($atributos->ddi);
        $this->telefone->setDdd($atributos->ddd);
        $this->telefone->setNumero($atributos->numeroTelefone);
        $this->telefone->setFornecedorId($atributos->fornecedorId);
    }

    function getTelefone() {
        return $this->telefone;
    }

    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function __destruct() {
        unset($this->telefone, $this->telefoneDao,  $this->log);
    }

}
