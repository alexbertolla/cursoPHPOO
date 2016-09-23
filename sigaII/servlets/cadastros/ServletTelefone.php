<?php

namespace servlets\cadastros;

use modelo\cadastros\Telefone,
    controle\cadastros\ManterTelefone,
    visao\json\cadastros\TelefoneJson,
    ArrayObject;

class ServletTelefone {

    private $post;
    private $manterTelefone;
    private $telefoneJson;
    private $retornoJson;

    public function __construct() {
        include_once '../../autoload.php';
        $this->manterTelefone = new ManterTelefone();
        $this->telefoneJson = new TelefoneJson();
        $this->post = (object) filter_input_array(INPUT_POST);
    }

    private function setListaTelefone() {
        $listaTelefone = $_POST["listaTelefone"]; //urldecode($this->post->listaTelefone);
        if (count($listaTelefone) > 0) {
            $fornecedorId = $this->post->fornecedorId;
            $lista = new ArrayObject();
            foreach ($listaTelefone as $tel) {
                $telefone = new Telefone();
                $telefone->setDdd($tel["ddd"]);
                $telefone->setDdi($tel["ddi"]);
                $telefone->setNumero($tel["numeroTelefone"]);
                $telefone->setFornecedorId($fornecedorId);
                $lista->append($telefone);
            }
            return $lista;
        } else {
            return NULL;
        }
    }

    private function salvar() {
        $fornecedorId = $this->post->fornecedorId;
        $listaTelefone = $this->setListaTelefone();
        $this->manterTelefone->setAtributos($this->post);
        $this->manterTelefone->salvar("excluir");
        $operacao = TRUE;
        if ($listaTelefone) {
            foreach ($listaTelefone as $telefone) {
                $this->manterTelefone->setTelefone($telefone);
                $operacao = $this->manterTelefone->salvar($this->post->opcao);
            }
        }
        $this->retornoJson = ($operacao) ? $this->telefoneJson->formataRetornoJson("sucesso", "opção [{$this->post->opcao}] executada com sucesso", $this->telefoneJson->retornoListaJson($this->manterTelefone->listarPorFornecedorId($fornecedorId))) :
                $this->telefoneJson->formataRetornoJson("erro", "opção [{$this->post->opcao}] não executada com sucesso", $this->telefoneJson->retornoJson($this->manterTelefone->getTelefone()));
    }

    private function listarPorFornecedorId($fornecedorId) {
        $listaTelefones = $this->manterTelefone->listarPorFornecedorId($fornecedorId);
        $this->retornoJson = $this->telefoneJson->formataRetornoJson("sucesso", "opção [{$this->post->opcao}] executada com sucesso", $this->telefoneJson->retornoListaJson($listaTelefones));
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "inserir":
                case "alterar":
                case "excluir":
                    $this->salvar();
                    break;
                case "listarPorFornecedorId":
                    $this->listarPorFornecedorId($this->post->fornecedorId);
                    break;
                default :
                    $this->retornoJson = $this->telefoneJson->formataRetornoJson("erro", "opção [{$this->post->opcao}] inválida", NULL);
                    break;
            }
            $this->imprimirRetorno();
        } catch (\Exception $ex) {
            
        }
    }

    private function imprimirRetorno() {
        header('Content-Type: application/json');
        echo json_encode($this->retornoJson);
    }

    public function __destruct() {
        unset($this->manterTelefone, $this->telefoneJson);
    }

}

$servletTelefone = new ServletTelefone();
$servletTelefone->switchOpcao();
unset($servletTelefone);
