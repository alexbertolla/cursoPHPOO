<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\compras;

use controle\compras\ManterOrdemDeCompra,
    visao\json\compras\OrdemDeCompraJson,
    exception\Exception;

/**
 * Description of ServletOrdemDeCompra
 *
 * @author alex.bertolla
 */
class ServletOrdemDeCompra {

    private $post;
    private $manterOrdemDeCompra;
    private $ordemDeCompraJson;
    private $exception;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterOrdemDeCompra = new ManterOrdemDeCompra();
        $this->ordemDeCompraJson = new OrdemDeCompraJson();
        $this->exception = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "listarAgrupadasPorFornecedor":
                    $this->listarAgrupadasPorFornecedor($this->post->processoCompraId);
                    break;
                case "buscarPorId":
                    $this->buscarPorId($this->post->id);
                    break;

                case "buscarPorNumeroESequencia":
                    $this->buscarPorNumeroESequencia($this->post->numero, $this->post->sequencia);
                    break;

                case "listarPorNumero":
                    $this->listarPorNumero($this->post->numero);
                    break;

                case "listaPorFornecedor":
                    $this->listarPorFornecedor($this->post->processoCompraId, $this->post->fornecedorId);
                    break;

                case "efetivarEmissao":
                    $this->manterOrdemDeCompra->setAtributos($this->post);
                    $this->efetivarEmissao();
                    break;

                case "assinaturaFornecedor":
                    $this->manterOrdemDeCompra->setAtributos($this->post);
                    $this->assinaturaFornecedor();
                    break;

                case "atualizarPrazo":
                    $this->manterOrdemDeCompra->setAtributos($this->post);
                    $this->atualizarPrazo();
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function atualizarPrazo() {
        $opecao = $this->manterOrdemDeCompra->atualizarPrazo();
        $mensagem = $this->exception->mensagemOperacao($opecao);
        $this->imprimeRetorno($mensagem, $this->ordemDeCompraJson->retornoJson($this->manterOrdemDeCompra->getOrdemDeCompra()));
    }

    private function assinaturaFornecedor() {
        $opecao = $this->manterOrdemDeCompra->assinaturaFornecedor();
        $mensagem = $this->exception->mensagemOperacao($opecao);
        $this->imprimeRetorno($mensagem, $this->ordemDeCompraJson->retornoJson($this->manterOrdemDeCompra->getOrdemDeCompra()));
    }

    private function efetivarEmissao() {
        $this->setListaItemOrdemDeCompra();
        $operacao = $this->manterOrdemDeCompra->efetivarEmissao();
        $mensagem = $this->exception->mensagemOperacao($operacao);
        $this->manterOrdemDeCompra->buscarPorId($this->post->id);
        $this->manterOrdemDeCompra->verificaGerarNovaSequencia();
        $this->manterOrdemDeCompra->atualizarSituacaoItemPedido();
        $this->imprimeRetorno($mensagem, $this->ordemDeCompraJson->retornoJson($this->manterOrdemDeCompra->getOrdemDeCompra()));
    }

    private function setListaItemOrdemDeCompra() {
        $listaItemOrdemDeCompra = (object) $this->post->listaItemOrdemCompra;
        $setListaItem = FALSE;
        foreach ($listaItemOrdemDeCompra as $item) {
            $atributos = (object) $item;
            $setListaItem = $this->manterOrdemDeCompra->setAtributosItemOrdemDeCompra($atributos);
        }
        return $setListaItem;
    }

    private function listarPorFornecedor($processoCompraId, $fornecedorId) {
        $listaOrdemDeCompra = $this->manterOrdemDeCompra->listarPorFornecedorId($processoCompraId, $fornecedorId);
        $this->manterOrdemDeCompra->setDadosListaOrdemDeCompra($listaOrdemDeCompra);
        $mensagem = $this->exception->mensagemOperacao($listaOrdemDeCompra);
        $this->imprimeRetorno($mensagem, $this->ordemDeCompraJson->retornoListaJson($listaOrdemDeCompra));
    }

    private function listarAgrupadasPorFornecedor($processoCompraId) {
        $listaOrdemDeCompra = $this->manterOrdemDeCompra->listarAgrupadasPorFornecedor($processoCompraId);
        $mensagem = $this->exception->mensagemOperacao($listaOrdemDeCompra);
        $this->imprimeRetorno($mensagem, $this->ordemDeCompraJson->retornoListaJson($listaOrdemDeCompra));
    }

    private function buscarPorId($id) {
        $ordemDeCompra = $this->manterOrdemDeCompra->buscarPorId($id);
        $mensagem = $this->exception->mensagemOperacao($ordemDeCompra);
        $this->imprimeRetorno($mensagem, $this->ordemDeCompraJson->retornoJson($ordemDeCompra));
    }

    private function buscarPorNumeroESequencia($numero, $sequencia) {
        $ordemDeCompra = $this->manterOrdemDeCompra->buscarPorNumeroESequencia($numero, $sequencia);
        $mensagem = $this->exception->mensagemOperacao($ordemDeCompra);
        $this->imprimeRetorno($mensagem, $this->ordemDeCompraJson->retornoJson($ordemDeCompra));
    }

    private function listarPorNumero($numero) {
        $listaOrdemDeCompra = $this->manterOrdemDeCompra->listarPorNumero($numero);
        $mensagem = $this->exception->mensagemOperacao($listaOrdemDeCompra);
        $this->imprimeRetorno($mensagem, $this->ordemDeCompraJson->retornoListaJson($listaOrdemDeCompra));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->ordemDeCompraJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

}

$sevletOrdemDeCompra = new ServletOrdemDeCompra();
$sevletOrdemDeCompra->switchOpcao();
