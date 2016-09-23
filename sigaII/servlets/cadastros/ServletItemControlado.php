<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\cadastros;

/**
 * Description of ServletItemControlado
 *
 * @author alex.bertolla
 */
use controle\cadastros\ManterItemControlado,
    visao\json\cadastros\ItemControladoJson,
    exception\Exception;

class ServletItemControlado {

    private $post;
    private $manterItemControlado;
    private $itemControladoJson;
    private $mensagem;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterItemControlado = new ManterItemControlado();
        $this->itemControladoJson = new ItemControladoJson();
        $this->mensagem = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "inserir":
                case "alterar":
                case "excluir":
                    $this->manterItemControlado->setAtributos($this->post);
                    $this->salvar($this->post->opcao);
                    break;

                case "listar":
                    $this->listar();
                    break;
                case "listarPorGrupoAtivo":
                    $this->listarPorGrupoAtivo($this->post->grupoId);
                    break;
                case "listarPorNome":
                    $this->listarPorNome($this->post->nome);
                    break;
                case "listarPorGrupoEOrgaoControlador":
                    $this->listarPorGrupoEOrgaoControlador($this->post->grupoId, $this->post->orgaoControladorId);
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
        $operacao = $this->manterItemControlado->salvar($opcao);
        $this->manterItemControlado->bdToForm();
        $mensagem = $this->mensagem->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->itemControladoJson->retornoJson($this->manterItemControlado->getItemControlado()));
    }

    private function listar() {
        $listaItemControlado = $this->manterItemControlado->listar();
//        var_dump($listaItemControlado);
        $this->manterItemControlado->setDadosListaItensControlados($listaItemControlado);
        $mensagem = $this->mensagem->mensagemOperacao($listaItemControlado);
        $this->imprimeRetorno($mensagem, $this->itemControladoJson->retornoListaJson($listaItemControlado));
    }

    private function listarPorNome($nome) {
        $listaItemControlado = $this->manterItemControlado->listarPorNome($nome);
        $mensagem = $this->mensagem->mensagemOperacao($listaItemControlado);
        $this->imprimeRetorno($mensagem, $this->itemControladoJson->retornoListaJson($listaItemControlado));
    }

    private function listarPorGrupoAtivo($grupoId) {
        $listaItemControlado = $this->manterItemControlado->listarPorGrupoAtivo($grupoId);
        $mensagem = $this->mensagem->mensagemOperacao($listaItemControlado);
        $this->imprimeRetorno($mensagem, $this->itemControladoJson->retornoListaJson($listaItemControlado));
    }

    private function listarPorGrupoEOrgaoControlador($grupoId, $orgaoControladorId) {
        $listaItemControlado = $this->manterItemControlado->listarPorGrupoEOrgaoControlador($grupoId, $orgaoControladorId);
        $mensagem = $this->mensagem->mensagemOperacao($listaItemControlado);
        $this->imprimeRetorno($mensagem, $this->itemControladoJson->retornoListaJson($listaItemControlado));
    }

    private function buscarPorId($id) {
        $itemControlado = $this->manterItemControlado->buscarPorId($id);
        $mensagem = $this->mensagem->mensagemOperacao($itemControlado);
        $this->imprimeRetorno($mensagem, $this->itemControladoJson->retornoJson($itemControlado));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->itemControladoJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->itemControladoJson, $this->manterItemControlado, $this->mensagem, $this->post);
    }

}

$servlet = new ServletItemControlado();
$servlet->switchOpcao();
unset($servlet);
