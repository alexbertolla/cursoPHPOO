<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\cadastros;

/**
 * Description of ServletMaterialConsumo
 *
 * @author alex.bertolla
 */
use controle\cadastros\ManterMaterialConsumo,
    visao\json\cadastros\MaterialConsumoJson,
    exception\Exception;

class ServletMaterialConsumo {

    private $post;
    private $manterMaterialConsumo;
    private $materialConsumoJson;
    private $exception;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterMaterialConsumo = new ManterMaterialConsumo();
        $this->materialConsumoJson = new MaterialConsumoJson();
        $this->exception = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "inserir":
                case "alterar":
                case "excluir":
                    $this->manterMaterialConsumo->setAtributos($this->post);
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
        $operacao = $this->manterMaterialConsumo->salvar($opcao);
        $this->manterMaterialConsumo->bdToForm();
        $mensagem = $this->exception->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->materialConsumoJson->retornoJson($this->manterMaterialConsumo->getMaterialConsumo()));
    }

    private function listar() {
        $listaMaterialConsumo = $this->manterMaterialConsumo->listar();
//        $this->manterMaterialConsumo->setDadosListaMaterialConsumo($listaMaterialConsumo);
        $mensagem = $this->exception->mensagemOperacao($listaMaterialConsumo);
        $this->imprimeRetorno($mensagem, $this->materialConsumoJson->retornoListaJson($listaMaterialConsumo));
    }

    private function listarPorNome($nome) {
        $listaMaterialConsumo = $this->manterMaterialConsumo->listarPorNome($nome);
        $mensagem = $this->exception->mensagemOperacao($listaMaterialConsumo);
        $this->imprimeRetorno($mensagem, $this->materialConsumoJson->retornoListaJson($listaMaterialConsumo));
    }

    private function listarPorNomeDescricaoOuCodigo($nome) {
        $listaMaterialConsumo = $this->manterMaterialConsumo->listarPorNomeDescricaoOuCodigo($nome);
        $mensagem = $this->exception->mensagemOperacao($listaMaterialConsumo);
        $this->imprimeRetorno($mensagem, $this->materialConsumoJson->retornoListaJson($listaMaterialConsumo));
    }

    private function listarPorNomeDescricaoOuCodigoEGrupoAtivo($pesquisa, $grupoId) {
        $listaMaterialConsumo = $this->manterMaterialConsumo->listarPorNomeDescricaoOuCodigoEGrupoAtivo($pesquisa, $grupoId);
        $this->manterMaterialConsumo->setDadosListaMaterialConsumo($listaMaterialConsumo);
        $mensagem = $this->exception->mensagemOperacao($listaMaterialConsumo);
        $this->imprimeRetorno($mensagem, $this->materialConsumoJson->retornoListaJson($listaMaterialConsumo));
    }

    private function buscarPorId($id) {
        $materialConsumo = $this->manterMaterialConsumo->buscarPorId($id);
        $mensagem = $this->exception->mensagemOperacao($materialConsumo);
        $this->imprimeRetorno($mensagem, $this->materialConsumoJson->retornoJson($materialConsumo));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->materialConsumoJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->exception, $this->manterMaterialConsumo, $this->materialConsumoJson, $this->post);
    }

}

$servle = new ServletMaterialConsumo();
$servle->switchOpcao();
unset($servle);
