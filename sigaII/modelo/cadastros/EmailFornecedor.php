<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\cadastros;

/**
 * Description of Email
 *
 * @author alex.bertolla
 */
class EmailFornecedor {

    private $id;
    private $fornecedorId;
    private $email;

    public function __construct() {
        
    }

    public function __destruct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getFornecedorId() {
        return $this->fornecedorId;
    }

    function getEmail() {
        return $this->email;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFornecedorId($fornecedorId) {
        $this->fornecedorId = $fornecedorId;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function toString() {
        $string = "(" .
                "id=>{$this->getId()}, " .
                "email=>{$this->getEmail()}, " .
                "fornecedorId=>{$this->getFornecedorId()}"
                . ")";
        return $string;
    }

}
