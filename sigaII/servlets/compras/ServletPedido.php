<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ServletPedido
 *
 * @author alex.bertolla
 */

namespace servlets\compras;

use controle\compras\ManterPedido,
    visao\json\compras\PedidoJson,
    exception\Exception;

class ServletPedido {

    private $manterPedido;
    private $exeption;
    private $pedidoJson;
    private $post;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterPedido = new ManterPedido();
        $this->exeption = new Exception();
        $this->pedidoJson = new PedidoJson();
    }

    function switchOpcao() {
        try {


            switch ($this->post->opcao) {
                case "inserir":
                case "alterar":
                case "excluir":
                    $this->manterPedido->setAtributos($this->post);
                    $this->salvar($this->post->opcao);
                    break;

                case "encaminharParaChefia":
                    $this->encaminharParaChefia($this->post->id);
                    break;
                case "listarPorSolicitante":
                    $this->listarPorSolicitante($this->post->matriculaSolicitante);
                    break;
                case "buscarPorId":
                    $this->buscarPorId($this->post->id);
                    break;
                case "buscarPorNumero":
                    $this->buscarPorNumero($this->post->numero);
                    break;
                default :
                    $mensagem = $this->exeption->setMensagemException("OPÇÃO [{$this->post->opcao}] INVÁLIDA!");
                    $this->imprimeRetorno($mensagem, NULL);
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exeption->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }
    
    private function listarPorProcessoDeCompra($processoCompraId){
        
    }

    private function listarPorSolicitante($matriculaSolicitante) {
        $listaPedido = $this->manterPedido->listarlistarPedidoPorSolicitante($matriculaSolicitante);
        $mensagem = $this->exeption->mensagemOperacao($listaPedido);
        $this->imprimeRetorno($mensagem, $this->pedidoJson->retornoListaJson($listaPedido));
    }

    private function buscarPorId($id) {
        $pedido = $this->manterPedido->buscarPorId($id);
        $mensagem = $this->exeption->mensagemOperacao($pedido);
        $this->imprimeRetorno($mensagem, $this->pedidoJson->retornoJson($pedido));
    }

    private function buscarPorNumero($numero) {
        $pedido = $this->manterPedido->buscarPorNumero($numero);
        $mensagem = $this->exeption->mensagemOperacao($pedido);
        $this->imprimeRetorno($mensagem, $this->pedidoJson->retornoJson($pedido));
    }

    private function encaminharParaChefia($id) {
        $this->manterPedido->buscarPorId($id);
        $operacao = $this->manterPedido->encaminharParaChefia();
        $this->manterPedido->gerarAitvidadePedido();
        $this->manterPedido->enviarEmail();
        $mensagem = $this->exeption->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->pedidoJson->retornoJson($this->manterPedido->getPedido()));
    }

    private function salvar($opcao) {
        $operacao = $this->manterPedido->salvar($opcao);
        $mensagem = $this->exeption->mensagemCadastro($operacao);
        $id = $this->manterPedido->getPedido()->getId();
        $this->imprimeRetorno($mensagem, $this->pedidoJson->retornoJson($this->manterPedido->buscarPorId($id)));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->pedidoJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

}

$servlet = new ServletPedido();
$servlet->switchOpcao();
