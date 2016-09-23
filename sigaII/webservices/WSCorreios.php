<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace webservices;

use SoapClient;

class WSCorreios {

    private $wsCliente;

    public function __construct() {
        $this->wsCliente = new SoapClient(NULL, array(
            "location" => "http://intranet.cnpat.embrapa.br/aplicacoes/sistemas/webservices/wsCorreios.php",
            "uri" => "http://intranet.cnpat.embrapa.br/aplicacoes/sistemas/webservices/",
            "trace" => 1,
            "encoding" => "UTF-8"
        ));
    }

    public function __destruct() {
        unset($this->wsCliente);
    }

    function buscarPorCep($cep) {
        return $this->wsCliente->buscarPorCep($cep);
    }

}
