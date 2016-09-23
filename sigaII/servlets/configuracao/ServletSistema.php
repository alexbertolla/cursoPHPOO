<?php

namespace servlets\configuracao;

use controle\configuracao\SistemaControle,
    visao\json\configuracao\SistemaJson,
    exception\Exception;

class ServletSistema {

    private $post;
    private $sistemaControle;
    private $sistemaJson;
    private $mensagem;

    public function __construct() {
        include_once '../../autoload.php';
        $this->sistemaControle = new SistemaControle();
        $this->sistemaJson = new SistemaJson();
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->mensagem = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "inserir":
                case "alterar":
                    $this->salvarConfiguracao();
                    break;
                case "buscar":
                    $this->buscar();
                    break;
                default :
                    $retornoJson = $this->sistemaJson->formataRetornoJson("sucesso", "opção [{$this->post->opcao}] inválida", $this->sistemaJson->retornoJson(NULL));
                    $this->imprimeSaida($retornoJson);
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function salvarConfiguracao() {
        $this->sistemaControle->setAtributos($this->post);
        $operacao = $this->sistemaControle->salvar($this->post->opcao);
        $mensagem = $this->mensagem->mensagemOperacao($operacao);
        $retornoJson = $this->sistemaJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $this->sistemaJson->retornoJson($this->sistemaControle->getSistema()));
        $this->imprimeSaida($retornoJson);
    }

    private function buscar() {
        $sistema = $this->sistemaControle->buscarInfoSistema();
        $mensagem = $this->mensagem->mensagemOperacao($sistema);
        $retornoJson = $this->sistemaJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $this->sistemaJson->retornoJson($sistema));
        $this->imprimeSaida($retornoJson);
    }

    private function imprimeSaida($retornoJson) {
        header('Content-Type: application/json');
        echo json_encode($retornoJson);
    }

}

$servletSistema = new ServletSistema();
$servletSistema->switchOpcao();
unset($servletSistema);
