<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\email;

use bibliotecas\mail\Email;

/**
 * Description of EnviarEmail
 *
 * @author alex.bertolla
 */
abstract class EnviarEmail {

    private $email;
    private $assunto;
    private $mensagem;
    private $destinatario;
    private $remetenteNome;
    private $remetenteEmail;

    protected function __construct() {
        $this->email = new Email();
        $this->remetenteNome = "SPS";
        $this->remetenteEmail = "alex.berolla@embrapa.br";
    }

    protected function envairEmail() {
        return $this->email->enviarEmail($this->remetenteNome, $this->remetenteEmail, $this->destinatario, $this->assunto, $this->mensagem);
    }

    protected function getAssunto() {
        return $this->assunto;
    }

    protected function getMensagem() {
        return $this->mensagem;
    }

    protected function getDestinatario() {
        return $this->destinatario;
    }

    protected function setAssunto($assunto) {
        $this->assunto = $assunto;
    }

    protected function setMensagem($mensagem) {
        $this->mensagem = nl2br($mensagem);
    }

    protected function setDestinatario($destinatario) {
        $this->destinatario = $destinatario;
    }

    protected function __destruct() {
        unset($this->email);
    }

}
