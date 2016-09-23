<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\compras;

use controle\compras\ManterPedidoSPS,
    visao\json\compras\PedidoSPSJson,
    exception\Exception;

/**
 * Description of ServletPedidoSPS
 *
 * @author alex.bertolla
 */
class ServletPedidoSPS {

    private $ManterpedidoSPS;
    private $pedidoSPSJson;
    private $exception;
    private $post;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->ManterpedidoSPS = new ManterPedidoSPS();
        $this->pedidoSPSJson = new PedidoSPSJson();
        $this->exception = new Exception();
    }

    function switchOpcao() {
        try {


            switch ($this->post->opcao) {
                case "receberPedido":
                    $this->ManterpedidoSPS->setAtributos($this->post);
                    $this->receberPedido();
                    break;
                case "listarPedidosAReceber":
                    $this->listarPedidosAReceber();
                    break;
                case "listarPedidosRecebido":
                    $this->listarPedidosRecebido();
                    break;
                case "buscarPedidoRecebidoPorNumeroAno":
                    $this->buscarPedidoRecebidoPorNumeroAno($this->post->numero, $this->post->ano);
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function receberPedido() {
        $operacao = $this->ManterpedidoSPS->receberPedido();
        $this->ManterpedidoSPS->gerarAtividadePedido();
        $this->ManterpedidoSPS->enviarEmail();
        $mensagem = $this->exception->mensagemOperacao($operacao);
        $this->imprimeRetorno($mensagem, $this->pedidoSPSJson->retornoJson($this->ManterpedidoSPS->getPedidoSPS()->getPedido()));
    }

    private function buscarPedidoRecebidoPorNumeroAno($numero, $ano) {
        $pedidoSPS = $this->ManterpedidoSPS->buscarPedidoRecebidoPorNumeroAno($numero, $ano);
        $mensagem = $this->exception->mensagemOperacao($pedidoSPS);
        $this->imprimeRetorno($mensagem, $this->pedidoSPSJson->retornoJson($pedidoSPS));
    }

    private function listarPedidosAReceber() {
        $listaPedidoSPS = $this->ManterpedidoSPS->listarPedidoAReceber();
        $mensagem = $this->exception->mensagemOperacao($listaPedidoSPS);
        $this->imprimeRetorno($mensagem, $this->pedidoSPSJson->retornoListaJson($listaPedidoSPS));
    }

    private function listarPedidosRecebido() {
        $listaPedidoSPS = $this->ManterpedidoSPS->listarPedidosRecebido();
        $mensagem = $this->exception->mensagemOperacao($listaPedidoSPS);
        $this->imprimeRetorno($mensagem, $this->pedidoSPSJson->retornoListaJson($listaPedidoSPS));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->pedidoSPSJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->ManterpedidoSPS, $this->exception, $this->pedidoSPSJson, $this->post);
    }

}

$servlet = new ServletPedidoSPS();
$servlet->switchOpcao();
