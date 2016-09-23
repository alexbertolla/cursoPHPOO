<?php

namespace servlets\cadastros;

use controle\cadastros\ManterBanco,
    visao\json\cadastros\BancoJson,
    exception\Exception;

class ServletBanco {

    private $post;
    private $manterBanco;
    private $bancoJson;
    private $retornoJson;
    private $mensagem;

    function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterBanco = new ManterBanco();
        $this->bancoJson = new BancoJson();
        $this->mensagem = new Exception();
    }

    public function __destruct() {
        unset($this->bancoJson, $this->manterBanco);
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $this->retornoJson = $this->bancoJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($this->retornoJson);
    }

    private function salvar() {
        $this->manterBanco->setAtributos($this->post);
        $operacao = $this->manterBanco->salvar($this->post->opcao);
        $this->manterBanco->bdToForm();
        $mensagem = $this->mensagem->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->bancoJson->retornoJson($this->manterBanco->getBanco()));

//        $this->retornoJson = $this->bancoJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem, $this->bancoJson->retornoJson($this->manterBanco->getBanco()));
    }

    private function listar() {
        $listaBancos = $this->manterBanco->listar();
        $mensagem = $this->mensagem->mensagemOperacao($listaBancos);
        $dados = $this->bancoJson->retornoListaJsnon($listaBancos);
        $this->imprimeRetorno($mensagem, $dados);
//        $this->retornoJson = $this->bancoJson->formataRetornoJson("sucesso", "opção [{$this->post->opcao}] executada com sucesso", $this->bancoJson->retornoListaJsnon($listaBancos));
    }

    private function listarAtivos() {
        $listaBancos = $this->manterBanco->listarAtivos();
        $mensagem = $this->mensagem->mensagemOperacao($listaBancos);
        $dados = $this->bancoJson->retornoListaJsnon($listaBancos);
        $this->imprimeRetorno($mensagem, $dados);
//        $this->retornoJson = $this->bancoJson->formataRetornoJson("sucesso", "opção [{$this->post->opcao}] executada com sucesso", $this->bancoJson->retornoListaJsnon($listaBancos));
    }

    private function listarPorNome($nome) {
        $listaBancos = $this->manterBanco->listarPorNome($nome);
        $mensagem = $this->mensagem->mensagemOperacao($listaBancos);
        $dados = $this->bancoJson->retornoListaJsnon($listaBancos);
        $this->imprimeRetorno($mensagem, $dados);
//        $this->retornoJson = $this->bancoJson->formataRetornoJson("sucesso", "opção [{$this->post->opcao}] executada com sucesso", $this->bancoJson->retornoListaJsnon($listaBancos));
    }

    private function listarPorNomeAtivo($nome) {
        $listaBancos = $this->manterBanco->listarPorNomeAtivo($nome);
        $mensagem = $this->mensagem->mensagemOperacao($listaBancos);
        $dados = $this->bancoJson->retornoListaJsnon($listaBancos);
        $this->imprimeRetorno($mensagem, $dados);
//        $this->retornoJson = $this->bancoJson->formataRetornoJson("sucesso", "opção [{$this->post->opcao}] executada com sucesso", $this->bancoJson->retornoListaJsnon($listaBancos));
    }

    private function buscarPorCodigo($codigo) {
        $banco = $this->manterBanco->buscarPorCodigo($codigo);
        $mensagem = $this->mensagem->mensagemOperacao($banco);
        $dados = $$this->bancoJson->retornoJson($banco);
        $this->imprimeRetorno($mensagem, $dados);
//        $this->retornoJson = $this->bancoJson->formataRetornoJson("sucesso", "opção [{$this->post->opcao}] executada com sucesso", $this->bancoJson->retornoJson($banco));
    }

    private function buscarPorCodigoAtivo($codigo) {
        $banco = $this->manterBanco->buscarPorCodigoAtivo($codigo);
        $mensagem = $this->mensagem->mensagemOperacao($banco);
        $dados = $$this->bancoJson->retornoJson($banco);
        $this->imprimeRetorno($mensagem, $dados);
//        $this->retornoJson = $this->bancoJson->formataRetornoJson("sucesso", "opção [{$this->post->opcao}] executada com sucesso", $this->bancoJson->retornoJson($banco));
    }

    private function buscarPorId($id) {
        $banco = $this->manterBanco->buscarPorId($id);
        $mensagem = $this->mensagem->mensagemOperacao($banco);
        $dados = $$this->bancoJson->retornoJson($banco);
        $this->imprimeRetorno($mensagem, $dados);
//        $this->retornoJson = $this->bancoJson->formataRetornoJson("sucesso", "opção [{$this->post->opcao}] executada com sucesso", $this->bancoJson->retornoJson($banco));
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
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
                    $this->listarPorNome($this->post->nome);
                    break;

                case "listarPorNomeAtivo":
                    $this->listarPorNomeAtivo($this->post->nome);
                    break;

                case "buscarPorCodigo":
                    $this->buscarPorCodigo($this->post->codigo);
                    break;
                case "buscarPorCodigoAtivo":
                    $this->buscarPorCodigoAtivo($this->post->codigo);
                    break;

                case "buscarPorId":
                    $this->buscarPorId($this->post->id);
                    break;
                default :
                    $this->retornoJson = $this->bancoJson->formataRetornoJson("erro", "opção [{$this->post->opcao}] inválida", NULL);
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

}

$servletBanco = new ServletBanco();
$servletBanco->switchOpcao();
unset($servletBanco);
