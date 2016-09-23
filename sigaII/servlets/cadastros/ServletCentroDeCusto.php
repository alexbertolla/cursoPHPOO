<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\cadastros;

/**
 * Description of ServletCentroDeCusto
 *
 * @author alex.bertolla
 */
use controle\cadastros\ManterCentroCusto,
    visao\json\cadastros\CentroDeCustoJson,
    exception\Exception;

class ServletCentroDeCusto {

    private $post;
    private $manterCentroCusto;
    private $centroCustoJson;
    private $mensagem;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterCentroCusto = new ManterCentroCusto();
        $this->centroCustoJson = new CentroDeCustoJson();
        $this->mensagem = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "inserir":
                case "alterar":
                case "excluir":
                    $this->manterCentroCusto->setAtributos($this->post);
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
        $operacao = $this->manterCentroCusto->salvar($opcao);
        $this->manterCentroCusto->bdToForm();
        $mensagem = $this->mensagem->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->centroCustoJson->retornoJson($this->manterCentroCusto->getCentroCusto()));
    }

    private function listar() {
        $lista = $this->manterCentroCusto->listar();
        $mensagem = $this->mensagem->mensagemOperacao($lista);
        $this->imprimeRetorno($mensagem, $this->centroCustoJson->retornoListaJson($lista));
    }

    private function listarAtivos() {
        $lista = $this->manterCentroCusto->listarAtivos();
        $mensagem = $this->mensagem->mensagemOperacao($lista);
        $this->imprimeRetorno($mensagem, $this->centroCustoJson->retornoListaJson($lista));
    }

    private function listarPorNome($nome) {
        $lista = $this->manterCentroCusto->listarPorNome($nome);
        $mensagem = $this->mensagem->mensagemOperacao($lista);
        $this->imprimeRetorno($mensagem, $this->centroCustoJson->retornoListaJson($lista));
    }

    private function buscarPorId($id) {
        $centroDeCusto = $this->manterCentroCusto->buscarPorId($id);
        $mensagem = $this->mensagem->mensagemOperacao($centroDeCusto);
        $this->imprimeRetorno($mensagem, $this->centroCustoJson->retornoJson($centroDeCusto));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->centroCustoJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->centroCustoJson, $this->manterCentroCusto, $this->mensagem, $this->post);
    }

}

$servlet = new ServletCentroDeCusto();
$servlet->switchOpcao();
unset($servlet);
