<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\almoxarifado;

/**
 * Description of SituacaoRequisicao
 *
 * @author alex.bertolla
 */
class SituacaoRequisicao {

    private $id;
    private $codigo;
    private $situacao;
    private $mensagem;

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

}
