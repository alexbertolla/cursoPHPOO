<?php

namespace servlets\cadastros;

use modelo\cadastros\FornecedorPessoaFisica,
    modelo\cadastros\FornecedorPessoaJuridica,
    controle\cadastros\ManterFornecedorPessoaFisica,
    controle\cadastros\ManterFornecedorPessoaJuridica,
    controle\cadastros\ManterTelefone,
    visao\json\cadastros\FornecedorPFJson,
    visao\json\cadastros\FornecedorPJJson,
    exception\Exception;

class ServletFornecedor {

    public $post;
    private $retorno;
    private $manterFornecedor;
    private $fornecedor;
    private $fornecedorJson;
    private $exception;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $tipoFornecedor = $this->post->tipoFornecedor;
        $this->manterFornecedor = ($tipoFornecedor === "pf") ? new ManterFornecedorPessoaFisica() : new ManterFornecedorPessoaJuridica();
        $this->fornecedor = ($tipoFornecedor === "pf") ? new FornecedorPessoaFisica() : new FornecedorPessoaJuridica();
        $this->fornecedorJson = ($tipoFornecedor === "pf") ? new FornecedorPFJson() : new FornecedorPJJson();

        $this->exception = new Exception();
    }

    public function __destruct() {
        unset($this->manterFornecedor, $this->fornecedorJson);
    }

    private function salvar() {
        $this->manterFornecedor->setAtributos($this->post);
        $operacao = $this->manterFornecedor->salvar($this->post->opcao);
        $this->manterFornecedor->bdToForm();
        $mensagem = $this->exception->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->fornecedorJson->retornoJson($this->manterFornecedor->buscarPorId($this->manterFornecedor->getFornecedor()->getId())));
        $this->retorno = ($operacao) ? $this->fornecedorJson->formataRetornoJson("sucesso", "opção [{$this->post->opcao}] executada com sucesso", $this->fornecedorJson->retornoJson($this->manterFornecedor->getFornecedor())) :
                $this->fornecedorJson->formataRetornoJson("erro", "opção [{$this->post->opcao}] não foi executada com sucesso", $this->fornecedorJson->retornoJson($this->manterFornecedor->getFornecedor()));
    }

    private function listar() {
        $listaFornecedor = $this->manterFornecedor->listar();
        $mensagem = $this->exception->mensagemOperacao($listaFornecedor);
        $this->imprimeRetorno($mensagem, $this->fornecedorJson->retornoListaJson($listaFornecedor));
    }

    private function listarPorNome() {
        $listaFornecedor = $this->manterFornecedor->listarPorNome($this->post->nome);
        $mensagem = $this->exception->mensagemOperacao($listaFornecedor);
        $this->imprimeRetorno($mensagem, $this->fornecedorJson->retornoListaJson($listaFornecedor));
    }

    private function listarAtivos() {
        $listaFornecedor = $this->manterFornecedor->listarAtivos();
        $mensagem = $this->exception->mensagemOperacao($listaFornecedor);
        $this->imprimeRetorno($mensagem, $this->fornecedorJson->retornoListaJson($listaFornecedor));
    }

    private function buscarPorDocumento() {
        $fornecedor = $this->manterFornecedor->buscarPorDocumento($this->post->documento);
//        $this->manterFornecedor->SetDadosFornecedor($fornecedor);
        $mensagem = $this->exception->mensagemOperacao($fornecedor);
        $this->imprimeRetorno($mensagem, $this->fornecedorJson->retornoJson($fornecedor));
    }

    private function validarDocumento() {
        $documentoValidado = $this->manterFornecedor->validarDocumento($this->post->documento);
        $mensagem = $this->exception->mensagemDocumentoFornecedor($documentoValidado);
        $fornecedor = ($documentoValidado) ? $this->manterFornecedor->buscarPorDocumento($this->post->documento) : NULL;
        $this->imprimeRetorno($mensagem, $this->fornecedorJson->retornoJson($fornecedor));
    }

    private function buscarPorId() {
        $fornecedor = $this->manterFornecedor->buscarPorId($this->post->id);
        $this->manterFornecedor->SetDadosFornecedor($fornecedor);
        $mensagem = $this->exception->mensagemOperacao($fornecedor);
        $this->imprimeRetorno($mensagem, $this->fornecedorJson->retornoJson($fornecedor));
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {//$thistipoFornecedor->post->opcao
                case "inserir":
                case "alterar":
                case "excluir":
                    $this->salvar();
                    break;

                case "listar":
                    $this->listar();
                    break;

                case "listarAtivos":
                    $this->listarAtivos();
                    break;

                case "listarPorNome":
                    $this->listarPorNome();
                    break;

                case "buscarPorDocumento":
                    $this->buscarPorDocumento();
                    break;

                case "validarDocumento":
                    $this->validarDocumento();
                    break;

                case "buscarPorId":
                    $this->buscarPorId();
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->fornecedorJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

}

$servlet = new ServletFornecedor();
$servlet->switchOpcao();
unset($servlet);
