<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\cadastros;

/**
 * Description of ServletAlmoxarifadoVirtual
 *
 * @author alex.bertolla
 */
use controle\cadastros\ManterAlmoxarifadoVirtual,
    visao\json\cadastros\AlmoxarifadoVirtualJson,
    exception\Exception;

class ServletAlmoxarifadoVirtual {

    private $post;
    private $manterAlmoxarifadoVirtual;
    private $almoxarifadoVirtualJson;
    private $mensagem;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterAlmoxarifadoVirtual = new ManterAlmoxarifadoVirtual();
        $this->almoxarifadoVirtualJson = new AlmoxarifadoVirtualJson();
        $this->mensagem = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "inserir":
                case "alterar":
                case "excluir":
                    $this->manterAlmoxarifadoVirtual->setAtributos($this->post);
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
        $operacao = $this->manterAlmoxarifadoVirtual->salvar($opcao);
        $this->manterAlmoxarifadoVirtual->bdToForm();
        $mensagem = $this->mensagem->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->almoxarifadoVirtualJson->retornoJson($this->manterAlmoxarifadoVirtual->getAlmoxarifadoVirtual()));
    }

    private function listar() {
        $listaAlmoxarifadoVirtual = $this->manterAlmoxarifadoVirtual->listar();
        $mensagem = $this->mensagem->mensagemOperacao($listaAlmoxarifadoVirtual);
        $this->imprimeRetorno($mensagem, $this->almoxarifadoVirtualJson->retornoListaJson($listaAlmoxarifadoVirtual));
    }

    private function listarAtivos() {
        $listaAlmoxarifadoVirtual = $this->manterAlmoxarifadoVirtual->listarAtivos();
        $mensagem = $this->mensagem->mensagemOperacao($listaAlmoxarifadoVirtual);
        $this->imprimeRetorno($mensagem, $this->almoxarifadoVirtualJson->retornoListaJson($listaAlmoxarifadoVirtual));
    }

    private function listarPorNome($nome) {
        $listaAlmoxarifadoVirtual = $this->manterAlmoxarifadoVirtual->listarPorNome($nome);
        $mensagem = $this->mensagem->mensagemOperacao($listaAlmoxarifadoVirtual);
        $this->imprimeRetorno($mensagem, $this->almoxarifadoVirtualJson->retornoListaJson($listaAlmoxarifadoVirtual));
    }

    private function buscarPorId($id) {
        $almoxarifadoVirtual = $this->manterAlmoxarifadoVirtual->buscarPorId($id);
        $mensagem = $this->mensagem->mensagemOperacao($almoxarifadoVirtual);
        $this->imprimeRetorno($mensagem, $this->almoxarifadoVirtualJson->retornoJson($almoxarifadoVirtual));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->almoxarifadoVirtualJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->post, $this->almoxarifadoVirtualJson, $this->manterAlmoxarifadoVirtual, $this->mensagem);
    }

}

$servlet = new ServletAlmoxarifadoVirtual();
$servlet->switchOpcao();
unset($servlet);
