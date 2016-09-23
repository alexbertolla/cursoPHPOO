<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\compras;

use controle\compras\RegistrarProposta,
    exception\Exception,
    visao\json\compras\PropostaJson,
    visao\json\compras\ItemPropostaJson,
    ArrayObject;

/**
 * Description of ServletProposta
 *
 * @author alex.bertolla
 */
class ServletProposta {

    private $manterProposta;
    private $propostaJson;
    private $post;
    private $exception;
    private $itemPropostaJson;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterProposta = new RegistrarProposta();
        $this->exception = new Exception();
        $this->propostaJson = new PropostaJson();
        $this->itemPropostaJson = new ItemPropostaJson();
    }

    function switchOpcao() {
        try {


            switch ($this->post->opcao) {
                case "inserir":
                    $this->manterProposta->setAtributos($this->post);
                    $this->salvar();
                    break;
                case "listarPorProcessoCompra":
                    $this->listarPorProcessoCompra($this->post->processoCompraId);
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function listarPorProcessoCompra($processoCompraId) {
        $listaProposta = $this->manterProposta->listarPorProcessoCompra($processoCompraId);
        $this->manterProposta->setDetalhesListaProposta($listaProposta);
        $mensagem = $this->exception->mensagemCadastro($listaProposta);
        $this->imprimeRetorno($mensagem, $this->propostaJson->retornoListaJson($listaProposta));
    }

    private function salvar() {
        $operacao = $this->manterProposta->salvarProposta();
        $this->manterProposta->setDetalhesListaItensProposta($this->manterProposta->getProposta()->getListaItemProposta());
        $mensagem = $this->exception->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->propostaJson->retornoJson($this->manterProposta->getProposta()));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->propostaJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->exception, $this->manterProposta, $this->post, $this->propostaJson);
    }

}

$servlet = new ServletProposta();
$servlet->switchOpcao();
