<?php

namespace servlets\cadastros;

use modelo\cadastros\Endereco,
    controle\cadastros\ManterEndereco,
    visao\json\cadastros\EnderecoJson,
    webservices\WSCorreios,
    exception\Exception;

class ServletEndereco {

    private $post;
    private $manterEndereco;
    private $enderecoJson;
    private $retornoJson;
    private $exception;

    public function __construct() {
        include_once '../../autoload.php';
        $this->manterEndereco = new ManterEndereco();
        $this->enderecoJson = new EnderecoJson();
        $this->exception = new Exception();
        $this->post = (object) filter_input_array(INPUT_POST);
    }

    public function __destruct() {
        unset($this->manterEndereco, $this->enderecoJson, $this->exception);
    }

    private function salvar() {
        $this->manterEndereco->setAtributos($this->post);
        $operacao = $this->manterEndereco->salvar($this->post->opcao);
        $this->manterEndereco->bdToFotm();
        $mensagem = $this->exception->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->enderecoJson->retornoJson($this->manterEndereco->getEndereco()));
    }

    private function buscarPorFornecedorId() {
        $endereco = $this->manterEndereco->buscarPorFornecedorId($this->post->fornecedorId);
        $mensagem = $this->exception->mensagemOperacao($endereco);
        $this->imprimeRetorno($mensagem, $this->enderecoJson->retornoJson($endereco));
    }

    private function buscarPorCep() {
        $wsCorreios = new WSCorreios();
        $enderecoCep = $wsCorreios->buscarPorCep($this->post->cep);
        if (strlen($enderecoCep["logradouro"]) > 0) {
            $endereco = new Endereco();
            $endereco->setLogradouro($enderecoCep["logradouro"]);
            $endereco->setBairro($enderecoCep["bairro"]);
            $endereco->setCidade($enderecoCep["cidade"]);
            $endereco->setEstado($enderecoCep["estado"]);
            $endereco->setCep($enderecoCep["cep"]);
            $endereco->setPais("Brasil");

            $mensagem = $this->exception->mensagemOperacao($endereco);
            $this->imprimeRetorno($mensagem, $this->enderecoJson->retornoJson($endereco));
        } else {
            $mensagem = $this->exception->mensagemOperacao(FALSE);
            $this->imprimeRetorno($mensagem, NULL);
        }
        unset($wsCorreios, $endereco);
    }

    function switcOpcao() {
        try {
            switch ($this->post->opcao) {
                case "inserir":
                case "alterar":
                case "excluir":
                    $this->salvar();
                    break;
                case "buscarPorFornecedorId":
                    $this->buscarPorFornecedorId();
                    break;
                case "buscarPorCep":
                    $this->buscarPorCep();
                    break;
                default :
                    $this->enderecoJson->formataRetornoJson("erro", "opção [{$this->post->opcao}] inválida", NULL);
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->enderecoJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

}

$servletEndereco = new ServletEndereco();
$servletEndereco->switcOpcao();
unset($servletEndereco);
