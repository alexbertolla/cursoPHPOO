<?php

namespace servlets\cadastros;

use controle\cadastros\ManterEmailFornecedor,
    visao\json\cadastros\EmailFornecedorJson,
    modelo\cadastros\EmailFornecedor,
    ArrayObject;

class ServletEmail {

    private $post;
    private $manterEmail;
    private $emailJson;
    private $retornoJson;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterEmail = new ManterEmailFornecedor();
        $this->emailJson = new EmailFornecedorJson();
    }

    public function __destruct() {
        unset($this->manterEmail, $this->emailJson);
    }

    private function setListaEmail() {
        $listaEmail = $_POST["listaEmail"];
        if (count($listaEmail) > 0) {
            $lista = new ArrayObject();

            foreach ($listaEmail as $mail) {
                $email = new EmailFornecedor();
                $email->setEmail($mail["email"]);
                $email->setFornecedorId($this->post->fornecedorId);
                $lista->append($email);
            }
            return $lista;
        } else {
            return NULL;
        }
    }

    private function salvar() {
        $fornecedorId = $this->post->fornecedorId;
        $this->manterEmail->setAtributos($this->post);
        $this->manterEmail->salvar("excluir");

        $listaEmail = $this->setListaEmail();
        $operacao = TRUE;
        if ($listaEmail) {
            foreach ($listaEmail as $email) {
                $email = (object) $email;
                $this->manterEmail->setEmail($email);
                $operacao = $this->manterEmail->salvar($this->post->opcao);
            }
        }

        $this->retornoJson = ($operacao) ? $this->emailJson->formataRetornoJson("sucesso", "opcao [{$this->post->opcao}] executada com sucesso", $this->emailJson->retornoListaJson($this->manterEmail->listarPorFornecedorId($fornecedorId))) :
                $this->emailJson->formataRetornoJson("erro", "opção [{$this->post->opcao}] não foi executada com sucesso", $this->emailJson->retornoJson($this->manterEmail->getEmail()));
    }

    private function listarPorFornecedorId() {
        $listaEmails = $this->manterEmail->listarPorFornecedorId($this->post->fornecedorId);
        $this->retornoJson = $this->emailJson->formataRetornoJson("sucesso", "opcao [{$this->post->opcao}] executada com sucesso", $this->emailJson->retornoListaJson($listaEmails));
    }

    private function imprimirRetorno() {
        header('Content-Type: application/json');
        echo json_encode($this->retornoJson);
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
                    $this->listarPorFornecedorId();
                    break;
                default :
                    $this->retornoJson = $this->emailJson->formataRetornoJson("erro", "operação [{$this->post->opcao}] inválida!", NULL);
            }

            $this->imprimirRetorno();
        } catch (\Exception $ex) {
            
        }
    }

}

$servletEmail = new ServletEmail();
$servletEmail->switchOpcao();
unset($servletEmail);

/*
header('Content-Type: application/json');
include_once '../autoload.php';

use modelo\Email,
    controle\ManterEmail,
    visao\json\EmailJson;

$opcao = filter_input(INPUT_POST, "opcao");
$id = filter_input(INPUT_POST, "id");
$email = filter_input(INPUT_POST, "email");
$fornecedorId = filter_input(INPUT_POST, "fornecedorId");

$manterEmail = new ManterEmail();
$emailJson = new EmailJson();


switch ($opcao) {
    case "inserir";
    case "excluir":
        $emailClass = new Email();
        $emailClass->setId($id);
        $emailClass->setEmail($email);
        $emailClass->setFornecedorId($fornecedorId);
        $resutlado = $manterEmail->salvar($opcao, $emailClass);

        $retorno = ($resutlado) ?
                $emailJson->formataRetornoJson("sucesso", "operação [{$opcao}] executada com sucesso", $emailJson->retornoJson($resutlado)) :
                $emailJson->formataRetornoJson("erro", "operação [{$opcao}] falhou", $emailJson->retornoJson($resutlado));
        break;
    case "listarPorFornecedorId":
        $listaEmails = $manterEmail->listarPorFornecedorId($fornecedorId);
        $retorno = $emailJson->formataRetornoJson("sucesso", "busca executada com sucesso", $emailJson->retornoListaJson($listaEmails));
        break;
    default :
        $retorno = $emailJson->formataRetornoJson("erro", "operação [{$opcao}] inválida!", NULL);
        break;
}

echo json_encode($retorno);

unset($manterEmail, $emailJson);
*/