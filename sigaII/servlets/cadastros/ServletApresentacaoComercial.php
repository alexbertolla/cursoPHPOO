<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\cadastros;

/**
 * Description of ServletApresentacaoComercial
 *
 * @author alex.bertolla
 */
use controle\cadastros\ManterApresentacaoComercial,
    visao\json\cadastros\ApresentacaoComercialJson,
    exception\Exception;

class ServletApresentacaoComercial {

    private $post;
    private $manterApresentacaoComercial;
    private $apresentacaoComercialJson;
    private $mensagem;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterApresentacaoComercial = new ManterApresentacaoComercial();
        $this->apresentacaoComercialJson = new ApresentacaoComercialJson();
        $this->mensagem = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "inserir":
                case "alterar":
                case "excluir":
                    $this->manterApresentacaoComercial->setAttributos($this->post);
                    $this->salvar($this->post->opcao);
                    break;

                case "listar":
                    $this->listar();
                    break;

                case "listarAtivas":
                    $this->listarAtivas();
                    break;

                case "listarPorGrupoAtivo":
                    $this->listarPorGrupoAtivo($this->post->grupoId);
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
        $operacao = $this->manterApresentacaoComercial->salvar($opcao);
        $this->manterApresentacaoComercial->bdToForm();
        $mensagem = $this->mensagem->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->apresentacaoComercialJson->retornoJson($this->manterApresentacaoComercial->getApresentacaoComercial()));
    }

    private function listar() {
        $listaApresentacaoComercial = $this->manterApresentacaoComercial->listar();
        $mensagem = $this->mensagem->mensagemOperacao($listaApresentacaoComercial);
        $this->imprimeRetorno($mensagem, $this->apresentacaoComercialJson->retornoListaJson($listaApresentacaoComercial));
    }

    private function listarAtivas() {
        $listaApresentacaoComercial = $this->manterApresentacaoComercial->listarAtivas();
        $mensagem = $this->mensagem->mensagemOperacao($listaApresentacaoComercial);
        $this->imprimeRetorno($mensagem, $this->apresentacaoComercialJson->retornoListaJson($listaApresentacaoComercial));
    }

    private function listarPorNome($nome) {
        $listaApresentacaoComercial = $this->manterApresentacaoComercial->listarPorNome($nome);
        $mensagem = $this->mensagem->mensagemOperacao($listaApresentacaoComercial);
        $this->imprimeRetorno($mensagem, $this->apresentacaoComercialJson->retornoListaJson($listaApresentacaoComercial));
    }

    private function listarPorGrupoAtivo($grupoId) {
        $listaApresentacaoComercial = $this->manterApresentacaoComercial->listarPorGrupoAtivo($grupoId);
        $mensagem = $this->mensagem->mensagemOperacao($listaApresentacaoComercial);
        $this->imprimeRetorno($mensagem, $this->apresentacaoComercialJson->retornoListaJson($listaApresentacaoComercial));
    }

    private function buscarPorId($id) {
        $apresentacaoComercial = $this->manterApresentacaoComercial->buscarPorId($id);
        $mensagem = $this->mensagem->mensagemOperacao($apresentacaoComercial);
        $this->imprimeRetorno($mensagem, $this->apresentacaoComercialJson->retornoJson($apresentacaoComercial));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->apresentacaoComercialJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->apresentacaoComercialJson, $this->manterApresentacaoComercial, $this->mensagem, $this->post);
    }

}

$servlet = new ServletApresentacaoComercial();
$servlet->switchOpcao();
unset($servlet);
