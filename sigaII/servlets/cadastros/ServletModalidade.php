<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\cadastros;

use controle\cadastros\ManterModalidade,
    visao\json\cadastros\ModalidadeJson,
    exception\Exception;

/**
 * Description of ServletModalidade
 *
 * @author alex.bertolla
 */
class ServletModalidade {

    private $manterModalidade;
    private $modalidadeJson;
    private $exception;
    private $post;

    public function __construct() {
        include_once '../../autoload.php';
        $this->manterModalidade = new ManterModalidade();
        $this->modalidadeJson = new ModalidadeJson();
        $this->exception = new Exception();
        $this->post = (object) filter_input_array(INPUT_POST);
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "inserir":
                case "alterar":
                case "excluir":
                    $this->manterModalidade->setAtributos($this->post);
                    $this->salvar($this->post->opcao);
                    break;
                case "listar":
                    $this->listar();
                    break;
                case "listarPorNome":
                    $this->listarPorNome($this->post->nome);
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function salvar($opcao) {
        $operacao = $this->manterModalidade->salvar($opcao);
        $this->manterModalidade->bdToForm();
        $mensagem = $this->exception->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->modalidadeJson->retornoJson($this->manterModalidade->getModalidade()));
    }

    private function listar() {
        $listaModalidade = $this->manterModalidade->listar();
        $mensagem = $this->exception->mensagemOperacao($listaModalidade);
        $this->imprimeRetorno($mensagem, $this->modalidadeJson->retornoListaJson($listaModalidade));
    }

    private function listarPorNome($nome) {
        $listaModalidade = $this->manterModalidade->listarPorNome($nome);
        $mensagem = $this->exception->mensagemOperacao($listaModalidade);
        $this->imprimeRetorno($mensagem, $this->modalidadeJson->retornoListaJson($listaModalidade));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->modalidadeJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->post, $this->manterModalidade, $this->modalidadeJson, $this->exception);
    }

}

$sevlet = new ServletModalidade();
$sevlet->switchOpcao();
