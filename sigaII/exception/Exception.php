<?php

namespace exception;

use controle\configuracao\MensagemControle;

class Exception {

    private $mensagemControle;

    public function __construct() {
        $this->mensagemControle = new MensagemControle();
    }

    function setMensagemException($mensagem) {
        $this->mensagemControle->setMensagemException('erro', $mensagem);
        return $this->mensagemControle->getMensagem();
    }

    function mensagemSistema($estado) {
        return ($estado) ? $this->mensagemSistemaLiberado() : $this->mensagemSistemaBloqueado();
    }

    function mensagemLogin($estado) {
        return ($estado) ? $this->mensagemSucessoLogin() : $this->mensagemErroLogin();
    }

    function mensagemSessao($estado) {
        return (!$estado) ? $this->mensagemSessaoExpirada() : $this->mensagemSessaoAtiva();
    }

    function mensagemCadastro($estado) {
        return ($estado) ? $this->mensagemSucessoCadastro() : $this->mensagemErroCadastro();
    }

    function mensagemDocumentoFornecedor($estado) {
        return ($estado) ? $this->mensagemDocumentoFornecedorCadastrado() : $this->mensagemDocumentoFornecedorInvalido();
    }

    function mensagemCNJP($estado) {
        return ($estado) ? $this->mensagemCNPJCadastrado() : $this->mensagemCNPJnvalido();
    }

    function mensagemOperacao($estado) {
        return ($estado) ? $this->mensagemSucessoOperacao() : $this->mensagemErroOperacao();
    }

    private function mensagemSistemaLiberado() {
        return "Sistema liberado";
    }

    private function mensagemSistemaBloqueado() {
        $codigoMensagem = 1;
        return $this->mensagemControle->buscarPorCodigo($codigoMensagem);
    }

    private function mensagemSucessoLogin() {
        $codigoMensagem = 2;
        return $this->mensagemControle->buscarPorCodigo($codigoMensagem);
    }

    private function mensagemErroLogin() {
        $codigoMensagem = 3;
        return $this->mensagemControle->buscarPorCodigo($codigoMensagem);
    }

    private function mensagemSucessoCadastro() {
        $codigoMensagem = 4;
        return $this->mensagemControle->buscarPorCodigo($codigoMensagem);
    }

    private function mensagemErroCadastro() {
        $codigoMensagem = 5;
        return $this->mensagemControle->buscarPorCodigo($codigoMensagem);
    }

    private function mensagemDocumentoFornecedorCadastrado() {
        $codigoMensagem = 6;
        return $this->mensagemControle->buscarPorCodigo($codigoMensagem);
    }

    private function mensagemDocumentoFornecedorInvalido() {
        $codigoMensagem = 7;
        return $this->mensagemControle->buscarPorCodigo($codigoMensagem);
    }

    private function mensagemCNPJCadastrado() {
        $codigoMensagem = 8;
        return $this->mensagemControle->buscarPorCodigo($codigoMensagem);
    }

    private function mensagemCNPJnvalido() {
        $codigoMensagem = 9;
        return $this->mensagemControle->buscarPorCodigo($codigoMensagem);
    }

    private function mensagemSessaoExpirada() {
        $codigoMensagem = 10;
        return $this->mensagemControle->buscarPorCodigo($codigoMensagem);
    }

    private function mensagemSessaoAtiva() {
        $codigoMensagem = 11;
        return $this->mensagemControle->buscarPorCodigo($codigoMensagem);
    }

    private function mensagemSucessoOperacao() {
        $codigoMensagem = 12;
        return $this->mensagemControle->buscarPorCodigo($codigoMensagem);
    }

    private function mensagemErroOperacao() {
        $codigoMensagem = 13;
        return $this->mensagemControle->buscarPorCodigo($codigoMensagem);
    }

    public function __destruct() {
        unset($this->mensagemControle);
    }

}
