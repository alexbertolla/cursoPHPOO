<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\cadastros;

/**
 * Description of ServletNaturezaDespesa
 *
 * @author alex.bertolla
 */
use controle\cadastros\ManterNaturezaDespesa,
    visao\json\cadastros\NaturezaDespesaJson,
    exception\Exception;

class ServletNaturezaDespesa {

    private $post;
    private $manterNaturezaDespesa;
    private $naturezaDespesaJson;
    private $mensagem;

    public function __construct() {
        include_once '../../autoload.php';
        $this->manterNaturezaDespesa = new ManterNaturezaDespesa();
        $this->naturezaDespesaJson = new NaturezaDespesaJson();
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->mensagem = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "inserir":
                case "alterar":
                case "excluir":
                    $this->manterNaturezaDespesa->setAtributos($this->post);
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
                case "listarPorNomeOuCodigo":
                    $this->listarPorNomeOuCodigo($this->post->nome);
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
        $operacao = $this->manterNaturezaDespesa->salvar($opcao);
        $mensagem = $this->mensagem->mensagemCadastro($operacao);
        $this->manterNaturezaDespesa->BDToForm();
        $this->imprimeRetorno($mensagem, $this->naturezaDespesaJson->retornoJson($this->manterNaturezaDespesa->getNd()));
    }

    private function listar() {
        $listaNaturezaDespesa = $this->manterNaturezaDespesa->listar();
        $mensagem = $this->mensagem->mensagemOperacao($listaNaturezaDespesa);
        $this->imprimeRetorno($mensagem, $this->naturezaDespesaJson->retornoListaJson($listaNaturezaDespesa));
    }

    private function listarAtivas() {
        $listaNaturezaDespesa = $this->manterNaturezaDespesa->listarAtivas();
        $mensagem = $this->mensagem->mensagemOperacao($listaNaturezaDespesa);
        $this->imprimeRetorno($mensagem, $this->naturezaDespesaJson->retornoListaJson($listaNaturezaDespesa));
    }

    private function listarPorNome($nome) {
        $listaNaturezaDespesa = $this->manterNaturezaDespesa->listarPorNome($nome);
        $mensagem = $this->mensagem->mensagemOperacao($listaNaturezaDespesa);
        $this->imprimeRetorno($mensagem, $this->naturezaDespesaJson->retornoListaJson($listaNaturezaDespesa));
    }

    private function listarPorNomeOuCodigo($pesquisa) {
        $listaNaturezaDespesa = $this->manterNaturezaDespesa->listarPorNomeOuCodigo($pesquisa);
        $mensagem = $this->mensagem->mensagemOperacao($listaNaturezaDespesa);
        $this->imprimeRetorno($mensagem, $this->naturezaDespesaJson->retornoListaJson($listaNaturezaDespesa));
    }

    private function buscarPorId($id) {
        $naturezaDespesa = $this->manterNaturezaDespesa->buscarPorId($id);
        $mensagem = $this->mensagem->mensagemOperacao($naturezaDespesa);
        $this->imprimeRetorno($mensagem, $this->naturezaDespesaJson->retornoJson($naturezaDespesa));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->naturezaDespesaJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->naturezaDespesaJson, $this->manterNaturezaDespesa, $this->post, $this->mensagem);
    }

}

$servlet = new ServletNaturezaDespesa();
$servlet->switchOpcao();
unset($servlet);
