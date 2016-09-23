<?php

/* * 
 * ***************************************************************************
 * Classe estendida da classe Item. Representação lógica dos itens que se
 * referem a materiais permanentes - Equipamentos.
 * 
 * Atributos:
 * marca: marca do item
 * 
 * modelo: modelo do item
 * 
 * partNumber: 
 * 
 * Alex Bisetto Bertolla
 * alex.bertolla@embrapa.br
 * (85)3391-7163
 * Núcleo de Tecnologia da Informação
 * Embrapa Agroidústria Tropical
 * 
 * ***************************************************************************
 */

namespace modelo\cadastros;

class MaterialPermanente extends Item {

    private $marca;
    private $modelo;
    private $partNumber;

    public function __construct() {
        parent::__construct();
    }

    public function __destruct() {
        parent::__destruct();
    }

    function getMarca() {
        return $this->marca;
    }

    function getModelo() {
        return $this->modelo;
    }

    function getPartNumber() {
        return $this->partNumber;
    }

    function setMarca($marca) {
        $this->marca = $marca;
    }

    function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    function setPartNumber($partNumber) {
        $this->partNumber = $partNumber;
    }

    function toString() {
        $string = "(" . parent::toString() . "," .
                "marca=>{$this->getMarca()}" .
                "modelo=>{$this->getModelo()}" .
                "partNumber=>{$this->getPartNumber()}" .
                ")";
        return $string;
    }

}
