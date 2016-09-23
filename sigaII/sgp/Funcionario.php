<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Funcionario
 *
 * @author alex.bertolla
 */

namespace sgp;

use sgp\Lotacao,
    webservices\WSsgp,
    ArrayObject;

class Funcionario {

    private $matricula;
    private $nome;
    private $email;
    private $lotacao;

    public function __construct() {
        $this->lotacao = new Lotacao();
    }

    function buscarPorMatricula($matricula) {
        $wsSGP = new WSsgp();
        $funcionario = $wsSGP->buscarFuncionarioEfetivoPorMatricula($matricula);
        unset($wsSGP);
        return $funcionario;
    }

    function listar() {
        $wsSGP = new WSsgp();
        $lista = $wsSGP->listarFuncionarioEfetivo();
        unset($wsSGP);
        return $lista;
    }
    
    function listarPorNome($nome) {
        $wsSGP = new WSsgp();
        $lista = $wsSGP->listarFuncionarioEfetivoPorNome($nome);
        unset($wsSGP);
        return $lista;
    }

    public function __destruct() {
        unset($this->lotacao);
    }

    function getMatricula() {
        return $this->matricula;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getLotacao() {
        return $this->lotacao;
    }

    function setMatricula($matricula) {
        $this->matricula = $matricula;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setLotacao(Lotacao $lotacao) {
        $this->lotacao = $lotacao;
    }

}
