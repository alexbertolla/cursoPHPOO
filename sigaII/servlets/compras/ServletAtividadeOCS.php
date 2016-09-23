<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\compras;

use controle\compras\RegistrarAtividadeOCS,
    visao\json\compras\AtividadeOCSJson,
    exception\Exception;

/**
 * Description of ServletAtividadeOCS
 *
 * @author alex.bertolla
 */
class ServletAtividadeOCS {

    private $post;
    private $registrarAtividadeOCS;
    private $atividadeOCSJson;
    private $excpetion;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->registrarAtividadeOCS = new RegistrarAtividadeOCS();
        $this->atividadeOCSJson = new AtividadeOCSJson();
        $this->excpetion = new Exception();
    }

    function switchOpcao() {
        try {
            switch ($this->post->opcao) {
                case "registrarAtividade":
                    $this->registrarAtividadeOCS->setAtributos($this->post);
                    $this->registrarAtividade();
                    break;
                case "listarAtividadePorOrdemDeCompra":
                    $this->listarAtividadePorOrdemDeCompra($this->post->ordemCompraId);
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function registrarAtividade() {
        $operacao = $this->registrarAtividadeOCS->registrarAtividade();
        $mensagem = $this->excpetion->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->atividadeOCSJson->retornoJson($this->registrarAtividadeOCS->getAtividadeOCS()));
    }

    private function listarAtividadePorOrdemDeCompra($ordemDeCompraId) {
        $listaAtividadeOCS = $this->registrarAtividadeOCS->listarAtividadePorOCS($ordemDeCompraId);
        $mensagem = $this->excpetion->mensagemCadastro($listaAtividadeOCS);
        $this->imprimeRetorno($mensagem, $this->atividadeOCSJson->retornoListaJson($listaAtividadeOCS));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->atividadeOCSJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->post, $this->registrarAtividadeOCS, $this->atividadeOCSJson, $this->excpetion);
    }

}

$servleAtividadeOCS = new ServletAtividadeOCS();
$servleAtividadeOCS->switchOpcao();
unset($servleAtividadeOCS);
exit();
