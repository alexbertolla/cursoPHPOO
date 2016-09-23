<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\cadastros;

/**
 * Description of ServletMaterialPermanente
 *
 * @author alex.bertolla
 */
use controle\cadastros\ManterMaterialPermanente,
    visao\json\cadastros\MaterialPermanenteJson,
    exception\Exception;

class ServletMaterialPermanente {

    private $post;
    private $manterMaterialPermanente;
    private $materialPermanenteJson;
    private $exception;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterMaterialPermanente = new ManterMaterialPermanente();
        $this->materialPermanenteJson = new MaterialPermanenteJson();
        $this->exception = new Exception();
    }

    public function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "inserir":
                case "alterar":
                case "excluir":
                    $this->manterMaterialPermanente->setAtributos($this->post);
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
        $operacao = $this->manterMaterialPermanente->salvar($opcao);
        $this->manterMaterialPermanente->bdToForm();
        $mensagem = $this->exception->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->materialPermanenteJson->retornoJson($this->manterMaterialPermanente->getMaterialPermanente()));
    }

    private function listar() {
        $listaMaterialPermanente = $this->manterMaterialPermanente->listar();
        $mensagem = $this->exception->mensagemOperacao($listaMaterialPermanente);
        $this->imprimeRetorno($mensagem, $this->materialPermanenteJson->retornoListaJson($listaMaterialPermanente));
    }

    private function listarPorNome($nome) {
        $listaMaterialPermanente = $this->manterMaterialPermanente->listarPorNome($nome);
        $mensagem = $this->exception->mensagemOperacao($listaMaterialPermanente);
        $this->imprimeRetorno($mensagem, $this->materialPermanenteJson->retornoListaJson($listaMaterialPermanente));
    }

    private function buscarPorId($id) {
        $materialPermanente = $this->manterMaterialPermanente->buscarPorId($id);
        $mensagem = $this->exception->mensagemOperacao($materialPermanente);
        $this->imprimeRetorno($mensagem, $this->materialPermanenteJson->retornoJson($materialPermanente));
    }

    private function listarPorNomeDescricaoOuCodigo($nome) {
        $listaMaterialPermanente = $this->manterMaterialPermanente->listarPorNomeDescricaoOuCodigo($nome);
        $mensagem = $this->exception->mensagemOperacao($listaMaterialPermanente);
        $this->imprimeRetorno($mensagem, $this->materialPermanenteJson->retornoListaJson($listaMaterialPermanente));
    }

    private function listarPorNomeDescricaoOuCodigoEGrupoAtivo($pesquisa, $grupoId) {
        $listaMaterialPermanente = $this->manterMaterialPermanente->listarPorNomeDescricaoOuCodigoEGrupoAtivo($pesquisa, $grupoId);
        $mensagem = $this->exception->mensagemOperacao($listaMaterialPermanente);
        $this->imprimeRetorno($mensagem, $this->materialPermanenteJson->retornoListaJson($listaMaterialPermanente));
    }

    public function __destruct() {
        unset($this->exception, $this->manterMaterialPermanente, $this->materialPermanenteJson, $this->post);
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->materialPermanenteJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

}

$servlet = new ServletMaterialPermanente();
$servlet->switchOpcao();
unset($servlet);
