<?php

namespace son\cliente\types;

use son\cliente\ClienteAbstract;

class ClientePJ extends ClienteAbstract {

    private $cnpj;

    public function __construct($nome, $documento, $endereco, $telefone, $email) {
        parent::__construct($nome, $endereco, $telefone, $email);
        $this->cnpj = $documento;
    }

    public function getDocumento() {
        return $this->cnpj;
    }

    public function setDocumento($documento) {
        $this->cnpj = $documento;
    }

}
