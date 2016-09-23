<?php

namespace configuracao;

use webservices\WSlogin,
    configuracao\Usuario,
    configuracao\Sessao,
    controle\configuracao\GerenciarLog,
    controle\configuracao\SistemaControle;

class GerenciarLogin {

    private $wsLogin;
    private $usuario;
    private $gerenciarLog;
    private $sistemaControle;

    public function __construct() {
        $this->gerenciarLog = new GerenciarLog();
        $this->sistemaControle = new SistemaControle();
    }

    private function setDadosUsuario($usuarioLogado) {
        $this->usuario = new Usuario();
        $this->usuario->setNomeUsuario($usuarioLogado->usuario);
        $this->usuario->setIdPerfil($usuarioLogado->idPerfil);
        $this->usuario->setNomePerfil($usuarioLogado->nomePerfil);
        $this->usuario->setDadosFuncional($this->usuario->buscarPorMatricula($usuarioLogado->matricula));
    }

    private function criarSessao() {
        $sessao = new Sessao();
        $sessao->setUsuario($this->usuario);
        $configuracaoSistema = $this->sistemaControle->buscarInfoSistema();
        $sessao->setConfiguracao($configuracaoSistema);
        $sessao->salvarSessao();
        $this->gerenciarLog->registarLog("login", "entrar no sistema", $sessao->toString());
    }

    function logar($usuario, $senha, $sistema) {
        $this->wsLogin = new WSlogin();
        $usuarioLogado = $this->wsLogin->autenticar($usuario, $senha, $sistema);

        if ($usuarioLogado["estado"]) {
            $this->setDadosUsuario($usuarioLogado["usuario"]);
            $this->criarSessao();
            unset($this->wsLogin);
            return $this->usuario;
        } else {
//            $this->gerenciarLog->registarLog("login", "usuario ou senha invalido", "");
            return FALSE;
        }
    }

    function logOff() {
        $sessao = new Sessao();
        $this->gerenciarLog->registarLog("logoff", "saiu do sistema", "");
        $sessao->destruirSessao();
    }

    function recuperarSessao() {
        $sessao = new Sessao();
        if (is_null($sessao->getUsuario())) {
            $this->gerenciarLog->registarLog("logoff", "Sessão expirou", "");
            return NULL;
        } else {
            return $sessao;
        }
    }

    public function __destruct() {
        unset($this->wsLogin, $this->usuario);
    }

}
