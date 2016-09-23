<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\cadastros;

use controle\cadastros\ManterNaturezaOperacao,
    visao\json\cadastros\NaturezaOperacaoJson,
    exception\Exception;

/**
 * Description of ServletNaturezaOperacao
 *
 * @author alex.bertolla
 */
class ServletNaturezaOperacao {

    private $manterNaturezaOperacao;
    private $naturezaOperacaoJson;
    private $exception;
    private $post;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);

        $this->manterNaturezaOperacao = new ManterNaturezaOperacao();
        $this->naturezaOperacaoJson = new NaturezaOperacaoJson();
        $this->exception = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "inserir":
                case "alterar":
                case "excluir":
                    $this->manterNaturezaOperacao->setAtributos($this->post);
                    $this->salvar($this->post->opcao);
                    break;
                case "listar":
                    $this->listar();
                    break;
                case "buscarPorId":
                    $this->buscarPorId($this->post->id);
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function salvar($opcao) {
        $operacao = $this->manterNaturezaOperacao->salvar($opcao);
        $mensagem = $this->exception->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->naturezaOperacaoJson->retornoJson($this->manterNaturezaOperacao->getNaturezaOperacao()));
    }

    private function listar() {
        $listaNaturezaOperacao = $this->manterNaturezaOperacao->listar();
        $mensagem = $this->exception->mensagemCadastro($listaNaturezaOperacao);
        $this->imprimeRetorno($mensagem, $this->naturezaOperacaoJson->retornoListaJson($listaNaturezaOperacao));
    }

    private function buscarPorId($id) {
        $naturezaOperacao = $this->manterNaturezaOperacao->buscarPorId($id);
        $mensagem = $this->exception->mensagemCadastro($naturezaOperacao);
        $this->imprimeRetorno($mensagem, $this->naturezaOperacaoJson->retornoJson($naturezaOperacao));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->naturezaOperacaoJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->exception, $this->manterNaturezaOperacao, $this->naturezaOperacaoJson, $this->post);
    }

}

$servletNaturezaOperacao = new ServletNaturezaOperacao();
$servletNaturezaOperacao->switchOpcao();
unset($servletNaturezaOperacao);
