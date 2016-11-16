<?php

namespace son\cliente\types;

use son\cliente\ClienteAbstract;

class ClientePF extends ClienteAbstract {

    private $cpf;

    public function __construct($id, $nome, $documento, $endereco, $telefone, $email, $grauImportancia) {
        parent::__construct($id, $nome, $endereco, $telefone, $email, $grauImportancia);
        $this->cpf = $documento;
    }

    public function getDocumento() {
        return $this->cpf;
    }

    public function setDocumento($documento) {
        $this->cpf = $documento;
    }

}
