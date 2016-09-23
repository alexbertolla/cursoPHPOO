<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\compras;

use controle\compras\ManterItemProcessoCompra,
    visao\json\compras\ItemProcessoCompraJson,
    exception\Exception,
    ArrayObject;

/**
 * Description of ServletItemProcessoCompra
 *
 * @author alex.bertolla
 */
class ServletItemProcessoCompra {

    private $manterItemProcessoCompra;
    private $itemProcessoCompraJson;
    private $exception;
    private $post;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterItemProcessoCompra = new ManterItemProcessoCompra();
        $this->exception = new Exception();
        $this->itemProcessoCompraJson = new ItemProcessoCompraJson();
    }

    function switchOpcao() {
        try {


            switch ($this->post->opcao) {
                case "inserir":
                case "excluir";
                    $this->manterItemProcessoCompra->setAtributos($this->post);
                    $this->salvar($this->post->opcao);
                    break;
                case 'buscarItemJaCadastrado':
                    $this->buscarItemJaCadastrado($this->post->pedidoId, $this->post->itemId);
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function salvar($opcao) {
        $operacao = $this->manterItemProcessoCompra->salvar($opcao);
        $mensagem = $this->exception->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->itemProcessoCompraJson->retornoJson($this->manterItemProcessoCompra->getItemProcessoCompra()));
    }

    private function buscarItemJaCadastrado($pedidoId, $itemId) {
        $itemCadastrado = $this->manterItemProcessoCompra->buscarItemJaCadastrado($pedidoId, $itemId);
        if ($itemCadastrado) {
        throw new \Exception('Item já cadasrtado em processo de compra!' . $itemCadastrado);
        }
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->itemProcessoCompraJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->exception, $this->manterItemProcessoCompra, $this->post);
    }

}

$servlet = new ServletItemProcessoCompra();
$servlet->switchOpcao();
exit;
