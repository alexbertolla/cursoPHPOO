<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\almoxarifado;

use modelo\almoxarifado\ItemRequisicao,
    dao\almoxarifado\ItemRequisicaoDao,
    bibliotecas\moeda\Moeda,
    controle\almoxarifado\GerenciarEstoque;

/**
 * Description of ManterItemRequisicaoMaterial
 *
 * @author egidio.ramalho
 */
class ManterItemRequisicaoMaterial {

    private $itemRequisicaoDao;
    private $itemRequisicao;

    public function __construct() {
        $this->itemRequisicao = new ItemRequisicao();
        $this->itemRequisicaoDao = new ItemRequisicaoDao();
    }

    function registrarSaidaMaterial() {
        $gerenciarEstoque = new GerenciarEstoque();
        return $gerenciarEstoque->registrarSaidaItem($this->itemRequisicao);
    }

    function listaBdToForm($listaItemRequisicao) {
        foreach ($listaItemRequisicao as $itemRequisicao) {
            $this->setItemRequisicao($itemRequisicao);
            $this->setItemEstoque($itemRequisicao->getItemEstoqueId());
            $this->formatarNumero();
        }

        return $listaItemRequisicao;
    }

    private function setItemEstoque($itemEstoqueId) {
        $gerenciarEstoque = new GerenciarEstoque();
        $itemEstoque = $gerenciarEstoque->buscarPorId($itemEstoqueId);
        $this->itemRequisicao->setItemEstoque($itemEstoque);
        unset($gerenciarEstoque);
    }

    private function formatarNumero() {
        $moeda = new Moeda();
        $this->itemRequisicao->setValorUnitario($moeda->formatarReal($this->itemRequisicao->getValorUnitario()));
        unset($moeda);
    }

    function inserir() {
        return $this->itemRequisicaoDao->inserirDao($this->itemRequisicao->getRequisicaoId(), $this->itemRequisicao->getItemEstoqueId(), $this->itemRequisicao->getItemId(), $this->itemRequisicao->getQuantidade(), $this->itemRequisicao->getValorUnitario(), $this->itemRequisicao->getValorTotal());
    }

    function excluir($requisicaoId) {
        return $this->itemRequisicaoDao->excluirDao($requisicaoId);
    }

    function listarItensRequisicaoPorId($requisicaoId) {
        $lista = $this->itemRequisicaoDao->listarPorRequisicaoIdDao($requisicaoId);
        $this->listaBdToForm($lista);
        return $lista;
    }

    function setAtributos($atributos) {
        $itemRequisicao = new ItemRequisicao();
        $itemRequisicao->setItemEstoqueId($atributos->itemEstoqueId);
        $itemRequisicao->setItemId($atributos->itemId);
        $itemRequisicao->setQuantidade($atributos->quantidade);
        $itemRequisicao->setRequisicaoId($atributos->requisicaoId);
        $itemRequisicao->setValorUnitario($atributos->valorUnitario);
        return $itemRequisicao;
    }

    function getItemRequisicao() {
        return $this->itemRequisicao;
    }

    function setItemRequisicao($itemRequisicao) {
        $this->itemRequisicao = $itemRequisicao;
    }

}
