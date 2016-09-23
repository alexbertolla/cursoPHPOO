<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ServletSGP
 *
 * @author alex.bertolla
 */

namespace servlets\webservices;

use sgp\Funcionario,
    visao\json\FuncionarioJson,
    exception\Exception;

class ServletFuncionario {

    private $funcionario;
    private $funcionarioJson;
    private $post;
    private $exception;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->funcionario = new Funcionario();
        $this->funcionarioJson = new FuncionarioJson();
        $this->exception = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "listar":
                    $this->listar();
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function listar() {
        $listaFuncionario = $this->funcionario->listar();
        $mensagem = $this->exception->mensagemOperacao($listaFuncionario);
        $this->imprimeRetorno($mensagem, $this->funcionarioJson->retornoListaJson($listaFuncionario));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->funcionarioJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->funcionario, $this->funcionarioJson, $this->post, $this->exception);
    }

}

$servlet = new ServletFuncionario();
$servlet->switchOpcao();
unset($servlet);
