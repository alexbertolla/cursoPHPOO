<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\configuracao;

/**
 * Description of ServletItensDeCompra
 *
 * @author alex.bertolla
 */
use controle\configuracao\ManterItensDeCompra,
    visao\json\configuracao\ItensDeCompraJson,
    exception\Exception;

class ServletItensDeCompra {

    private $post;
    private $manterItensDeCompra;
    private $itensDeCompraJson;
    private $exception;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterItensDeCompra = new ManterItensDeCompra();
        $this->itensDeCompraJson = new ItensDeCompraJson();
        $this->exception = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "inserir":
                case "alterar":
                case "excluir":
                    $this->manterItensDeCompra->setAtributos($this->post);
                    $this->salvar($this->post->opcao);
                    break;

                case "listar":
                    $this->listar();
                    break;

                case "listarPorNome":
                    $this->listarPorNome($this->post->nome);
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function salvar($opcao) {
        $operacao = $this->manterItensDeCompra->salvar($opcao);
        $this->manterItensDeCompra->bdToForm();
        $mensagem = $this->exception->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->itensDeCompraJson->retornoJson($this->manterItensDeCompra->getItensDeCompra()));
    }

    private function listar() {
        $lista = $this->manterItensDeCompra->listar();
        $mensagem = $this->exception->mensagemOperacao($lista);
        $this->imprimeRetorno($mensagem, $this->itensDeCompraJson->retornoListaJson($lista));
    }

    private function listarPorNome($nome) {
        $lista = $this->manterItensDeCompra->listarPorNome($nome);
        $mensagem = $this->exception->mensagemOperacao($lista);
        $this->imprimeRetorno($mensagem, $this->itensDeCompraJson->retornoListaJson($lista));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->itensDeCompraJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->exception, $this->itensDeCompraJson, $this->manterItensDeCompra, $this->post);
    }

}

$servlet = new ServletItensDeCompra();
$servlet->switchOpcao();
unset($servlet);
