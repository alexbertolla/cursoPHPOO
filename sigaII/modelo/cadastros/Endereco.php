<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\cadastros;

/**
 * Description of Endereco
 *
 * @author alex.bertolla
 */
class Endereco {

    private $id;
    private $fornecedorId;
    private $logradouro;
    private $numero;
    private $complemento;
    private $bairro;
    private $cidade;
    private $estado;
    private $cep;
    private $pais;

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

    function getLogradouro() {
        return $this->logradouro;
    }

    function getNumero() {
        return $this->numero;
    }

    function getComplemento() {
        return $this->complemento;
    }

    function getBairro() {
        return $this->bairro;
    }

    function getCidade() {
        return $this->cidade;
    }

    function getEstado() {
        return $this->estado;
    }

    function getCep() {
        return $this->cep;
    }

    function getPais() {
        return $this->pais;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFornecedorId($fornecedorId) {
        $this->fornecedorId = $fornecedorId;
    }

    function setLogradouro($logradouro) {
        $this->logradouro = $logradouro;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setComplemento($complemento) {
        $this->complemento = $complemento;
    }

    function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setCep($cep) {
        $this->cep = $cep;
    }

    function setPais($pais) {
        $this->pais = $pais;
    }

    function toString() {
        $string = "(" .
                "id=>{$this->getId()}, " .
                "fornecedorId=>{$this->getFornecedorId()}, " .
                "logradouro=>{$this->getLogradouro()}, " .
                "numero=>{$this->getNumero()}, " .
                "complemento=>{$this->getComplemento()}, " .
                "bairro=>{$this->getBairro()}, " .
                "cidade=>{$this->getCidade()}, " .
                "estado=>{$this->getEstado()}, " .
                "cep=>{$this->getCep()}, " .
                "pais=>{$this->getPais()}"
                . ")";
        return $string;
    }

}
