<?php

/* * 
 * ***************************************************************************
 * Classe estendida da classe Item. Representação lógica dos itens que se
 * referem a obras.
 * 
 * Atributos:
 * responsavel: funcionário responsável pela obra
 * 
 * bemPrincial: se for reforma, a que setor se refere
 * 
 * local: localidade da obra, Sede, CEP ou CEC
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

class Obra extends Item {

    private $responsavelClass;
    private $responsavel;
    private $bemPrincipalClass;
    private $bemPrincipal;
    private $local;

    public function __construct() {
        parent::__construct();
    }

    public function __destruct() {
        parent::__destruct();
    }

    function getResponsavelClass() {
        return $this->responsavelClass;
    }

    function getResponsavel() {
        return $this->responsavel;
    }

    function getBemPrincipalClass() {
        return $this->bemPrincipalClass;
    }

    function getBemPrincipal() {
        return $this->bemPrincipal;
    }

    function getLocal() {
        return $this->local;
    }

    function setResponsavelClass($responsavelClass) {
        $this->responsavelClass = $responsavelClass;
    }

    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    function setBemPrincipalClass($bemPrincipalClass) {
        $this->bemPrincipalClass = $bemPrincipalClass;
    }

    function setBemPrincipal($bemPrincipal) {
        $this->bemPrincipal = $bemPrincipal;
    }

    function setLocal($local) {
        $this->local = $local;
    }

    function toString() {
        $string = "(" . parent::toString() . ", " .
                "responsavel=>{$this->getResponsavel()}, " .
                "bemPrincipal=>{$this->getBemPrincipal()}, " .
                "local=>{$this->getLocal()})";
        return $string;
    }

}
