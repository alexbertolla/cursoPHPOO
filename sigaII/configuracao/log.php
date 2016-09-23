<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace configuracao;

/**
 * Description of log
 *
 * @author alex.bertolla
 */

class log {

    private $data;
    private $hora;
    private $usuario;
    private $tipoAcao;
    private $acao;
    private $dados;

    public function __construct() {
    }

    public function __destruct() {
    }

    function getData() {
        return $this->data;
    }

    function getHora() {
        return $this->hora;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getTipoAcao() {
        return $this->tipoAcao;
    }

    function getAcao() {
        return $this->acao;
    }

    function getDados() {
        return $this->dados;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setHora($hora) {
        $this->hora = $hora;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }


    function setTipoAcao($tipoAcao) {
        $this->tipoAcao = $tipoAcao;
    }

    function setAcao($acao) {
        $this->acao = $acao;
    }

    function setDados($dados) {
        $this->dados = $dados;
    }

}
