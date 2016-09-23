<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use modelo\compras\OrdemDeCompra,
    dao\compras\OrdemDeCompraDao,
    controle\compras\ManterItemOrdemDeCompra,
    controle\compras\ManterItemProcessoCompra,
    controle\compras\ManterEmpenho,
    configuracao\DataSistema,
    controle\AdapterFornecedor,
    controle\cadastros\ManterDadosBancarios,
    controle\compras\ManterSituacaoOCS,
    modelo\compras\EnumSituacaoOCS,
    modelo\compras\EnumSituacaoItemPedido;

/**
 * Description of ManterOrdemServico
 *
 * @author alex.bertolla
 */
class ManterOrdemDeCompra {

    private $ordemDeCompra;
    private $ordemDeCompraDao;
    private $manterItemOrdemDeCompra;
    private $dataSistema;
    private $situacao;

    public function __construct() {
        $this->ordemDeCompra = new OrdemDeCompra();
        $this->ordemDeCompraDao = new OrdemDeCompraDao();
        $this->manterItemOrdemDeCompra = new ManterItemOrdemDeCompra();
        $this->dataSistema = new DataSistema();
        $this->situacao = new ManterSituacaoOCS();
    }

    function gerarNova($tipoFornecedor, $processoCompraId, $fornecedorId) {
        $situacao = $this->situacao->buscarPorCodigo(EnumSituacaoOCS::EmEdicao);
        $id = $this->ordemDeCompraDao->novaOrdemDeCompraDao($tipoFornecedor, $processoCompraId, $fornecedorId, $situacao->getId());
        if ($id) {
            $this->ordemDeCompraDao->gerarNumeroDao($id);
            $this->ordemDeCompra->setId($id);
            $this->gerarNovoEmpenho();
            $this->inserirItemOrdemCompra();
        }
        return $id;
    }

    function gerarNovoEmpenho() {
        $manterEmpenho = new ManterEmpenho();
        $manterEmpenho->inserirNovoEmpenhoPorOredemDeCompra($this->ordemDeCompra->getId());
        unset($manterEmpenho);
    }

    function efetivarEmissao() {
        $situacao = $this->situacao->buscarPorCodigo(EnumSituacaoOCS::Emitida);
        $this->ordemDeCompra->setSituacao($situacao);
        $this->setListaItemOrdemDeCompra();
        $this->ordemDeCompra->calcularValor();
        return $this->ordemDeCompraDao->efetivarEmissaoDao($this->ordemDeCompra->getId(), $this->ordemDeCompra->getDadosBancarioId(), $this->ordemDeCompra->getValor(), $this->ordemDeCompra->getPrazo(), $situacao->getId());
    }

    function assinaturaFornecedor() {
        $situacao = $this->situacao->buscarPorCodigo(EnumSituacaoOCS::AssinadaFornecedor);
        $this->ordemDeCompra->setSituacao($situacao->getId());
        $this->ordemDeCompra->setDataAssinatura($this->dataSistema->BRtoISO($this->ordemDeCompra->getDataAssinatura()));
        $this->ordemDeCompra->atualizaDataEntrega($this->ordemDeCompra->getDataAssinatura());
        return $this->ordemDeCompraDao->assinaturaFornecedorDao($this->ordemDeCompra->getDataAssinatura(), $this->ordemDeCompra->getDataPrazoEntrega(), $this->ordemDeCompra->getId(), $situacao->getId());
    }

    function atualizarPrazo() {
        $dataReferencia = date("Y-m-d");
        $this->ordemDeCompra->atualizaDataEntrega($dataReferencia);
        return $this->ordemDeCompraDao->atualizarPrazoDao($this->ordemDeCompra->getPrazo(), $this->ordemDeCompra->getDataPrazoEntrega(), $this->ordemDeCompra->getId());
    }

    function inserirItemOrdemCompra() {
        return $this->manterItemOrdemDeCompra->inserirPorNovaOrdemCompra();
    }

    function verificaGerarNovaSequencia() {
        foreach ($this->ordemDeCompra->getListaItemProcessoCompra() as $itemProcesso) {
            if ($itemProcesso->getQuantidade() > 0) {
                $this->gerarNovaSequencia();
                return TRUE;
            }
        }
    }

    private function gerarNovaSequencia() {
        $situacao = $this->situacao->buscarPorCodigo(EnumSituacaoOCS::EmEdicao);
        $this->ordemDeCompraDao->novaSequenciaDao($this->ordemDeCompra->getId(), $this->ordemDeCompra->getNumero(), $situacao->getId());
    }

    function atualizarSituacaoItemPedido() {
        $listaItemProcesso = $this->ordemDeCompra->getListaItemProcessoCompra();
        foreach ($listaItemProcesso as $itemProcessoCompra) {
            $manterItemProcesso = new ManterItemProcessoCompra();
            $manterItemProcesso->setItemProcessoCompra($itemProcessoCompra);
            $manterItemProcesso->atualizarSituacaoItemPedido(EnumSituacaoItemPedido::OCSEmitida);
        }
    }

    function buscarPorId($id) {
        $this->setOrdemDeCompra($this->ordemDeCompraDao->buscarPorIdDao($id));
        $this->bdToForm();
        $this->setDadosOrdemDeCompra();
        return $this->getOrdemDeCompra();
    }

    function buscarPorNumeroESequencia($numero, $sequencia) {
        $this->setOrdemDeCompra($this->ordemDeCompraDao->buscarPorNumeroESequenciaDao($numero, $sequencia));
        $this->bdToForm();
        $this->setDadosOrdemDeCompra();
        return $this->getOrdemDeCompra();
    }

    function listarPorNumero($numero) {
        $listaOrdemDeCompra = $this->ordemDeCompraDao->listarPorNumeroDao($numero);
        $this->listaBdToForm($listaOrdemDeCompra);
        return $listaOrdemDeCompra;
    }

    function listarPorFornecedorId($processoCompraId, $fornecedorId) {
        $listaOrdemDeCompra = $this->ordemDeCompraDao->listarPorFornecedorIdDao($processoCompraId, $fornecedorId);
        $this->listaBdToForm($listaOrdemDeCompra);
        return $listaOrdemDeCompra;
    }

    function listarAgrupadasPorFornecedor($processoCompraId) {
        $listaOrdemDeCompra = $this->ordemDeCompraDao->listarAgrupadasPorFornecedorDao($processoCompraId);
        $this->setDadosListaOrdemDeCompra($listaOrdemDeCompra);
        $this->listaBdToForm($listaOrdemDeCompra);
        return $listaOrdemDeCompra;
    }

    function listarItemProcessoPorOrdemDeCompra() {
        $manterItemProcesso = new ManterItemProcessoCompra();
        $listaItemProcessoCompra = $manterItemProcesso->listarParaMontarOrdemDeCompraDao($this->ordemDeCompra->getNumero(), $this->ordemDeCompra->getSequencia());
        $this->ordemDeCompra->setListaItemProcessoCompra($listaItemProcessoCompra);
        unset($manterItemProcesso);
    }

    function setDadosListaOrdemDeCompra($listaOrdemDeCompra) {
        foreach ($listaOrdemDeCompra as $ordemDeCompra) {
            $this->setOrdemDeCompra($ordemDeCompra);
            $this->setDadosOrdemDeCompra();
        }
        return $listaOrdemDeCompra;
    }

    function setDadosOrdemDeCompra() {
        $this->setFornecedor();
        $this->listarItemProcessoPorOrdemDeCompra();
        $this->setListaItemOrdemDeCompra();
        $this->setListaEmpeho();
        $this->setSituacao();
    }

    function setSituacao() {
        $this->ordemDeCompra->setSituacao($this->situacao->buscarPorId($this->ordemDeCompra->getSituacaoId()));
    }

    function setFornecedor() {
        $tipoFornecedor = $this->ordemDeCompra->getTipoFornecedor();
        $adapterFornecedor = new AdapterFornecedor($tipoFornecedor);
        $fornecedor = $adapterFornecedor->buscarPorId($this->ordemDeCompra->getFornecedorId());
        $this->ordemDeCompra->setFornecedor($fornecedor);
    }

    function setDadosBancario() {
        $manterDB = new ManterDadosBancarios();
        $this->ordemDeCompra->setDadosBancario($manterDB->buscarPorId($this->ordemDeCompra->getDadosBancarioId()));
        unset($manterDB);
    }

    function setListaItemOrdemDeCompra() {
        $listaItemOrdemDeCompra = $this->manterItemOrdemDeCompra->listarPorOrdemDeCompra($this->ordemDeCompra->getId());
        $this->ordemDeCompra->setListaItemOrdemDeCompra($listaItemOrdemDeCompra);
    }

    function setListaEmpeho() {
        $manterEmpenho = new ManterEmpenho();
        $this->ordemDeCompra->setListaEmpenho($manterEmpenho->listarPorOrdemDeCompra($this->ordemDeCompra->getId()));
        unset($manterEmpenho);
    }

    function listaBdToForm($listaOrdemDeCompra) {
        foreach ($listaOrdemDeCompra as $ordemDeCompra) {
            $this->setOrdemDeCompra($ordemDeCompra);
            $this->bdToForm();
        }
        return $listaOrdemDeCompra;
    }

    function bdToForm() {
        $this->ordemDeCompra->setDataEmissao($this->dataSistema->ISOtoBR($this->ordemDeCompra->getDataEmissao()));
        $this->ordemDeCompra->setDataAssinatura($this->dataSistema->ISOtoBR($this->ordemDeCompra->getDataAssinatura()));
        $this->ordemDeCompra->setDataPrazoEntrega($this->dataSistema->ISOtoBR($this->ordemDeCompra->getDataPrazoEntrega()));
    }

    function setAtributos($atributos) {
        $this->ordemDeCompra->setId($atributos->id);
        $this->ordemDeCompra->setNumero($atributos->numero);
        $this->ordemDeCompra->setSequencia($atributos->sequencia);
        $this->ordemDeCompra->setValor($atributos->valor);
        $this->ordemDeCompra->setTipoFornecedor($atributos->tipoFornecedor);
        $this->ordemDeCompra->setFornecedorId($atributos->fornecedorId);
        $this->ordemDeCompra->setProcessoCompraId($atributos->processoCompraId);
        $this->ordemDeCompra->setDadosBancarioId($atributos->dadosBancarioId);
        $this->ordemDeCompra->setBancoId($atributos->bancoId);
        $this->ordemDeCompra->setPrazo($atributos->prazo);
        $this->ordemDeCompra->setDataEmissao($atributos->dataEmissao);
        $this->ordemDeCompra->setDataAssinatura($atributos->dataAssinatura);
        $this->ordemDeCompra->setDataPrazoEntrega($atributos->dataPrazoEntrega);
    }

    function setAtributosItemOrdemDeCompra($atributos) {
        $this->manterItemOrdemDeCompra->setAtributos($atributos);
        return $this->inserirItemOrdemCompra();
    }

    function getOrdemDeCompra() {
        return $this->ordemDeCompra;
    }

    function setOrdemDeCompra($ordemDeCompra) {
        $this->ordemDeCompra = $ordemDeCompra;
    }

    function getManterItemOrdemDeCompra() {
        return $this->manterItemOrdemDeCompra;
    }

    function setManterItemOrdemDeCompra($manterItemOrdemDeCompra) {
        $this->manterItemOrdemDeCompra = $manterItemOrdemDeCompra;
    }

    public function __destruct() {
        unset($this->ordemDeCompra, $this->ordemDeCompraDao, $this->dataSistema, $this->manterItemOrdemDeCompra);
    }

}
