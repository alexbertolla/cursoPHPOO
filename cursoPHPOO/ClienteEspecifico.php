<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClienteEspecifico
 *
 * @author alex.bertolla
 */
include_once './EnderecoComprancaInterface.php';

class ClienteEspecifico implements EnderecoComprancaInterface {

    private $cliente;
    private $enderecoCobranca;

    public function __construct(ClienteInterface $cliente, $enderecoCobranca) {
        $this->cliente = $cliente;
        $this->enderecoCobranca = $enderecoCobranca;
    }

    function getCliente() {
        return $this->cliente;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    function setEnderecoCobranca($enderecoCobranca) {
        $this->enderecoCobranca = $enderecoCobranca;
    }

    function getEnderecoCobranca() {
        return $this->enderecoCobranca;
    }

}
