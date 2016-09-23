<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\configuracao;

use configuracao\Mensagem,
    dao\configuracao\MensagemDao;

/**
 * Description of MensagemControle
 *
 * @author alex.bertolla
 */
class MensagemControle {

    private $mensagem;
    private $mensagemDao;

    public function __construct() {
        $this->mensagem = new Mensagem();
        $this->mensagemDao = new MensagemDao();
    }

    function listar() {
        return $this->mensagemDao->listarDao();
    }

    function buscarPorCodigo($codigo) {
        $this->setMensagem($this->mensagemDao->buscarPorCodigoDao($codigo));
        $this->encode();
        return $this->getMensagem();
    }

    function salvar() {
        $this->decode();
        return $this->alterar();
    }

    private function alterar() {
        return $this->mensagemDao->alterarDao($this->mensagem->getId(), $this->mensagem->getMensagem());
    }

    function setAtributos($atributos) {
        $this->mensagem->setId($atributos->id);
        $this->mensagem->setCodigo($atributos->codigo);
        $this->mensagem->setEstado($atributos->estado);
        $this->mensagem->setMensagem($atributos->mensagem);
    }

    private function decode() {
        $this->mensagem->setMensagem($this->utf8Decode($this->mensagem->getMensagem()));
    }

    private function encode() {
        $this->mensagem->setMensagem($this->utf8Encode($this->mensagem->getMensagem()));
    }

    private function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    private function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    function setMensagemException($estado, $mensagem) {
        $this->mensagem->setEstado($estado);
        $this->mensagem->setMensagem($mensagem);
    }

    function getMensagem() {
        return $this->mensagem;
    }

    function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }

    public function __destruct() {
        unset($this->mensagem, $this->mensagemDao);
    }

}
