<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\cadastros;

/**
 * Description of ServletContaContabil
 *
 * @author alex.bertolla
 */
use controle\cadastros\ManterContaContabil,
    visao\json\cadastros\ContaContabilJson,
    exception\Exception;

class ServletContaContabil {

    private $post;
    private $manterContaContabil;
    private $contaCotnabilJson;
    private $mensagem;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterContaContabil = new ManterContaContabil();
        $this->contaCotnabilJson = new ContaContabilJson();
        $this->mensagem = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "inserir":
                case "alterar":
                case "excluir":
                    $this->manterContaContabil->setAtributos($this->post);
                    $this->salvar($this->post->opcao);
                    break;
                case "listar":
                    $this->listar();
                    break;

                case "listarAtivas":
                    $this->listarAtivas();
                    break;

                case "listarPorNome":
                    $this->listarPorNome($this->post->nome);
                    break;

                case "listarPorNome":
                    $this->listarPorNome($this->post->nome);
                    break;

                case "buscarPorId":
                    $this->buscarPorId($this->post->id);
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function salvar($opcao) {
        $operacao = $this->manterContaContabil->salvar($opcao);
        $this->manterContaContabil->bdToForm();
        $mensagem = $this->mensagem->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->contaCotnabilJson->retornoJson($this->manterContaContabil->getContaContabil()));
    }

    private function listar() {
        $listaContaContabil = $this->manterContaContabil->listar();
        $mensagem = $this->mensagem->mensagemOperacao($listaContaContabil);
        $this->imprimeRetorno($mensagem, $this->contaCotnabilJson->retornoListaJson($listaContaContabil));
    }

    private function listarAtivas() {
        $listaContaContabil = $this->manterContaContabil->listarAtivas();
        $mensagem = $this->mensagem->mensagemOperacao($listaContaContabil);
        $this->imprimeRetorno($mensagem, $this->contaCotnabilJson->retornoListaJson($listaContaContabil));
    }

    private function listarPorNome($nome) {
        $listaContaContabil = $this->manterContaContabil->listarPorNome($nome);
        $mensagem = $this->mensagem->mensagemOperacao($listaContaContabil);
        $this->imprimeRetorno($mensagem, $this->contaCotnabilJson->retornoListaJson($listaContaContabil));
    }

    private function buscarPorId($id) {
        $contaContabil = $this->manterContaContabil->buscarPorId($id);
        $mensagem = $this->mensagem->mensagemOperacao($contaContabil);
        $this->imprimeRetorno($mensagem, $this->contaCotnabilJson->retornoJson($contaContabil));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->contaCotnabilJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->contaCotnabilJson, $this->manterContaContabil, $this->mensagem, $this->post);
    }

}

$servlet = new ServletContaContabil();
$servlet->switchOpcao();
unset($servlet);
