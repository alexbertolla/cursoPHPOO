<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\compras;

use modelo\cadastros\Grupo,
    modelo\cadastros\NaturezaDespesa,
    modelo\compras\ItemPedido,
    sgp\Funcionario,
    sgp\Lotacao,
    ArrayObject,
    sof\PA,
    modelo\compras\SituacaoPedido;

/**
 * Description of Pedido
 *
 * @author alex.bertolla
 */
class Pedido {

    private $id;
    private $numero;
    private $solicitante;
    private $matriculaSolicitante;
    private $pa;
    private $paId;
    private $lotacao;
    private $lotacaoId;
    private $justificativa;
    private $grupo;
    private $grupoId;
    private $naturezaDespesa;
    private $naturezaDespesaId;
    private $listaItemPedido;
    private $bloqueado;
    private $dataCriacao;
    private $dataEnvio;
    private $ano;
    private $tipo;
    private $situacaoId;
    private $situacao;

    public function __construct() {
        $this->solicitante = new Funcionario();
        $this->lotacao = new Lotacao();
        $this->grupo = new Grupo();
        $this->naturezaDespesa = new NaturezaDespesa();
        $this->listaItemPedido = new ArrayObject();
        $this->pa = new PA();
        $this->situacao = new SituacaoPedido();
    }

    function adicionarItemPedido(ItemPedido $itemPedido) {
        $this->listaItemPedido->append($itemPedido);
    }

    function removerItemPedido(ItemPedido $itemPedido) {
        foreach ($this->listaItemPedido as $chave => $valor) {
            if ($valor === $itemPedido) {
                $this->listaItemPedido->offsetUnset($chave);
            }
        }
    }

    function getId() {
        return $this->id;
    }

    function getNumero() {
        return $this->numero;
    }

    function getSolicitante() {
        return $this->solicitante;
    }

    function getMatriculaSolicitante() {
        return $this->matriculaSolicitante;
    }

    function getPa() {
        return $this->pa;
    }

    function getPaId() {
        return $this->paId;
    }

    function getLotacao() {
        return $this->lotacao;
    }

    function getLotacaoId() {
        return $this->lotacaoId;
    }

    function getJustificativa() {
        return $this->justificativa;
    }

    function getGrupo() {
        return $this->grupo;
    }

    function getGrupoId() {
        return $this->grupoId;
    }

    function getNaturezaDespesa() {
        return $this->naturezaDespesa;
    }

    function getNaturezaDespesaId() {
        return $this->naturezaDespesaId;
    }

    function getListaItemPedido() {
        return $this->listaItemPedido;
    }

    function getBloqueado() {
        return $this->bloqueado;
    }

    function getDataCriacao() {
        return $this->dataCriacao;
    }

    function getDataEnvio() {
        return $this->dataEnvio;
    }

    function getAno() {
        return $this->ano;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getSituacaoId() {
        return $this->situacaoId;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setSolicitante($solicitante) {
        $this->solicitante = $solicitante;
    }

    function setMatriculaSolicitante($matriculaSolicitante) {
        $this->matriculaSolicitante = $matriculaSolicitante;
    }

    function setPa($pa) {
        $this->pa = $pa;
    }

    function setPaId($paId) {
        $this->paId = $paId;
    }

    function setLotacao($lotacao) {
        $this->lotacao = $lotacao;
    }

    function setLotacaoId($lotacaoId) {
        $this->lotacaoId = $lotacaoId;
    }

    function setJustificativa($justificativa) {
        $this->justificativa = $justificativa;
    }

    function setGrupo($grupo) {
        $this->grupo = $grupo;
    }

    function setGrupoId($grupoId) {
        $this->grupoId = $grupoId;
    }

    function setNaturezaDespesa($naturezaDespesa) {
        $this->naturezaDespesa = $naturezaDespesa;
    }

    function setNaturezaDespesaId($naturezaDespesaId) {
        $this->naturezaDespesaId = $naturezaDespesaId;
    }

    function setListaItemPedido($listaItemPedido) {
        $this->listaItemPedido = $listaItemPedido;
    }

    function setBloqueado($bloqueado) {
        $this->bloqueado = $bloqueado;
    }

    function setDataCriacao($dataCriacao) {
        $this->dataCriacao = $dataCriacao;
    }

    function setDataEnvio($dataEnvio) {
        $this->dataEnvio = $dataEnvio;
    }

    function setAno($ano) {
        $this->ano = $ano;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setSituacaoId($situacaoId) {
        $this->situacaoId = $situacaoId;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function toString() {
        $string = "("
                . "id=>{$this->getId()}, "
                . "numero=>{$this->getNumero()}, "
                . "matriculaSolicitante=>{$this->getMatriculaSolicitante()}, "
                . "paId=>{$this->getPaId()}, "
                . "lotacaoId=>{$this->getLotacaoId()}, "
                . "justificativa=>{$this->getJustificativa()}, "
                . "grupoId=>{$this->getGrupoId()}, "
                . "naturezaDespesaId=>{$this->getNaturezaDespesaId()}, "
//                . "listaItens=>{$this->getListaItens()}, "
                . "bloqueado=>{$this->getBloqueado()}, "
                . "dataCriacao=>{$this->getDataCriacao()}, "
                . "dataEnvio=>{$this->getDataEnvio()}, "
                . "ano=>{$this->getAno()}, "
                . "tipo=>{$this->getTipo()}"
                . ")";
        return $string;
    }

    public function __destruct() {
        unset($this->grupo, $this->listaItemPedido, $this->lotacao, $this->pa, $this->solicitante, $this->pa, $this->naturezaDespesa);
    }

}
