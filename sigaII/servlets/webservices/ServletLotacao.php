<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\webservices;

use sgp\Lotacao,
    visao\json\LotacaoJson,
    exception\Exception;

/**
 * Description of ServletLotacao
 *
 * @author alex.bertolla
 */
class ServletLotacao {

    private $lotacao;
    private $lotacaoJson;
    private $post;
    private $exception;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->lotacao = new Lotacao();
        $this->lotacaoJson = new LotacaoJson();
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
        $listaLotacao = $this->lotacao->listar();
        $mensagem = $this->exception->mensagemOperacao($listaLotacao);
        $this->imprimeRetorno($mensagem, $this->lotacaoJson->retornoListaJson($listaLotacao));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->lotacaoJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->exception, $this->lotacao, $this->lotacaoJson, $this->post);
    }

}

$servlet = new ServletLotacao();
$servlet->switchOpcao();
unset($servlet);
