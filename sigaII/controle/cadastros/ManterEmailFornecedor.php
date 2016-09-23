<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ManterEmail
 *
 * @author alex.bertolla
 */

namespace controle\cadastros;

use modelo\cadastros\EmailFornecedor,
    dao\cadastros\EmailFornecedorDao,
    controle\configuracao\GerenciarLog;

class ManterEmailFornecedor {

    private $email;
    private $emailDao;
    private $log;

    public function __construct() {
        $this->email = new EmailFornecedor();
        $this->emailDao = new EmailFornecedorDao();
        $this->log = new GerenciarLog();
    }

    function listarPorFornecedorId($fornecedorId) {
        return $this->emailDao->listarPorFornecedorIdDao($fornecedorId);
    }

    function salvar($opcao) {
        switch ($opcao) {
            case "inserir":
                $resutlado = $this->inserir();
                break;
            case "excluir":
                $resutlado = $this->excluir();
                break;
        }
        
        $ação = ($resutlado) ? "manutenção cadastral realizada com sucesso" : "erro ao realizar manutenção cadastral";
        $this->log->registarLog($opcao, "{$ação} - Email Fornecedor ", $this->email->toString());
        return $resutlado;
    }

    private function inserir() {
        $id = $this->emailDao->inserirDao($this->email->getEmail(), $this->email->getFornecedorId());
        if ($id) {
            $this->email->setId($id);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function excluir() {
        return $this->emailDao->excluirDao($this->email->getFornecedorId());
    }

    function setAtributos($atributos) {
        $this->email->setId($atributos->id);
        $this->email->setEmail($atributos->email);
        $this->email->setFornecedorId($atributos->fornecedorId);
    }

    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    public function __destruct() {
        unset($this->email, $this->emailDao, $this->log);
    }

}
