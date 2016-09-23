<?php

/* * 
 * ***************************************************************************
 * Classe estendida da classe Item. Representação lógica dos itens que se
 * referem a serviços.
 * 
 * Atributos:
 * tipo: indica se é serviço de pessoa física ou jurídica.
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

class Servico extends Item {

    private $tipo;

    public function __construct() {
        parent::__construct();
    }

    public function __destruct() {
        parent::__destruct();
    }

    function getTipo() {
        return $this->tipo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function toString() {
        $string = "(" . parent::toString() . ", " .
                "tipo=>{$this->getTipo()})";
        return $string;
    }

}
