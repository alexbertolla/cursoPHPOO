<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\compras\impressao;

use modelo\compras\ProcessoCompra,
    ArrayObject;

/**
 * Description of RegistroOrcamentario
 *
 * @author alex.bertolla
 */
class RegistroOrcamentario {

    private $processoCompra;
    private $listaItensEmpenho;

    public function __construct() {
        $this->processoCompra = new ProcessoCompra();
        $this->listaItensEmpenho = new ArrayObject();
    }

    function getProcessoCompra() {
        return $this->processoCompra;
    }

    function getListaItensEmpenho() {
        return $this->listaItensEmpenho;
    }

    function setProcessoCompra($processoCompra) {
        $this->processoCompra = $processoCompra;
    }

    function setListaItensEmpenho($listaItensEmpenho) {
        $this->listaItensEmpenho = $listaItensEmpenho;
    }

}
