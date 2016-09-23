<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\compras;

use controle\compras\AutorizarPedido,
    visao\json\compras\PedidoChefiaAutorizacaoJson,
    exception\Exception;

/**
 * Description of ServletPedidoChefiaAutorizacao
 *
 * @author alex.bertolla
 */
class ServletPedidoChefiaAutorizacao {

    private $pedidoAutorizacao;
    private $pedidoAutorizacaoJson;
    private $exception;
    private $post;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->pedidoAutorizacao = new AutorizarPedido();
        $this->pedidoAutorizacaoJson = new PedidoChefiaAutorizacaoJson();
        $this->exception = new Exception();
    }

    function switchOption() {
        try {


            switch ($this->post->opcao) {
                case "listarPedidos":
                    $this->listarPedidos();
                    break;
                case "receberPedido":
                    $this->pedidoAutorizacao->setAtributos($this->post);
                    $this->receberPedido();
                    break;
                case "autorizarPedido":
                    $this->pedidoAutorizacao->setAtributos($this->post);
                    $this->autorizarPedido();
                    break;
                case "devolverPedido":
                    $this->pedidoAutorizacao->setAtributos($this->post);
                    $this->devolverPedido();
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function listarPedidos() {
        $lista = $this->pedidoAutorizacao->listarPedidosAberto();
        $mensagem = $this->exception->mensagemOperacao($lista);
        $this->imprimeRetorno($mensagem, $this->pedidoAutorizacaoJson->retornoListaJson($lista));
    }

    private function receberPedido() {
        $operacao = $this->pedidoAutorizacao->receberPedido();
        $this->pedidoAutorizacao->registrarAtividade();
        $this->pedidoAutorizacao->enviarEmail();
        $mensagem = $this->exception->mensagemOperacao($operacao);
        $this->imprimeRetorno($mensagem, $this->pedidoAutorizacaoJson->retornoJson($this->pedidoAutorizacao->getPedidoAutorizacao()));
    }

    private function autorizarPedido() {
        $operacao = $this->pedidoAutorizacao->autorizarPedido();
        $this->pedidoAutorizacao->registrarAtividade();
        $this->pedidoAutorizacao->enviarEmail();
        $mensagem = $this->exception->mensagemOperacao($operacao);
        $this->imprimeRetorno($mensagem, $this->pedidoAutorizacaoJson->retornoJson($this->pedidoAutorizacao->getPedidoAutorizacao()));
    }

    private function devolverPedido() {
        $operacao = $this->pedidoAutorizacao->devolverPedido();
        $this->pedidoAutorizacao->registrarAtividade();
        $this->pedidoAutorizacao->enviarEmail();
        $mensagem = $this->exception->mensagemOperacao($operacao);
        $this->imprimeRetorno($mensagem, $this->pedidoAutorizacaoJson->retornoJson($this->pedidoAutorizacao->getPedidoAutorizacao()));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->pedidoAutorizacaoJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->pedidoAutorizacao, $this->pedidoAutorizacao, $this->pedidoAutorizacaoJson, $this->post);
    }

}

$servlet = new ServletPedidoChefiaAutorizacao();
$servlet->switchOption();
