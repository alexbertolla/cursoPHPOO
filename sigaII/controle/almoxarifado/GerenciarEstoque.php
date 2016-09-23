<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\almoxarifado;

use modelo\almoxarifado\ItemEstoque,
    modelo\almoxarifado\ItemEntrada,
    modelo\almoxarifado\ItemRequisicao,
    dao\almoxarifado\ItemEstoqueDao,
    controle\cadastros\ManterMaterialConsumo;

/**
 * Description of GerenciarEstoque
 *
 * @author alex.bertolla
 */
class GerenciarEstoque {

    private $itemEstoque;
    private $itemEstoqueDao;

    public function __construct() {
        $this->itemEstoque = new ItemEstoque();
        $this->itemEstoqueDao = new ItemEstoqueDao();
    }

    function listar() {
        $listaItemEstoque = $this->itemEstoqueDao->listarDao();
        $this->setInfoListaItem($listaItemEstoque);
        return $listaItemEstoque;
    }

    function buscarPorId($id) {
        $this->setItemEstoque($this->itemEstoqueDao->buscarPorIdDao($id));
        $this->setInfoItem();
        return $this->getItemEstoque();
    }

    function registrarEntradaItem(ItemEntrada $itemEntrada) {
        $itemEstoque = $this->itemEstoqueDao->buscarPorItemIdDao($itemEntrada->getItemId());
        if ($itemEstoque) {
            $this->setItemEstoque($itemEstoque);
            $precoMedio = $this->calcularPrecoMedio($itemEstoque, $itemEntrada);
            $this->itemEstoque->setPrecoMedio(number_format($precoMedio, 2));
            $diferencaContabil = $this->calcularDiferencaContabil($precoMedio);
            $this->itemEstoque->setDiferencaContabil($diferencaContabil);
            $novaQuantidade = $this->itemEstoque->getQuantidade() + $itemEntrada->getQuantidade();
            $this->itemEstoque->setQuantidade($novaQuantidade);
            return $this->atualizarEstoqueEntrada();
        } else {
            return $this->registrarNovoItem($itemEntrada);
        }
    }
    
    function registrarSaidaItem(ItemRequisicao $itemRequisicao) {
        $itemEstoque = $this->itemEstoqueDao->buscarPorItemIdDao($itemRequisicao->getItemId());
        if ($itemEstoque) {
            $this->setItemEstoque($itemEstoque);
//            $novaQuantidade = $this->itemEstoque->getQuantidade() - $itemRequisicao->getQuantidade();
//            $this->itemEstoque->setQuantidade($novaQuantidade);
            $this->itemEstoque->saidaItem($itemRequisicao->getQuantidade());
            return $this->atualizarEstoqueRequisicao();
        } else {
            return FALSE;
        }
    }

    private function registrarNovoItem(ItemEntrada $itemEntrada) {
        $this->itemEstoque->setQuantidade($itemEntrada->getQuantidade());
        $this->itemEstoque->setPrecoMedio($itemEntrada->getValorUnitario());
        $this->itemEstoque->setDiferencaContabil(0);
        $this->itemEstoque->setItemId($itemEntrada->getItemId());
        $this->itemEstoque->setFornecedorId($itemEntrada->getFornecedorId());
        return $this->inserir();
    }

    private function inserir() {
        return $this->itemEstoqueDao->inserirDao($this->itemEstoque->getQuantidade(), $this->itemEstoque->getPrecoMedio(), $this->itemEstoque->getDiferencaContabil(), $this->itemEstoque->getItemId(), $this->itemEstoque->getFornecedorId());
    }

    private function atualizarEstoqueRequisicao() {
        return $this->itemEstoqueDao->atualizarEstoqueDao($this->itemEstoque->getId(), $this->itemEstoque->getQuantidade());
    }
    
    private function atualizarEstoqueEntrada() {
        return $this->itemEstoqueDao->atualizarEstoqueDao($this->itemEstoque->getId(), $this->itemEstoque->getQuantidade(), $this->itemEstoque->getPrecoMedio(), $this->itemEstoque->getDiferencaContabil());
    }

    private function calcularPrecoMedio($itemEstoque, $itemEntrada) {
        $saldoEstoque = $itemEstoque->getPrecoMedio() * $itemEstoque->getQuantidade();
        $valorEntrada = $itemEntrada->getValorTotal();
        $precoMedio = ($saldoEstoque + $valorEntrada) / ($itemEstoque->getQuantidade() + $itemEntrada->getQuantidade());
        return $precoMedio;
    }

    private function calcularDiferencaContabil($precoMedio) {
        return ($precoMedio - $this->itemEstoque->getPrecoMedio()) / $this->itemEstoque->getQuantidade();
    }

    function setInfoListaItem($listaItemEstoque) {
        foreach ($listaItemEstoque as $itemEstoque) {
            $this->setItemEstoque($itemEstoque);
            $this->setInfoItem();
        }
        return $listaItemEstoque;
    }

    function setInfoItem() {
        $manterMC = new ManterMaterialConsumo();
        $item = $manterMC->buscarPorId($this->itemEstoque->getItemId());
        $this->itemEstoque->setItem($item);
        unset($manterMC);
    }

    function getItemEstoque() {
        return $this->itemEstoque;
    }

    function setItemEstoque($itemEstoque) {
        $this->itemEstoque = $itemEstoque;
    }

    public function __destruct() {
        unset($this->itemEstoque, $this->itemEstoqueDaos);
    }

}
