<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 * @author alex.bertolla
 */

namespace configuracao;

use sgp\Funcionario;

class Usuario extends Funcionario {

    private $nomeUsuario;
    private $idPerfil;
    private $nomePerfil;

    public function __construct() {
        parent::__construct();
    }

    public function __destruct() {
        parent::__destruct();
    }

    function getNomeUsuario() {
        return $this->nomeUsuario;
    }

    function getIdPerfil() {
        return $this->idPerfil;
    }

    function getNomePerfil() {
        return $this->nomePerfil;
    }

    function setNomeUsuario($nomeUsuario) {
        $this->nomeUsuario = $nomeUsuario;
    }

    function setIdPerfil($idPerfil) {
        $this->idPerfil = $idPerfil;
    }

    function setNomePerfil($nomePerfil) {
        $this->nomePerfil = $nomePerfil;
    }

    function setDadosFuncional($dadosFuncional) {
        $this->setMatricula($dadosFuncional->getMatricula());
        $this->setNome($dadosFuncional->getNome());
        $this->setLotacao($dadosFuncional->getLotacao());
        $this->setEmail($dadosFuncional->getEmail());
    }

    function toString() {
        $string = "(" .
                "matricula=>{$this->getMatricula()}, " .
                "nome=>{$this->getNome()}, " .
                "nomeUsuario=>{$this->getNomeUsuario()}, " .
                "perfil=>{$this->getNomePerfil()}"
                . ")";
        return $string;
    }

}
