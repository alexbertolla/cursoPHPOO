<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\webservices;

use sof\PA,
    visao\json\PAJson,
    exception\Exception;

/**
 * Description of ServletPA
 *
 * @author alex.bertolla
 */
class ServletPA {

    private $pa;
    private $paJson;
    private $post;
    private $exception;

    public function __construct() {
        include_once '../../autoload.php';
        $this->pa = new PA();
        $this->paJson = new PAJson();
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->exception = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "listarPA":
                    if ($this->post->parametro) {
                        $this->listarPA($this->post->ano, $this->post->parametro);
                    } else {
                        $this->listarPA($this->post->ano);
                    }

                    break;
                case "buscarPaPorId":
                    $this->buscarPaPorId($this->post->id);
                    break;
                
                case "buscarPaSaldoPorId":
                    $this->buscarPaSaldoPorId($this->post->id, $this->post->ano);
                    break;
                default :
                    throw new \Exception("Opcao [{$this->post->opcao}] invalida");
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function buscarPaPorId($id) {
        $pa = $this->pa->buscarPaPorId($id);
        $mensagem = $this->exception->mensagemOperacao($pa);
        $this->imprimeRetorno($mensagem, $this->paJson->retornoJson($pa));
    }
    
     private function buscarPaSaldoPorId($id, $ano) {
        $pa = $this->pa->buscarPaSaldoPorId($id, $ano);
        $mensagem = $this->exception->mensagemOperacao($pa);
        $this->imprimeRetorno($mensagem, $this->paJson->retornoJson($pa));
    }

    private function listarPA($ano, $parametro = '%') {
        $listaPA = $this->pa->listarPA($ano, $parametro);
        $mensagem = $this->exception->mensagemOperacao($listaPA);
        $this->imprimeRetorno($mensagem, $this->paJson->retornoListaJson($listaPA));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->paJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->exception, $this->pa, $this->paJson, $this->post);
    }

}

$servlet = new ServletPA();
$servlet->switchOpcao();
