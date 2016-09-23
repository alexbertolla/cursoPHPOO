<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\configuracao;

use controle\configuracao\ManterDadosUnidade,
    visao\json\configuracao\DadosUnidadeJson,
    exception\Exception;

/**
 * Description of ServleDadosUnidade
 *
 * @author alex.bertolla
 */
class ServleDadosUnidade {

    private $post;
    private $manterDadosUnidade;
    private $dadosUnidadeJson;
    private $exception;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterDadosUnidade = new ManterDadosUnidade();
        $this->dadosUnidadeJson = new DadosUnidadeJson();
        $this->exception = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "salvarDadosUnidade":
                    $this->manterDadosUnidade->setAtributos($this->post);
                    $this->salvarDadosUnidade();
                    break;

                case "buscarDadosUnidade":
                    $this->buscarDadosUnidade();
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function salvarDadosUnidade() {
        $operacao = $this->manterDadosUnidade->salvarDadosUnidade();
        $mensagem = $this->exception->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->dadosUnidadeJson->retornoJson($this->manterDadosUnidade->getDadosUnidade()));
    }

    private function buscarDadosUnidade() {
        $dadosUnidade = $this->manterDadosUnidade->buscarDadosUnidade();
        $mensagem = $this->exception->mensagemOperacao($dadosUnidade);
        $this->imprimeRetorno($mensagem, $this->dadosUnidadeJson->retornoJson($dadosUnidade));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->dadosUnidadeJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

}

$servlet = new ServleDadosUnidade();
$servlet->switchOpcao();
unset($servlet);
exit();
