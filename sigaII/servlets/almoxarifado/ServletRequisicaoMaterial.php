<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace servlets\compras;

use controle\almoxarifado\ManterRequisicaoMaterial,
    visao\json\almoxarifado\RequisicaoMaterialJson,
    exception\Exception;

/**
 * Description of ServletRequisicaoMaterial
 *
 * @author alex.bertolla
 */
class ServletRequisicaoMaterial {

    private $post;
    private $manterRequisicaoMaterial;
    private $requisicaoMaterialJson;
    private $exception;

    public function __construct() {
        include_once '../../autoload.php';
        $this->post = (object) filter_input_array(INPUT_POST);
        $this->manterRequisicaoMaterial = new ManterRequisicaoMaterial();
        $this->requisicaoMaterialJson = new RequisicaoMaterialJson();
        $this->exception = new Exception();
    }

    function switchOpcao() {
        switch ($this->post->opcao) {
            case "inserir":
            case "alterar":
            case "excluir":
                $this->manterRequisicaoMaterial->setAtributos($this->post);
                $this->manterRequisicaoMaterial->setListaItemRequisicaoAtributos((object) $_POST["listaItemRequisicao"]);
                $this->salvar($this->post->opcao);
                break;

            case "enviarRequisicao":
                $this->enviarRequisicao($this->post->id);
                break;

            case "receberRequisicao":
                $this->receberRequisicao($this->post->id, $this->post->matriculaResponsavel);
                break;

            case "devolverRequisicao":
                $this->devolverRequisicao($this->post->id, $this->post->matriculaResponsavel);
                break;

            case "atenderEntregar":
            case "atenderColetar":
                $this->atenderRequisicao($this->post->id, $this->post->opcao, $this->post->matriculaResponsavel);
                break;

            case "encerrar":
                $this->encerrarRequisicao($this->post->id, $this->post->matriculaResponsavel);
                break;

            case "listarPorRequisitante":
                $this->listarPorRequisitante($this->post->matriculaRequisitante);
                break;

            case "buscarPorId":
                $this->buscarPorId($this->post->id);
                break;

            default :
                $mensagem = $this->exception->setMensagemException("OPÇÃO [{$this->post->opcao}] INVÁLIDA!");
                $this->imprimeRetorno($mensagem, NULL);
        }
    }

    private function buscarPorId($id) {
        try {
            $requisicaoMaterial = $this->manterRequisicaoMaterial->buscarPorId($id);
            $mensagem = $this->exception->mensagemOperacao($requisicaoMaterial);
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
        }

        $this->imprimeRetorno($mensagem, $this->requisicaoMaterialJson->retornoJson($requisicaoMaterial));
    }

    private function listarPorRequisitante($matriculaRequisitante) {
        try {
            $listaRequisicaoMaterial = $this->manterRequisicaoMaterial->listarPorRequisitante($matriculaRequisitante);
            $mensagem = $this->exception->mensagemOperacao($listaRequisicaoMaterial);
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
        }

        $this->imprimeRetorno($mensagem, $this->requisicaoMaterialJson->retornoListaJson($listaRequisicaoMaterial));
    }

    private function salvar($opcao) {
        try {
            $operacao = $this->manterRequisicaoMaterial->salvar($opcao);
            $mensagem = $this->exception->mensagemCadastro($operacao);
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
        }

        $this->imprimeRetorno($mensagem, $this->requisicaoMaterialJson->retornoJson($this->manterRequisicaoMaterial->getRequisicaoMaterial()));
    }

    private function enviarRequisicao($id) {
        try {
            $this->manterRequisicaoMaterial->setRequisicaoMaterial($this->manterRequisicaoMaterial->buscarPorId($id));
            $enviarRequisicao = $this->manterRequisicaoMaterial->enviarRequisicao();
            $this->manterRequisicaoMaterial->enviarEmailRequisicao();
            $this->manterRequisicaoMaterial->registrarAtividade($this->manterRequisicaoMaterial->getRequisicaoMaterial()->getMatriculaRequisitante());
            $mensagem = $this->exception->mensagemOperacao($enviarRequisicao);
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
        }

        $this->imprimeRetorno($mensagem, $this->requisicaoMaterialJson->retornoJson($this->manterRequisicaoMaterial->getRequisicaoMaterial()));
    }

    private function receberRequisicao($id, $matriculaResponsavel) {
        try {
            $requisicao = $this->manterRequisicaoMaterial->buscarPorId($id);
            $requisicao->setMatriculaResponsavel($matriculaResponsavel);
            $this->manterRequisicaoMaterial->setRequisicaoMaterial($requisicao);
            $receber = $this->manterRequisicaoMaterial->receberRequisicao($id, $matriculaResponsavel);
            $this->manterRequisicaoMaterial->enviarEmailRequisicao();
            $this->manterRequisicaoMaterial->registrarAtividade($matriculaResponsavel);
            $mensagem = $this->exception->mensagemOperacao($receber);
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
        }
        $this->imprimeRetorno($mensagem, $this->requisicaoMaterialJson->retornoJson($this->manterRequisicaoMaterial->getRequisicaoMaterial()));
    }

    private function devolverRequisicao($id, $matriculaResponsavel) {
        try {
            $this->manterRequisicaoMaterial->buscarPorId($id);
            $devolver = $this->manterRequisicaoMaterial->devolverRequisicao();
            $this->manterRequisicaoMaterial->enviarEmailRequisicao();
            $this->manterRequisicaoMaterial->registrarAtividade($matriculaResponsavel);
            $mensagem = $this->exception->mensagemOperacao($devolver);
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
        }

        $this->imprimeRetorno($mensagem, $this->requisicaoMaterialJson->retornoJson($this->manterRequisicaoMaterial->getRequisicaoMaterial()));
    }

    private function atenderRequisicao($id, $opcao, $matriculaResponsavel) {
        try {
            $this->manterRequisicaoMaterial->buscarPorId($id);
            $atender = $this->manterRequisicaoMaterial->atender($opcao);
            $this->manterRequisicaoMaterial->enviarEmailRequisicao();
            $this->manterRequisicaoMaterial->registrarAtividade($matriculaResponsavel);
            $mensagem = $this->exception->mensagemOperacao($atender);
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
        }

        $this->imprimeRetorno($mensagem, $this->requisicaoMaterialJson->retornoJson($this->manterRequisicaoMaterial->getRequisicaoMaterial()));
    }

    private function encerrarRequisicao($id, $matriculaResponsavel) {
        try {
            $this->manterRequisicaoMaterial->buscarPorId($id);
            $encerrar = $this->manterRequisicaoMaterial->encerrarRequisicao();
            $this->manterRequisicaoMaterial->enviarEmailRequisicao();
            $this->manterRequisicaoMaterial->registrarAtividade($matriculaResponsavel);
            $this->manterRequisicaoMaterial->registrarSaidaMaterial();
            $mensagem = $this->exception->mensagemOperacao($encerrar);
        } catch (\Exception $ex) {
            $mensagem = $this->exception->setMensagemException($ex->getMessage());
        }

        $this->imprimeRetorno($mensagem, $this->requisicaoMaterialJson->retornoJson($this->manterRequisicaoMaterial->getRequisicaoMaterial()));
    }

    private function imprimeRetorno($mensagem, $dados) {
        header('Content-Type: application/json');
        $retornoJson = $this->requisicaoMaterialJson->formataRetornoJson($mensagem->getEstado(), $mensagem->getMensagem(), $dados);
        echo json_encode($retornoJson);
    }

    public function __destruct() {
        unset($this->exception, $this->post, $this->manterRequisicaoMaterial, $this->requisicaoMaterialJson);
    }

}

$servletRequisicaoMaterial = new ServletRequisicaoMaterial();
$servletRequisicaoMaterial->switchOpcao();
unset($servletRequisicaoMaterial);
