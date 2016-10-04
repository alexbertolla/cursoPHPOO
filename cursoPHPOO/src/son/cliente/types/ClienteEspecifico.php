<?php

namespace son\cliente\types;
use son\cliente\interfaces\EnderecoComprancaInterface;
use son\cliente\interfaces\ClienteInterface;


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
