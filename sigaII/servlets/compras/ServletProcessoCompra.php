<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\compras;

use controle\compras\ManterProcessoCompra,
    visao\json\compras\ProcessoCompraJson,
    exception\Exception;

/**
 * Description of ServletProcessoCompra
 *
 * @author alex.bertolla
 */
class ServletProcessoCompra {

    private $manterProcessoCompra;
    private $post;
    private $exception;
    private $processoCompraJson;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterProcessoCompra = new ManterProcessoCompra();
        $this->exception = new Exception();
        $this->processoCompraJson = new ProcessoCompraJson();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "inserir":
                case "alterar":
                case "excluir":
                case "bloquear":
                case "consolidar":
                case "encerrar":
                    $this->manterProcessoCompra->setAtributos($this->post);
                    $this->salvar($this->post->opcao);
                    break;
                case "listar":
                    $this->listar();
                    break;
                case "buscarPorId":
                    $this->buscarPorId($this->post->id);
                    break;
                case "buscarPorNumero":
                    $this->buscarPorNumero($this->post->numero);
                    break;
                case "buscarConsolidadoPorId":
                    $this->buscarConsolidadoPorId($this->post->id);
                    break;

                case "gerarNovoLote":
                    $this->manterProcessoCompra->setAtributos($this->post);
                    $this->gerarNovoLote();
                    break;
                case "removerItemDoLote":
                    $this->removerItemDoLote($this->post->loteId, $this->post->id, $this->post->itemId);
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function gerarNovoLote() {
        $this->manterProcessoCompra->gerarLote();
        $this->buscarPorId($this->manterProcessoCompra->getProcessoCompra()->getId());
    }

    function removerItemDoLote($loteId, $id, $itemId) {
        $this->manterProcessoCompra->removerItemDoLote($loteId, $id, $itemId);
        $this->buscarPorId($id);
    }

    private function buscarConsolidadoPorId($id) {
        $processoCompra = $this->manterProcessoCompra->buscarConsolidadoPorId($id);
        $mensagem = $this->exception->mensagemOperacao($processoCompra);
        $this->imprimeRetorno($mensagem, $this->processoCompraJson->retornoJson($processoCompra));
    }

    private function buscarPorId($id) {
        $processoCompra = $this->manterProcessoCompra->buscarPorId($id);
        $this->manterProcessoCompra->setDadosProcesso();
        $mensagem = $this->exception->mensagemOperacao($processoCompra);
        $this->imprimeRetorno($mensagem, $this->processoCompraJson->retornoJson($processoCompra));
    }

    private function buscarPorNumero($numero) {
        $processoCompra = $this->manterProcessoCompra->buscarPorNumero($numero);
        $this->manterProcessoCompra->setDadosProcesso();
        $mensagem = $this->exception->mensagemOperacao($processoCompra);
        $this->imprimeRetorno($mensagem, $this->processoCompraJson->retornoJson($processoCompra));
    }

    private function listar() {
        $listaProcessoCompra = $this->manterProcessoCompra->listar();
        $this->manterProcessoCompra->setDadosListaProcesso($listaProcessoCompra);
        $mensagem = $this->exception->mensagemOperacao($listaProcessoCompra);
        $this->imprimeRetorno($mensagem, $this->processoCompraJson->retornoListaJson($listaProcessoCompra));
    }

    private function salvar($opcao) {
        $operacao = $this->manterProcessoCompra->salvar($opcao);
        $mensagem = $this->exception->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->processoCompraJson->retornoJson($this->manterProcessoCompra->getProcessoCompra()));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->processoCompraJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->manterProcessoCompra, $this->exception, $this->processoCompraJson, $this->post);
    }

}

$servlet = new ServletProcessoCompra();
$servlet->switchOpcao();
