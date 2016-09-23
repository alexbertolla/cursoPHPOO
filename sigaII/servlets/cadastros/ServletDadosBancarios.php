<?php

namespace servlets\cadastros;

use controle\cadastros\ManterDadosBancarios,
    visao\json\cadastros\DadosBancarioJson;

class ServletDadosBancarios {

    private $post;
    private $retornoJson;
    private $manterDadosBancarios;
    private $dbJson;

    function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterDadosBancarios = new ManterDadosBancarios();
        $this->dbJson = new DadosBancarioJson();
    }

    public function __destruct() {
        $this->imprimeRetorno();
        unset($this->manterDadosBancarios, $this->dbJson);
    }

    private function imprimeRetorno() {
        header('Content-Type: application/json');
        echo json_encode($this->retornoJson);
    }

    private function salvar($opcao) {
        $this->manterDadosBancarios->setAtributos($this->post);
        $operacao = $this->manterDadosBancarios->salvar($opcao);
        $this->retornoJson = ($operacao) ? $this->dbJson->formataRetornoJson("sucesso", "opçao [{$opcao}] executada com sucesso", $this->dbJson->retornoJson($this->manterDadosBancarios->getDadosBancario())) :
                $this->dbJson->formataRetornoJson("erro", "opçao [{$opcao}] nao foi executada com sucesso", $this->dbJson->retornoJson($this->manterDadosBancarios->getDadosBancario()));
    }

    private function listarPorFornecedorId($fornecedorId) {
        $listaDadosBancario = $this->manterDadosBancarios->listarPorFornecedorId($fornecedorId);
        $this->retornoJson = $this->dbJson->formataRetornoJson("sucesso", "opçao [{$this->post->opcao}] executada com sucesso", $this->dbJson->retornoListaJson($listaDadosBancario));
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "inserir":
                case "alterar":
                case "excluir":
                    $this->salvar($this->post->opcao);
                    break;
                case "listarPorFornecedorId":
                    $this->listarPorFornecedorId($this->post->fornecedorId);
                    break;
                default :
                    $this->retornoJson = $this->dbJson->formataRetornoJson("erro", "opçao [{$this->post->opcao}] inválida", NULL);
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

}

$servletDB = new ServletDadosBancarios();
$servletDB->switchOpcao();
unset($servletDB);
