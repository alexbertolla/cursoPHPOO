<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\compras;

use controle\compras\ManterItemPedido,
    visao\json\compras\ItemPedidoJson,
    exception\Exception,
    ArrayObject;

/**
 * Description of ServletItemPedido
 *
 * @author alex.bertolla
 */
class ServletItemPedido {

    private $manterItemPedido;
    private $itemPedidoJson;
    private $post;
    private $exeption;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterItemPedido = new ManterItemPedido($this->post->tipo);
        $this->itemPedidoJson = new ItemPedidoJson();
        $this->exeption = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "inserir":
                    $this->salvarItemPedido();
                    break;
                case "listarItemPedidoPorPedido":
                    $this->listarItemPedidoPorPedido($this->post->pedidoId);
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exeption->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function salvarItemPedido() {
        $listaItemPedido = $_POST["listaItemPedido"];
        $novaLista = new ArrayObject();
        $operacao = $this->manterItemPedido->excluir($this->post->pedidoId);
        if (count($listaItemPedido) > 0) {
            foreach ($listaItemPedido as $itemPedido) {
                $item = (object) $itemPedido;
                $this->manterItemPedido->setAtributos($item);
                $novaLista->append($this->manterItemPedido->getItemPedido());
                $operacao = $this->manterItemPedido->salvar("inserir");
            }
        }
        $mensagem = $this->exeption->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->itemPedidoJson->retornoListaJson($novaLista));
    }

    private function listarItemPedidoPorPedido($pedidoId) {
        $listaItemPedido = $this->manterItemPedido->listarItemPedidoPorPedido($pedidoId);
        $mensagem = $this->exeption->mensagemOperacao($listaItemPedido);
        $this->imprimeRetorno($mensagem, $this->itemPedidoJson->retornoListaJson($listaItemPedido));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->itemPedidoJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

}

$servlet = new ServletItemPedido();

$servlet->switchOpcao();
