<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cliente
 *
 * @author alex.bertolla
 */
class Cliente {

    public $nome;
    public $cpf;
    public $endereco;
    public $telefone;
    public $email;

    public function __construct($nome, $cpf, $endereco, $telefone, $email) {
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->endereco = $endereco;
        $this->telefone = $telefone;
        $this->email = $email;
    }
    
    
    
   

}
