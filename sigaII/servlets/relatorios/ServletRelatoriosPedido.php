<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ServletRelatoriosPedido
 *
 * @author alex.bertolla
 */

namespace servlets\relatorios;

use controle\relatorios\GerarRelatoriosPedido,
    visao\json\compras\PedidoJson,
    exception\Exception;

class ServletRelatoriosPedido {

    private $post;
    private $relatorioPedido;
    private $exception;
    private $pedidoJson;

    public function __construct() {
        include_once '../../autoload.php';

        $this->post = (object) filter_input_array(INPUT_POST);
        $this->relatorioPedido = new GerarRelatoriosPedido();
        $this->pedidoJson = new PedidoJson();
        $this->exception = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "pedidoDetalhado":
                    $this->pedidoDetalhado($this->post->id);
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function pedidoDetalhado($id) {
        $pedido = $this->relatorioPedido->pedidoDetalhado($id);
        $mensagem = $this->exception->mensagemOperacao($pedido);
        $this->imprimeRetorno($mensagem, $this->pedidoJson->retornoJson($pedido));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->pedidoJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

}

$servlet = new ServletRelatoriosPedido();
$servlet->switchOpcao();
