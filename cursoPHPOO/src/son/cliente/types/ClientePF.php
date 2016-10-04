<?php

namespace son\cliente\types;

use son\cliente\ClienteAbstract;

class ClientePF extends ClienteAbstract {

    private $cpf;

    public function __construct($nome, $documento, $endereco, $telefone, $email) {
        parent::__construct($nome, $endereco, $telefone, $email);
        $this->cpf = $documento;
    }

    public function getDocumento() {
        return $this->cpf;
    }

    public function setDocumento($documento) {
        $this->cpf = $documento;
    }

}
