<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\cadastros;

/**
 * Description of ServletServico
 *
 * @author alex.bertolla
 */
use controle\cadastros\ManterServico,
    visao\json\cadastros\ServicoJson,
    exception\Exception;

class ServletServico {

    private $post;
    private $manterServico;
    private $servicoJson;
    private $mensagem;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterServico = new ManterServico();
        $this->servicoJson = new ServicoJson();
        $this->mensagem = new Exception();
    }

    function switchOpcao() {
        try{
        switch ($this->post->opcao) {
            case "inserir":
            case "alterar":
            case "excluir":
                $this->manterServico->setAtributos($this->post);
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
        $operacao = $this->manterServico->salvar($opcao);
        $this->manterServico->bdToForm();
        $mensagem = $this->mensagem->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->servicoJson->retornoJson($this->manterServico->getServico()));
    }

    private function listar() {
        $listaServico = $this->manterServico->listar();
        $mensagem = $this->mensagem->mensagemOperacao($listaServico);
        $this->imprimeRetorno($mensagem, $this->servicoJson->retornoListaJson($listaServico));
    }

    private function listarPorNome($nome) {
        $listaServico = $this->manterServico->listarPorNome($nome);
        $mensagem = $this->mensagem->mensagemOperacao($listaServico);
        $this->imprimeRetorno($mensagem, $this->servicoJson->retornoListaJson($listaServico));
    }

    private function listarPorNomeDescricaoOuCodigo($pesquisa) {
        $listaServico = $this->manterServico->listarPorNomeDescricaoOuCodigo($pesquisa);
        $mensagem = $this->mensagem->mensagemOperacao($listaServico);
        $this->imprimeRetorno($mensagem, $this->servicoJson->retornoListaJson($listaServico));
    }
    
    private function listarPorNomeDescricaoOuCodigoEGrupoAtivo($pesquisa, $grupoId) {
        $listaServico = $this->manterServico->listarPorNomeDescricaoOuCodigoEGrupoAtivo($pesquisa, $grupoId);
        $mensagem = $this->mensagem->mensagemOperacao($listaServico);
        $this->imprimeRetorno($mensagem, $this->servicoJson->retornoListaJson($listaServico));
    }

    private function buscarPorId($id) {
        $servico = $this->manterServico->buscarPorId($id);
        $mensagem = $this->mensagem->mensagemOperacao($servico);
        $this->imprimeRetorno($mensagem, $this->servicoJson->retornoJson($servico));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->servicoJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->manterServico, $this->mensagem, $this->post, $this->servicoJson);
    }

}

$servlet = new ServletServico();
$servlet->switchOpcao();
unset($servlet);
