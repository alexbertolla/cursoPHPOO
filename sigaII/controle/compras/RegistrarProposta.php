<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use modelo\compras\Proposta,
    dao\compras\PropostaDao,
    configuracao\DataSistema,
    modelo\compras\ItemProposta,
    controle\cadastros\ManterFornecedorPessoaFisica,
    controle\cadastros\ManterFornecedorPessoaJuridica,
    controle\cadastros\ManterNaturezaDespesa,
    controle\compras\ManterItemPedido,
    dao\compras\ItemPropostaDao;

/**
 * Description of RegistrarProposta
 *
 * @author alex.bertolla
 */
class RegistrarProposta {

    private $proposta;
    private $propostaDao;
    private $itemProposta;
    private $itemPropostaDao;
    private $dataSistema;

    public function __construct() {
        $this->proposta = new Proposta();
        $this->propostaDao = new PropostaDao();
//        $this->itemProposta = new ItemProposta();
        $this->itemPropostaDao = new ItemPropostaDao();
        $this->dataSistema = new DataSistema();
    }

    function listarPorProcessoCompra($processoCompraId) {
        $listaProposta = $this->propostaDao->listarPorProcessoCompraDao($processoCompraId);
        $this->listaBdToForm($listaProposta);
        return $listaProposta;
    }

    function salvarProposta() {
        $this->formToBd();
        $id = $this->propostaDao->inserirDao($this->proposta->getFornecedorId(), $this->proposta->getProcessoCompraId(), $this->proposta->getData(), $this->proposta->getNumero(), $this->proposta->getValor(), $this->proposta->getTipoFornecedor());
        if ($id) {
            $this->proposta->setId($id);
            return $this->inserirItensProposta();
        }
        return $id;
    }

    private function inserirItensProposta() {
        foreach ($this->proposta->getListaItemProposta() as $itemProposta) {
            $itemProposta instanceof ItemProposta;
            $inserirItem = $this->itemPropostaDao->inserirDao($this->proposta->getId(), $itemProposta->getFornecedorId(), $itemProposta->getProcessoCompraId(), $itemProposta->getLoteId(), $itemProposta->getPedidoId(), $itemProposta->getItemId(), $itemProposta->getQuantidade(), $itemProposta->getValorUnitario(), $itemProposta->getValorTotal(), $itemProposta->getTipoFornecedor());
//            $this->autalizarGrupoFornecedor($itemProposta->getGrupoId(), $itemProposta->getFornecedorId(), $itemProposta->getTipoFornecedor());
        }
        return $inserirItem;
    }

    private function autalizarGrupoFornecedor($grupoId, $fornecedorId, $tipoFornecedor) {
        $manterFornecedor = $this->verificaTipoFornecedor($this->proposta->getTipoFornecedor());
        $manterFornecedor->atualizarGrupoFornecedor($grupoId, $fornecedorId);
        unset($manterFornecedor);
    }

    function setDetalhesListaProposta($listaProposta) {
        foreach ($listaProposta as $proposta) {
            $this->setProposta($proposta);
            $this->setDetalhesProposta();
        }
        return $listaProposta;
    }

    function setDetalhesProposta() {
        $this->setFornecedorProposta();
        $this->setListaItemProposta();
    }

    function setListaItemProposta() {
        $listaItemProposta = $this->itemPropostaDao->listarPorPropostaDao($this->proposta->getId());
        $this->setDetalhesListaItensProposta($listaItemProposta);
        $this->proposta->setLitaItemProposta($listaItemProposta);
    }

    function setDetalhesListaItensProposta($listaItemProposta) {
        foreach ($listaItemProposta as $itemProposta) {
            $this->setDetalhesItemProposta($itemProposta);
        }
    }

    function setDetalhesItemProposta($itemProposta) {
        $this->setFornecedorItem($itemProposta);
        $this->setItem($itemProposta);
    }

    function setFornecedorProposta() {
        $manterFornecedor = $this->verificaTipoFornecedor($this->proposta->getTipoFornecedor());
        $this->proposta->setFornecedor($manterFornecedor->buscarPorId($this->proposta->getFornecedorId()));
    }

    function setFornecedorItem($itemProposta) {
        $fornecedor = $this->verificaTipoFornecedor($itemProposta->getTipoFornecedor());
        $itemProposta->setFornecedor($fornecedor->buscarPorId($itemProposta->getFornecedorId()));
    }

    function setItem($itemProposta) {
        $tipoPedido = ManterItemPedido::getTipoPedidoPorId($itemProposta->getPedidoId());
        $manterItemPedido = new ManterItemPedido($tipoPedido);
        $item = $manterItemPedido->buscarItemPorId($itemProposta->getItemId());
        $itemProposta->setItem($item);
        unset($tipoPedido, $manterItemPedido, $item);
    }

    function formToBd() {
        $this->proposta->setData($this->dataSistema->BRtoISO($this->proposta->getData()));
    }

    function bdToForm() {
        $this->proposta->setData($this->dataSistema->ISOtoBR($this->proposta->getData()));
    }

    function listaBdToForm($listaProposta) {
        foreach ($listaProposta as $proposta) {
            $this->setProposta($proposta);
            $this->bdToForm();
        }
    }

    private function verificaTipoFornecedor($tipoFornecedor) {
        switch ($tipoFornecedor) {
            case "pj":
                $fornecedor = new ManterFornecedorPessoaJuridica();
                break;
            case "pf":
                $fornecedor = new ManterFornecedorPessoaFisica();
                break;
        }
        return $fornecedor;
    }

    function setAtributos($atributos) {
        $this->proposta->setId($atributos->id);
        $this->proposta->setFornecedorId($atributos->fornecedorId);
        $this->proposta->setTipoFornecedor($atributos->tipoFornecedor);
        $this->proposta->setProcessoCompraId($atributos->processoCompraId);
        $this->proposta->setNumero($atributos->numero);
        $this->proposta->setValor($atributos->valor);
        $this->proposta->setData($atributos->data);
        $this->setAtributosListaItemProposta($atributos->listaItemProposta);
    }

    function setAtributosListaItemProposta($listaItemProposta) {
        foreach ($listaItemProposta as $item) {
            $item = (object) $item;
            $itemProposta = new ItemProposta();
            $itemProposta->setPropostaId($this->proposta->getId());
            $itemProposta->setFornecedorId($this->proposta->getFornecedorId());
            $itemProposta->setProcessoCompraId($this->proposta->getProcessoCompraId());
            $itemProposta->setTipoFornecedor($this->proposta->getTipoFornecedor());

            $itemProposta->setPedidoId($item->pedidoId);
            $itemProposta->setLoteId($item->loteId);
            $itemProposta->setItemId($item->itemId);
            $itemProposta->setQuantidade($item->quantidade);
            $itemProposta->setValorUnitario($item->valorUnitario);
            $itemProposta->setValorTotal($item->valorTotal);

            $this->proposta->adicionarItemNaProposta($itemProposta);
        }
    }

    function getProposta() {
        return $this->proposta;
    }

    function setProposta($proposta) {
        $this->proposta = $proposta;
    }

}
