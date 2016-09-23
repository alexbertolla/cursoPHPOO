<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WSldap
 *
 * @author alex.bertolla
 */

namespace webservices;

use SoapClient;

class WSlogin {

    private $wsCliente;

    function __construct() {
        $this->wsCliente = new SoapClient(NULL, array(
            "location" => "http://backup.cnpat.embrapa.br/aplicacoes/sistemas/webservices/wsLogin.php",
            "uri" => "http://backup.cnpat.embrapa.br/aplicacoes/sistemas/webservices/",
            "trace" => 1,
            "encoding" => "UTF-8"
        ));
    }

    public function __destruct() {
        unset($this->wsCliente);
    }

    function autenticar($user, $pass, $system) {
        return $this->wsCliente->logar($user, $pass, $system);
    }

}
