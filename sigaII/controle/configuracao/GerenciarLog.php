<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\configuracao;

/**
 * Description of GerenciarLog
 *
 * @author alex.bertolla
 */
use configuracao\log,
    dao\configuracao\LogDao,
    configuracao\Sessao;

class GerenciarLog {

    private $sessao;
    private $log;
    private $logDao;

    public function __construct() {
        $this->log = new log();
        $this->logDao = new LogDao();
    }

    function registarLog($tipoAcao, $acao, $dados) {
        $this->sessao = new Sessao();
        if ($this->sessao->getUsuario()) {
            $usuario = $this->sessao->getUsuario()->toString();
        }
//        $this->log->setUsuario($this->sessao->toString());
        $this->log->setUsuario($usuario);
        $this->log->setTipoAcao($tipoAcao);
        $this->log->setAcao($acao);
        $this->log->setDados($dados);
        $this->decode();
        return $this->logDao->inserirDao($this->log->getUsuario(), $this->log->getTipoAcao(), $this->log->getAcao(), $this->log->getDados());
    }

    function listar() {
        return $this->bdToForm($this->logDao->listarDao());
    }

    function listarPorPeriodo($dataInicial, $dataFinal) {
        return $this->bdToForm($this->logDao->listarPorPeriodoSQL($dataInicial, $dataFinal));
    }

    private function bdToForm($listaLog) {
        foreach ($listaLog as $log) {
            $this->log = $log;
            $this->encode();
        }
        return $listaLog;
    }

    private function encode() {
        $this->log->setTipoAcao($this->utf8Encode($this->log->getTipoAcao()));
        $this->log->setAcao($this->utf8Encode($this->log->getAcao()));
        $this->log->setDados($this->utf8Encode($this->log->getDados()));
    }

    private function decode() {
        $this->log->setTipoAcao($this->utf8Decode($this->log->getTipoAcao()));
        $this->log->setAcao($this->utf8Decode($this->log->getAcao()));
        $this->log->setDados($this->utf8Decode($this->log->getDados()));
    }

    private function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    private function utf8Decode($texto) {
        return utf8_decode($texto);
    }

}
