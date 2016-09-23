<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\cadastros;

/**
 * Description of ServletOrgaoControlador
 *
 * @author alex.bertolla
 */
use controle\cadastros\ManterOrgaoControlador,
    visao\json\cadastros\OrgaoControladorJson,
    exception\Exception;

class ServletOrgaoControlador {

    private $post;
    private $manterOrgaoControlador;
    private $orgaoControladorJson;
    private $mensagem;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterOrgaoControlador = new ManterOrgaoControlador();
        $this->orgaoControladorJson = new OrgaoControladorJson();
        $this->mensagem = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "inserir":
                case "alterar":
                case "excluir":
                    $this->manterOrgaoControlador->setAtributos($this->post);
                    $this->salvar($this->post->opcao);
                    break;

                case "listar":
                    $this->listar();
                    break;

                case "listarAtivos":
                    $this->listarAtivos();
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
        $operacao = $this->manterOrgaoControlador->salvar($opcao);
        $this->manterOrgaoControlador->bdToForm();
        $mensagem = $this->mensagem->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->orgaoControladorJson->retornoJson($this->manterOrgaoControlador->getOrgaoControlador()));
    }

    private function listar() {
        $listaOrgaoControlador = $this->manterOrgaoControlador->listar();
        $mensagem = $this->mensagem->mensagemOperacao($listaOrgaoControlador);
        $this->imprimeRetorno($mensagem, $this->orgaoControladorJson->retornoListaJson($listaOrgaoControlador));
    }

    private function listarAtivos() {
        $listaOrgaoControlador = $this->manterOrgaoControlador->listarAtivos();
        $mensagem = $this->mensagem->mensagemOperacao($listaOrgaoControlador);
        $this->imprimeRetorno($mensagem, $this->orgaoControladorJson->retornoListaJson($listaOrgaoControlador));
    }

    private function listarPorNome($nome) {
        $listaOrgaoControlador = $this->manterOrgaoControlador->listarPorNome($nome);
        $mensagem = $this->mensagem->mensagemOperacao($listaOrgaoControlador);
        $this->imprimeRetorno($mensagem, $this->orgaoControladorJson->retornoListaJson($listaOrgaoControlador));
    }

    private function buscarPorId($id) {
        $orgaoControlador = $this->manterOrgaoControlador->buscarPorId($id);
        $mensagem = $this->mensagem->mensagemOperacao($orgaoControlador);
        $this->imprimeRetorno($mensagem, $this->orgaoControladorJson->retornoJson($orgaoControlador));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->orgaoControladorJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->manterOrgaoControlador, $this->mensagem, $this->orgaoControladorJson, $this->post);
    }

}

$servlet = new ServletOrgaoControlador();
$servlet->switchOpcao();
unset($servlet);
