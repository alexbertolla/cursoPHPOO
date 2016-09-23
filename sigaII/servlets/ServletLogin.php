<?php

namespace servlets;

use configuracao\GerenciarLogin,
    controle\configuracao\SistemaControle,
    visao\json\UsuarioJson,
    visao\json\configuracao\SessaoJson,
    visao\json\LoginJson,
    exception\Exception;

class ServletLogin {

    private $gerenciarLogin;
    private $post;
    private $sistemaConfiguracao;
    private $mensagemControle;

    public function __construct() {
        include_once '../autoload.php';
        $this->gerenciarLogin = new GerenciarLogin();
        $this->sistemaConfiguracao = new SistemaControle();
        $this->mensagemControle = new Exception();
        $this->post = (object) filter_input_array(INPUT_POST);
    }

    public function __destruct() {
        unset($this->gerenciarLogin);
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "efetuarLogin":
                    $this->efetuarLogin();
                    break;
                case "buscarSessao":
                    $this->buscarSessao();
                    break;
                case "efetuarLogof":
                    $this->efetuarLogOff();
                    break;
                default :
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function verificaSistemaLiberado() {
        $sistema = $this->sistemaConfiguracao->buscarInfoSistema();
        return $sistema->getLiberado();
    }

    private function efetuarLogin() {
        $usuarioLogado = $this->gerenciarLogin->logar($this->post->usuario, $this->post->senha, $this->post->sistema);
        $mensagem = $this->mensagemControle->mensagemLogin($usuarioLogado);
        $usuarioJson = new UsuarioJson();
        $retornoJson = $usuarioJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $usuarioJson->retornoJson($usuarioLogado));
        $this->imprimeRetorno($retornoJson);
    }

    private function efetuarLogOff() {
        $this->gerenciarLogin->logOff();
        $sessaoJSON = new SessaoJson();
        $retornoJson = $sessaoJSON->formataRetornoJson("sucesso", "logoff", NULL);
        $this->imprimeRetorno($retornoJson);
    }

    private function buscarSessao() {
        $sessao = $this->gerenciarLogin->recuperarSessao();
        $mensagem = $this->mensagemControle->mensagemSessao($sessao);
        $sessaoJSON = new SessaoJson();
        $retornoJson = $sessaoJSON->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $sessaoJSON->retornoJson($sessao));
        $this->imprimeRetorno($retornoJson);
    }

    private function imprimeRetorno($retornoJson) {
        header('Content-Type: application/json');
        echo json_encode($retornoJson);
    }

}

$servletLogin = new ServletLogin();
$servletLogin->switchOpcao();
unset($servletLogin);
