<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\compras;

use controle\compras\ManterSituacaoPedido,
    visao\json\compras\SituacaoPedidoJson,
    exception\Exception;

/**
 * Description of ServletSituacaoPedido
 *
 * @author alex.bertolla
 */
class ServletSituacaoPedido {

    private $post;
    private $manterSituacaoPedido;
    private $situacaoPedidoJson;
    private $exception;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterSituacaoPedido = new ManterSituacaoPedido();
        $this->situacaoPedidoJson = new SituacaoPedidoJson();
        $this->exception = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "salvar":
                    $this->manterSituacaoPedido->setAtributos($this->post);
                    $this->salvar();
                    break;
                case "listar":
                    $this->listar();
                    break;
                case "buscarPorId":
                    $this->buscarPorId($this->post->id);
                    break;
                case "buscarPorCodigo":
                    $this->buscarPorCodigo($this->post->codigo);
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function salvar() {
        $operacao = $this->manterSituacaoPedido->alterar();
        $mensagem = $this->exception->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->situacaoPedidoJson->retornoJson($this->manterSituacaoPedido->getSituacaoPedido()));
    }

    private function listar() {
        $listaSituacaoPedido = $this->manterSituacaoPedido->listar();
        $mensagem = $this->exception->mensagemCadastro($listaSituacaoPedido);
        $this->imprimeRetorno($mensagem, $this->situacaoPedidoJson->retornoListaJson($listaSituacaoPedido));
    }

    private function buscarPorId($id) {
        $situacaoPedido = $this->manterSituacaoPedido->buscarPorId($id);
        $mensagem = $this->exception->mensagemCadastro($situacaoPedido);
        $this->imprimeRetorno($mensagem, $this->situacaoPedidoJson->retornoJson($situacaoPedido));
    }

    private function buscarPorCodigo($codigo) {
        $situacaoPedido = $this->manterSituacaoPedido->buscarPorCodigo($codigo);
        $mensagem = $this->exception->mensagemCadastro($situacaoPedido);
        $this->imprimeRetorno($mensagem, $this->situacaoPedidoJson->retornoJson($situacaoPedido));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->situacaoPedidoJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->exception, $this->manterSituacaoPedido, $this->situacaoPedidoJson, $this->post);
    }

}

$servletSituacaoPedido = new ServletSituacaoPedido();
$servletSituacaoPedido->switchOpcao();
