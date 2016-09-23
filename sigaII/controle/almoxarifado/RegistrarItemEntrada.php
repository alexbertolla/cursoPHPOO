<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\almoxarifado;

use modelo\almoxarifado\ItemEntrada,
    dao\almoxarifado\ItemEntradaDao,
    modelo\almoxarifado\EntradaMaterial;

/**
 * Description of RegistrarItemEntrada
 *
 * @author alex.bertolla
 */
class RegistrarItemEntrada {

    private $itemEntrada;
    private $itemEntradaDao;

    public function __construct() {
        $this->itemEntrada = new ItemEntrada();
        $this->itemEntradaDao = new ItemEntradaDao();
    }

    function inserir() {
        return $this->itemEntradaDao->inserirDao($this->itemEntrada->getEntradaId(), $this->itemEntrada->getFornecedorId(), $this->itemEntrada->getItemId(), $this->itemEntrada->getGrupoId(), $this->itemEntrada->getQuantidade(), $this->itemEntrada->getValorUnitario(), $this->itemEntrada->getValorTotal());
    }

    function excluirPorEntradaId($entradaId) {
        return $this->itemEntradaDao->excluirPorEntradaIdDao($entradaId);
    }

    function listarPorEntradaId($entradaId) {
        $listaItemEntrada = $this->itemEntradaDao->listarPorEntradaIdDao($entradaId);
        
        return $listaItemEntrada;
    }

    function getItemEntrada() {
        return $this->itemEntrada;
    }

    function setAtributos($atributos) {
        $itemEntrada = new ItemEntrada();
        $itemEntrada->setEntradaId($atributos->entradaId);
        $itemEntrada->setFornecedorId($atributos->fornecedorId);
        $itemEntrada->setItemId($atributos->itemId);
        $itemEntrada->setGrupoId($atributos->grupoId);
        $itemEntrada->setQuantidade($atributos->quantidade);
        $itemEntrada->setValorUnitario($atributos->valorUnitario);
        $itemEntrada->setValorTotal($atributos->valorTotal);
        return $itemEntrada;
    }

    function setItemEntrada($itemEntrada) {
        $this->itemEntrada = $itemEntrada;
    }

    public function __destruct() {
        unset($this->itemEntrada, $this->itemEntradaDao);
    }

}
