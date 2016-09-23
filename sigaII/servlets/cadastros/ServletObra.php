<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\cadastros;

/**
 * Description of ServletObra
 *
 * @author alex.bertolla
 */
use controle\cadastros\ManterObra,
    visao\json\cadastros\ObraJson,
    exception\Exception;

class ServletObra {

    private $post;
    private $manterObra;
    private $obraJson;
    private $exception;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterObra = new ManterObra();
        $this->obraJson = new ObraJson();
        $this->exception = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "inserir":
                case "alterar":
                case "excluir":
                    $this->manterObra->setAtributos($this->post);
                    $this->salvar($this->post->opcao);
                    break;
                case "listar":
                    $this->listar();
                    break;
                case "listarPorNome":
                    $this->listarPorNome($this->post->nome);
                    break;
                case "buscarPorId":
                    $this->buscarPorId($this->post->id);
                    break;
                case "listarPorNomeDescricaoOuCodigo":
                    $this->listarPorNomeDescricaoOuCodigo($this->post->nome);
                    break;

                case "listarPorNomeDescricaoOuCodigoEGrupoAtivo":
                    $this->listarPorNomeDescricaoOuCodigoEGrupoAtivo($this->post->nome, $this->post->grupoId);
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function salvar($opcao) {
        $operacao = $this->manterObra->salvar($opcao);
        $this->manterObra->bdToForm();
        $mensagem = $this->exception->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->obraJson->retornoJson($this->manterObra->getObra()));
    }

    private function listar() {
        $listaObra = $this->manterObra->listar();
        if (count($listaObra) > 0) {
            $this->manterObra->setDadosListaObras($listaObra);
        }
        $mensagem = $this->exception->mensagemOperacao($listaObra);
        $this->imprimeRetorno($mensagem, $this->obraJson->retornoListaJson($listaObra));
    }

    private function listarPorNome($nome) {
        $listaObra = $this->manterObra->listarPorNome($nome);
        $mensagem = $this->exception->mensagemOperacao($listaObra);
        $this->imprimeRetorno($mensagem, $this->obraJson->retornoListaJson($listaObra));
    }

    private function listarPorNomeDescricaoOuCodigo($nome) {
        $listaObra = $this->manterObra->listarPorNomeDescricaoOuCodigo($nome);
        if (count($listaObra) > 0) {
            $this->manterObra->setDadosListaObras($listaObra);
        }
        $mensagem = $this->exception->mensagemOperacao($listaObra);
        $this->imprimeRetorno($mensagem, $this->obraJson->retornoListaJson($listaObra));
    }

    private function listarPorNomeDescricaoOuCodigoEGrupoAtivo($pesquisa, $grupoId) {
        $listaObra = $this->manterObra->listarPorNomeDescricaoOuCodigoEGrupoAtivo($pesquisa, $grupoId);
        if (count($listaObra) > 0) {
            $this->manterObra->setDadosListaObras($listaObra);
        }
        $mensagem = $this->exception->mensagemOperacao($listaObra);
        $this->imprimeRetorno($mensagem, $this->obraJson->retornoListaJson($listaObra));
    }

    private function buscarPorId($id) {
        $obra = $this->manterObra->buscarPorId($id);
        $mensagem = $this->exception->mensagemOperacao($obra);
        $this->imprimeRetorno($mensagem, $this->obraJson->retornoJson($obra));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->obraJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->exception, $this->manterObra, $this->obraJson, $this->post);
    }

}

$servlet = new ServletObra();
$servlet->switchOpcao();
unset($servlet);
