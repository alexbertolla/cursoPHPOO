<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use modelo\compras\ProcessoCompra,
    controle\cadastros\ManterModalidade,
    sgp\Funcionario,
    configuracao\DataSistema,
    controle\compras\GerenciarLoteProcessoCompra,
    dao\compras\ProcessoCompraDao,
    controle\compras\ManterSituacaoProcessoCompra,
    controle\compras\ManterOrdemDeCompra,
    modelo\compras\EnumSituacaoProcessoDeCompra;

/**
 * Description of ManterProcessoCompra
 *
 * @author alex.bertolla
 */
class ManterProcessoCompra {

    private $processoCompra;
    private $processoCompraDao;
    private $dataSistema;
    private $situacaoDao;

    public function __construct() {
        $this->processoCompra = new ProcessoCompra();
        $this->processoCompraDao = new ProcessoCompraDao();
        $this->dataSistema = new DataSistema();
        $this->situacaoDao = new ManterSituacaoProcessoCompra();
    }

    function listarAberto() {
        $lista = $this->processoCompraDao->listarAbertoDao();
        return $this->listaBdToForm($lista);
    }

    function listar() {
        $lista = $this->processoCompraDao->listarDao();
        $this->listaBdToForm($lista);
        return $lista;
    }

    function buscarPorId($id) {
        $this->setProcessoCompra($this->processoCompraDao->buscarPorIdDao($id));
        $this->bdToForm();
        return $this->getProcessoCompra();
    }

    function buscarPorNumero($numero) {
        $this->setProcessoCompra($this->processoCompraDao->buscarPorNumeroDao($numero));
        $this->bdToForm();
        return $this->getProcessoCompra();
    }

    function listarConsolidados() {
        $lista = $this->processoCompraDao->listarConsolidadosDao();
        $this->listaBdToForm($lista);
        return $lista;
    }

    function buscarConsolidadoPorId($id) {
        $this->setProcessoCompra($this->processoCompraDao->buscarConsolidadosPorIdDao($id));
        $this->bdToForm();
//        $this->consolidarLista();
        return $this->getProcessoCompra();
    }

    function salvar($opcao) {
        $this->decode();
        switch ($opcao) {
            case "inserir" :
                $resultado = $this->inserir();
                break;
            case "alterar":
                $resultado = $this->alterar();
                break;
            case "excluir" :
                $resultado = $this->excluir();
                break;
            case "encerrar" :
                $resultado = $this->encerrar();
                break;
            case "bloquear" :
                $resultado = $this->bloquear();
                break;
            case "consolidar":
                $resultado = $this->consolidar();
                break;
        }
        return $resultado;
    }

    private function inserir() {
        $situacao = $this->situacaoDao->buscarPorCodigo(EnumSituacaoProcessoDeCompra::AbertoItens);
        $this->processoCompra->setSituacaoId($situacao->getId());
        $id = $this->processoCompraDao->inserirDao($this->processoCompra->getNumero(), $this->processoCompra->getModalidadeId(), $this->processoCompra->getNumeroModalidade(), $this->processoCompra->getResponsavel(), $this->processoCompra->getObjeto(), $this->processoCompra->getJustificativa(), $situacao->getId());
        $this->processoCompra->setId($id);
        if ($id) {
            $this->setDadosProcesso();
            $this->gerarLote();
            $this->encode();
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function alterar() {

        $alterar = $this->processoCompraDao->alterarDao($this->processoCompra->getId(), $this->processoCompra->getNumero(), $this->processoCompra->getModalidadeId(), $this->processoCompra->getNumeroModalidade(), $this->processoCompra->getObjeto(), $this->processoCompra->getJustificativa());
        $this->buscarPorId($this->processoCompra->getId());
        $this->setDadosProcesso();

        return $alterar;
    }

    private function excluir() {
        return $this->processoCompraDao->excluirDao($this->processoCompra->getId());
    }

    private function consolidar() {
        $situacao = $this->situacaoDao->buscarPorCodigo(EnumSituacaoProcessoDeCompra::Finalizado);
        $consolidar = $this->processoCompraDao->consolidarDao($this->processoCompra->getId(), $situacao->getId());
        $this->setProcessoCompra($this->buscarPorId($this->processoCompra->getId()));
        $this->conslolidarItemProcesso();
        $this->setDadosProcesso();
        return $consolidar;
    }

    private function conslolidarItemProcesso() {
        $manterItemProcesso = new ManterItemProcessoCompra();
        $manterItemProcesso->consolidar($this->processoCompra->getId());
        $manterItemProcesso->gerarOrdemDeCompraPorFornecedores($this->processoCompra->getId());
    }

    private function bloquear() {
        $codigoSituacao = ($this->processoCompra->getBloqueado()) ? EnumSituacaoProcessoDeCompra::FechadoIntes : EnumSituacaoProcessoDeCompra::AbertoItens;
        $situacao = $this->situacaoDao->buscarPorCodigo($codigoSituacao);
        $bloquear = $this->processoCompraDao->bloquearDao($this->processoCompra->getId(), $this->processoCompra->getBloqueado(), $situacao->getId());
        $this->setProcessoCompra($this->buscarPorId($this->processoCompra->getId()));
        $this->setDadosProcesso();
        return $bloquear;
    }

    private function encerrar() {
        $encerrar = $this->processoCompraDao->encerrarDao($this->processoCompra->getId());
        $this->setProcessoCompra($this->buscarPorId($this->processoCompra->getId()));
        $this->setDadosProcesso();
        return $encerrar;
    }

    function gerarLote() {
        $gerenciarLote = new GerenciarLoteProcessoCompra();
        $gerenciarLote->gerarLote($this->processoCompra->getId(), $this->processoCompra->getModalidadeId());
        $this->processoCompra->addLote($gerenciarLote->getLoteProcessoCompra());
    }

    function removerItemDoLote($loteId, $processoCompraId, $itemId) {
        $gerenciarLote = new GerenciarLoteProcessoCompra();
        $gerenciarLote->alterarLoteItem($loteId, $processoCompraId, $itemId);
    }

    private function listaBdToForm($lista) {
        foreach ($lista as $processoCompra) {
            $this->setProcessoCompra($processoCompra);
            $this->bdToForm();
        }
        return $lista;
    }

    private function bdToForm() {
        $this->processoCompra->setDataAbertura($this->dataSistema->ISOtoBR($this->processoCompra->getDataAbertura()));
        $this->processoCompra->setDataEncerramento($this->dataSistema->ISOtoBR($this->processoCompra->getDataEncerramento()));
        $this->encode();
    }

    function setDadosListaProcesso($lista) {
        foreach ($lista as $processoCompra) {
            $this->setProcessoCompra($processoCompra);
            $this->setDadosProcesso();
        }
        return $lista;
    }

    function setDadosProcesso() {
        $this->setModalidade();
        $this->setResponsavel();
        $this->setListaLotes();
        $this->setSituacao();
    }

    function setListaLotes() {
        $gerenciarLote = new GerenciarLoteProcessoCompra();
        $listaLotes = $gerenciarLote->listarPorProcessoCompra($this->processoCompra->getId());
        foreach ($listaLotes as $lote) {
            $gerenciarLote->setLoteProcessoCompra($lote);
            ($this->processoCompra->getBloqueado() === "0") ? $gerenciarLote->SetItensLote() : $gerenciarLote->setItensLoteConsolidado();
        }
        $this->processoCompra->setListaLoteProcessoCompra($listaLotes);
    }

    function setModalidade() {
        $modalidade = new ManterModalidade();
        $this->processoCompra->setModalidade($modalidade->buscarPorId($this->processoCompra->getModalidadeId()));
        unset($modalidade);
    }

    function setResponsavel() {
        $funcionario = new Funcionario();
        $this->processoCompra->setResponsavelClass($funcionario->buscarPorMatricula($this->processoCompra->getResponsavel()));
        unset($funcionario);
    }

    function setSituacao() {
        $this->processoCompra->setSituacao($this->situacaoDao->buscarPorId($this->processoCompra->getSituacaoId()));
    }

    function getProcessoCompra() {
        return $this->processoCompra;
    }

    function setProcessoCompra($processoCompra) {
        $this->processoCompra = $processoCompra;
    }

    private function encode() {
        $this->processoCompra->setObjeto($this->utf8Encode($this->processoCompra->getObjeto()));
        $this->processoCompra->setJustificativa($this->utf8Encode($this->processoCompra->getJustificativa()));
    }

    private function decode() {
        $this->processoCompra->setObjeto($this->utf8Decode($this->processoCompra->getObjeto()));
        $this->processoCompra->setJustificativa($this->utf8Decode($this->processoCompra->getJustificativa()));
    }

    private function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    private function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    function setAtributos($atributos) {
        $this->processoCompra->setId($atributos->id);
        $this->processoCompra->setNumero($atributos->numero);
        $this->processoCompra->setModalidadeId($atributos->modalidadeId);
        $this->processoCompra->setNumeroModalidade($atributos->numeroModalidade);
        $this->processoCompra->setResponsavel($atributos->responsavel);
        $this->processoCompra->setObjeto($atributos->objeto);
        $this->processoCompra->setJustificativa($atributos->justificativa);
        $this->processoCompra->setBloqueado($atributos->bloqueado);
    }

    public function __destruct() {
        unset($this->processoCompra, $this->processoCompraDao);
    }

}
