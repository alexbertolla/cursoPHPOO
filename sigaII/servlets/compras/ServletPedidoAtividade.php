<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\compras;

use controle\compras\GerarPedidoAtividade,
    visao\json\compras\PedidoAtividadeJson,
    exception\Exception;

/**
 * Description of ServletPedidoAtividade
 *
 * @author alex.bertolla
 */
class ServletPedidoAtividade {

    private $post;
    private $gerarPedidoAtividade;
    private $pedidoAtividadeJson;
    private $exception;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->gerarPedidoAtividade = new GerarPedidoAtividade();
        $this->pedidoAtividadeJson = new PedidoAtividadeJson();
        $this->exception = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "listarPorPedido":
                    $this->listarPorPedido($this->post->pedidoId);
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function listarPorPedido($pedidoId) {
        $listaPedidoAtividade = $this->gerarPedidoAtividade->listarAtividadePorPedido($pedidoId);
        $mensagem = $this->exception->mensagemOperacao($listaPedidoAtividade);
        $this->imprimeRetorno($mensagem, $this->pedidoAtividadeJson->retornoListaJson($listaPedidoAtividade));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->pedidoAtividadeJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->exception, $this->gerarPedidoAtividade, $this->pedidoAtividadeJson, $this->post);
    }

}

$servletPedidoAtividade = new ServletPedidoAtividade();
$servletPedidoAtividade->switchOpcao();
