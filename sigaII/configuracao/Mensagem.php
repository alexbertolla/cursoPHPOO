<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace configuracao;

/**
 * Description of Mensagem
 *
 * @author alex.bertolla
 */
class Mensagem {

    private $id;
    private $codigo;
    private $estado;
    private $mensagem;

    public function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getEstado() {
        return $this->estado;
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

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }

    public function __destruct() {
        
    }

}
