<?php

namespace configuracao;

class Sessao {

    private $nome;
    private $estado;
    private $usuario;
    private $configuracao;

    public function __construct() {
        $this->nome = "sessaoSIGA";
        session_start();
        if ($_SESSION[$this->nome]) {
            $this->recuperarSessao();
        } else {
            $this->cirarSessao();
        }
        session_write_close();
    }

    function cirarSessao() {
        $this->estado = TRUE;
    }

    function salvarSessao() {
        session_start();
        $_SESSION[$this->nome] = $this;
        session_write_close();
    }

    function recuperarSessao() {
        $sessao = $_SESSION[$this->nome];
        $this->setUsuario($sessao->getUsuario());
        $this->setEstado($sessao->getEstado());
        $this->setConfiguracao($sessao->getConfiguracao());
    }

    function destruirSessao() {
        $this->setEstado(FALSE);
        session_start();
        session_destroy();
        session_write_close();
    }

    function getNome() {
        return $this->nome;
    }

    function getEstado() {
        return $this->estado;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getConfiguracao() {
        return $this->configuracao;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setConfiguracao($configuracao) {
        $this->configuracao = $configuracao;
    }

    function toString() {
        $string = "usuario=>{$this->usuario->toString()}";
        return $string;
    }

}
