<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\compras;

use controle\almoxarifado\RegistrarEntradaMaterial,
    visao\json\almoxarifado\EntradaMaterialJson,
    exception\Exception;

/**
 * Description of ServletEntradaMaterial
 *
 * @author alex.bertolla
 */
class ServletEntradaMaterial {

    //put your code here
    private $post;
    private $registrarEntradaMaterial;
    private $entradaMaterialJson;
    private $exception;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->registrarEntradaMaterial = new RegistrarEntradaMaterial();
        $this->entradaMaterialJson = new EntradaMaterialJson();
        $this->exception = new Exception();
    }

    function switchOpcao() {
        try {


            switch ($this->post->opcao) {
                case "salvar":
                    $this->registrarEntradaMaterial->setAtributos($this->post);
                    $this->registrarEntradaMaterial->setAtributosItemEntrada((object) $_POST["listaItemEntrada"]);
                    $this->salvar();
                    break;
                case "listar":
                    $this->listar();
                    break;

                case "buscarPorNumero":
                    $this->buscarPorNumero($this->post->numero);
                    break;
            }
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
            $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function salvar() {
        $operacao = $this->registrarEntradaMaterial->registrarEntradaMaterial();
        $mensagem = $this->exception->mensagemCadastro($operacao);
        $this->imprimeRetorno($mensagem, $this->entradaMaterialJson->retornoJson($this->registrarEntradaMaterial->getEntrada()));
    }

    private function listar() {
        $listaEntrada = $this->registrarEntradaMaterial->listar();
        var_dump($listaEntrada);
    }

    private function buscarPorNumero($numero) {
        $entradaMaterial = $this->registrarEntradaMaterial->buscarPorNumero($numero);
        $mensagem = $this->exception->mensagemOperacao($entradaMaterial);
        $this->imprimeRetorno($mensagem, $this->entradaMaterialJson->retornoJson($entradaMaterial));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->entradaMaterialJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

}

$servlet = new ServletEntradaMaterial();
$servlet->switchOpcao();
unset($servlet);
