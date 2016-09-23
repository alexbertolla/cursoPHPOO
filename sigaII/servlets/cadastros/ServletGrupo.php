<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\cadastros;

/**
 * Description of ServletGrupo
 *
 * @author alex.bertolla
 */
use controle\cadastros\ManterGrupo,
    visao\json\cadastros\GrupoJson,
    exception\Exception;

class ServletGrupo {

    private $post;
    private $manterGrupo;
    private $grupoJson;
    private $mensagem;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterGrupo = new ManterGrupo();
        $this->grupoJson = new GrupoJson();
        $this->mensagem = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "inserir":
                case "alterar":
                case "excluir":
                    $this->manterGrupo->setAtributos($this->post);
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

                case "listarAtivosPorNaturezaDespesaId":
                    $this->listarAtivosPorNaturezaDespesaId($this->post->naturezaDespesaId);
                    break;

                case "listarAtivosPorFornecedorId":
                    $this->listarAtivosPorFornecedorId($this->post->fornecedorId);
                    break;

                case "listarAtivosPorTipoNaturezaDespesa":
                    $this->listarAtivosPorTipoNaturezaDespesa($this->post->tipoNaturezaDespesa);
                    break;

                case "listarPorNomeOuCodigo":
                    $this->listarPorNomeOuCodigo($this->post->nome);
                    break;

                case "salvarGrupoFornecedor":
                    $this->salvarGrupoFornecedor($this->post->grupoId, $this->post->fornecedorId);
                    break;

                case "listarGruposEstoque":
                    $this->listarGruposEstoque();
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function salvar($opcao) {
        $operacao = $this->manterGrupo->salvar($opcao);
        $this->manterGrupo->bdToForm();
        $mensagem = $this->mensagem->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->grupoJson->retornoJson($this->manterGrupo->getGrupo()));
    }

    private function listar() {
        $listaGrupo = $this->manterGrupo->listar();
        $mensagem = $this->mensagem->mensagemCadastro($listaGrupo);
        $this->imprimeRetorno($mensagem, $this->grupoJson->retornoListaJson($listaGrupo));
    }

    private function listarAtivos() {
        $listaGrupo = $this->manterGrupo->listarAtivos();
        $mensagem = $this->mensagem->mensagemCadastro($listaGrupo);
        $this->imprimeRetorno($mensagem, $this->grupoJson->retornoListaJson($listaGrupo));
    }

    private function listarPorNome($nome) {
        $listaGrupo = $this->manterGrupo->listarPorNome($nome);
        $mensagem = $this->mensagem->mensagemCadastro($listaGrupo);
        $this->imprimeRetorno($mensagem, $this->grupoJson->retornoListaJson($listaGrupo));
    }

    private function listarAtivosPorNaturezaDespesaId($naturezaDespesaId) {
        $listaGrupo = $this->manterGrupo->listarAtivosPorNaturezaDespesaId($naturezaDespesaId);
        $mensagem = $this->mensagem->mensagemCadastro($listaGrupo);
        $this->imprimeRetorno($mensagem, $this->grupoJson->retornoListaJson($listaGrupo));
    }

    private function listarAtivosPorTipoNaturezaDespesa($tipo) {
        $listaGrupo = $this->manterGrupo->listarAtivosPorTipoNaturezaDespesa($tipo);
        $mensagem = $this->mensagem->mensagemCadastro($listaGrupo);
        $this->imprimeRetorno($mensagem, $this->grupoJson->retornoListaJson($listaGrupo));
    }

    private function listarAtivosPorFornecedorId($fornecedorId) {
        $listaGrupo = $this->manterGrupo->listarAtivosPorFornecedorId($fornecedorId);
        $mensagem = $this->mensagem->mensagemCadastro($listaGrupo);
        $this->imprimeRetorno($mensagem, $this->grupoJson->retornoListaJson($listaGrupo));
    }

    private function listarPorNomeOuCodigo($pesquisa) {
        $listaGrupo = $this->manterGrupo->listarPorNomeOuCodigo($pesquisa);
        $mensagem = $this->mensagem->mensagemCadastro($listaGrupo);
        $this->imprimeRetorno($mensagem, $this->grupoJson->retornoListaJson($listaGrupo));
    }

    private function salvarGrupoFornecedor($listaGrupos, $fornecedorId) {
        $operacao = $this->manterGrupo->salvarGrupoFornecedor($listaGrupos, $fornecedorId);
        $mensagem = $this->mensagem->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $listaGrupos);
    }

    private function buscarPorId($id) {
        $grupo = $this->manterGrupo->buscarPorId($id);
        $mensagem = $this->mensagem->mensagemCadastro($grupo);
        $this->imprimeRetorno($mensagem, $this->grupoJson->retornoJson($grupo));
    }

    private function listarGruposEstoque() {
        $listaGrupo = $this->manterGrupo->listarGruposEstoque();
        $mensagem = $this->mensagem->mensagemCadastro($listaGrupo);
        $this->imprimeRetorno($mensagem, $this->grupoJson->retornoListaJson($listaGrupo));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->grupoJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->grupoJson, $this->manterGrupo, $this->mensagem, $this->post);
    }

}

$servlet = new ServletGrupo();
$servlet->switchOpcao();
unset($servlet);
