<?php

/* * 
 * ***************************************************************************
 * Classe estendida da classe Item. Representação lógica dos itens que se
 * referem a materiais de consumo.
 * 
 * Atributos:
 * controlado: se o item é controlado por algum órgão
 * 
 * marca: marca do item
 * 
 * modelo: modelo do item
 * 
 * partNumber: 
 * 
 * codSinap:
 * 
 * estoqueMax: quantidade máxima no estoque*
 *
 * estoqueMin: quantidade mínima no estoque*
 * 
 * estoqueAtual: quantidade atual no estoque*
 * 
 * orgaoControladorId: chave de indexação estrangeira. Utilizada apenas para
 * facilitar manituplação no banco de dados. Não deve ser alterarda pelo sistema
 * 
 * apresentacaoComercialId: chave de indexação estrangeira. Utilizada apenas para
 * facilitar manituplação no banco de dados. Não deve ser alterarda pelo sistema
 * 
 * orgaoControlador: Relacionamento com a classe OrgaoControlado. Não obrigatório
 * 
 * apresentacaoComercial: relacionamento com a classe ApresentacaoComercial.
 * 
 * centroDeCusto: relacionamento com a classe CentroDeCusto. É um array, pois
 * pode ter vários centro de custos.
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

use ArrayObject,
    modelo\cadastros\OrgaoControlador,
    modelo\cadastros\ItemControlado,
    modelo\cadastros\ApresentacaoComercial;

class MaterialConsumo extends Item {

    private $controlado;
    private $marca;
    private $modelo;
    private $partNumber;
    private $codigoSinap;
    private $estoqueMaximo;
    private $estoqueMinimo;
    private $estoqueAtual;
    private $orgaoControladorId;
    private $itemControladoId;
    private $apresentacaoComercialId;
    private $orgaoControlador;
    private $itemControlado;
    private $apresentacaoComercial;
    private $centroDeCusto;

    public function __construct() {
        parent::__construct();
        $this->orgaoControlador = new OrgaoControlador();
        $this->itemControlado = new ItemControlado();
        $this->apresentacaoComercial = new ApresentacaoComercial();
        $this->centroDeCusto = new ArrayObject();
    }

    public function __destruct() {
        parent::__destruct();
        unset($this->orgaoControlador, $this->apresentacaoComercial, $this->centroDeCusto);
    }

    function getControlado() {
        return $this->controlado;
    }

    function getMarca() {
        return $this->marca;
    }

    function getModelo() {
        return $this->modelo;
    }

    function getPartNumber() {
        return $this->partNumber;
    }

    function getCodigoSinap() {
        return $this->codigoSinap;
    }

    function getEstoqueMaximo() {
        return $this->estoqueMaximo;
    }

    function getEstoqueMinimo() {
        return $this->estoqueMinimo;
    }

    function getEstoqueAtual() {
        return $this->estoqueAtual;
    }

    function getOrgaoControladorId() {
        return $this->orgaoControladorId;
    }

    function getItemControladoId() {
        return $this->itemControladoId;
    }

    function getApresentacaoComercialId() {
        return $this->apresentacaoComercialId;
    }

    function getOrgaoControlador() {
        return $this->orgaoControlador;
    }

    function getItemControlado() {
        return $this->itemControlado;
    }

    function getApresentacaoComercial() {
        return $this->apresentacaoComercial;
    }

    function getCentroDeCusto() {
        return $this->centroDeCusto;
    }

    function setControlado($controlado) {
        $this->controlado = $controlado;
    }

    function setMarca($marca) {
        $this->marca = $marca;
    }

    function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    function setPartNumber($partNumber) {
        $this->partNumber = $partNumber;
    }

    function setCodigoSinap($codigoSinap) {
        $this->codigoSinap = $codigoSinap;
    }

    function setEstoqueMax($estoqueMax) {
        $this->estoqueMaximo = $estoqueMax;
    }

    function setEstoqueMin($estoqueMin) {
        $this->estoqueMinimo = $estoqueMin;
    }

    function setEstoqueAtual($estoqueAtual) {
        $this->estoqueAtual = $estoqueAtual;
    }

    function setOrgaoControladorId($orgaoControladorId) {
        $this->orgaoControladorId = $orgaoControladorId;
    }

    function setItemControladoId($itemControladoId) {
        $this->itemControladoId = $itemControladoId;
    }

    function setApresentacaoComercialId($apresentacaoComercialId) {
        $this->apresentacaoComercialId = $apresentacaoComercialId;
    }

    function setOrgaoControlador($orgaoControlador) {
        $this->orgaoControlador = $orgaoControlador;
    }

    function setItemControlado($itemControlado) {
        $this->itemControlado = $itemControlado;
    }

    function setApresentacaoComercial($apresentacaoComercial) {
        $this->apresentacaoComercial = $apresentacaoComercial;
    }

    function setCentroDeCusto($centroDeCusto) {
        $this->centroDeCusto = $centroDeCusto;
    }

    function adicionarCentroDeCusto(CentroDeCusto $centroDeCusto) {
        $this->centroDeCusto->append($centroDeCusto);
    }

    function toString() {
        $string = "(" . parent::toString() . "," .
                "marca=>{$this->getMarca()}, " .
                "modelo=>{$this->getModelo()}, " .
                "partNumber=>{$this->getPartNumber()}, " .
                "controlado=>{$this->getControlado()}, " .
                "estoqueAtual=>{$this->getEstoqueAtual()}, " .
                "estoqueMinimo=>{$this->getEstoqueMinimo()}, " .
                "estoqueMaximo=>{$this->getEstoqueMaximo()}, " .
                "codigoSinapi=>{$this->getCodigoSinap()}, " .
                "apresentacaoComercialId=>{$this->getApresentacaoComercialId()}, " .
                "orgaoControladorId=>{$this->getOrgaoControladorId()}, " .
                "itemControladoId=>{$this->getItemControladoId()}" .
                ")";
        return $string;
    }

}
