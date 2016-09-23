<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\compras;

/**
 * Description of SituacaoItemPedido
 *
 * @author alex.bertolla
 */
class SituacaoItemPedido {

    private $id;
    private $codigo;
    private $situacao;
    private $mensagem;
    private $enviaEmail;

    function getId() {
        return $this->id;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function getMensagem() {
        return $this->mensagem;
    }

    function getEnviaEmail() {
        return $this->enviaEmail;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }

    function setEnviaEmail($enviaEmail) {
        $this->enviaEmail = $enviaEmail;
    }

}
