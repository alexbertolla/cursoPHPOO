<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\compras;

use controle\compras\GerenciarLoteProcessoCompra,
    visao\json\compras\LoteProcessoCompraJson,
    exception\Exception;

/**
 * Description of ServletLoteProcessoCompra
 *
 * @author alex.bertolla
 */
class ServletLoteProcessoCompra {

    private $post;
    private $gerenciarLote;
    private $loteJson;
    private $exception;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->gerenciarLote = new GerenciarLoteProcessoCompra();
        $this->loteJson = new LoteProcessoCompraJson();
        $this->exception = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "gerarNovoLote":
                    $this->gerarNovoLote($this->post->processoCompraId, $this->post->modalidadeId);
                    break;
                case "incluirItem":
                    $this->incluirItem($this->post->loteId, $this->post->processoCompraId, $this->post->itemId);
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function incluirItem($loteId, $processoCompraId, $itemId) {
        $this->gerenciarLote->alterarLoteItem($loteId, $processoCompraId, $itemId);
        $this->listarPorProcessoCompra($processoCompraId);
    }

    private function gerarNovoLote($processoCompraId, $modalidadeId) {
        $this->gerenciarLote->gerarLote($processoCompraId, $modalidadeId);
        $this->listarPorProcessoCompra($processoCompraId);
    }

    private function listarPorProcessoCompra($processoCompraId) {
        $listaLoteProcessoCompra = $this->gerenciarLote->listarPorProcessoCompra($processoCompraId);
        $this->gerenciarLote->setListaItensLoteConsolidado($listaLoteProcessoCompra);
        $mensagem = $this->exception->mensagemCadastro($listaLoteProcessoCompra);
        $this->imprimeRetorno($mensagem, $this->loteJson->retornoListaJson($listaLoteProcessoCompra));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->loteJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->exception, $this->gerenciarLote, $this->loteJson, $this->posts);
    }

}

$servletLote = new ServletLoteProcessoCompra();
$servletLote->switchOpcao();
