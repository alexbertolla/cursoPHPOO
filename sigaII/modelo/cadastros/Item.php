<?php

/* * 
 * ***************************************************************************
 * Representação lógica dos itens no sistema. De acordo com os requisitos, a
 * classe pode se especificar em 4 classes:
 * MaterialConsumo, MaterialPermanente, Servico e Obra.
 * 
 * Atributos:
 * id: representa a chave de indexação do banco de dados e não deve ser alterado
 * pelo sistema;
 * 
 * codigo: representa o código cadastrado no SIAFI. Deve seguir o mesmo padrão e
 * regra do sistema;
 * 
 * nome: representa o nome cadastrado no SIAFI. Deve seguir o mesmo padrão e
 * regra do sistema;
 * 
 * descricao: breve descrição do item. Não precisa estar de acordo com o SIAFI;
 * 
 * situacao: Não é recomendado a exclusão do banco de dados, por isso, esse
 * atribudo indica se a natureza de despesa está ativa ou não para uso do
 * sistema.
 * 
 * dataCadastro: registra quando o item foi cadastrado. Não pode ser alterado.
 * 
 * dataAtualizacao: registra quando é feita qualquer alteração no cadastro do item;
 * 
 * sustentavel: indica se o item é sustentavel, ecologicamente correto.
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

use modelo\cadastros\AlmoxarifadoVirtual;

abstract class Item {

    protected $id;
    protected $codigo;
    protected $nome;
    protected $descricao;
    protected $sustentavel;
    protected $situacao;
    protected $dataCadastro;
    protected $dataAtualizacao;
    protected $naturezaDespesaId;
    protected $grupoId;
    protected $almoxarifadoVirtualId;
    protected $grupo;
    protected $almoxarifadoVirtual;

    public function __construct() {
        $this->grupo = new Grupo();
        $this->almoxarifadoVirtual = new AlmoxarifadoVirtual();
    }

    public function __destruct() {
        unset($this->grupo, $this->almoxarifadoVirtual);
    }

    function getId() {
        return $this->id;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getNome() {
        return $this->nome;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getSustentavel() {
        return $this->sustentavel;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function getDataCadastro() {
        return $this->dataCadastro;
    }

    function getDataAtualizacao() {
        return $this->dataAtualizacao;
    }

    function getNaturezaDespesaId() {
        return $this->naturezaDespesaId;
    }

    function getGrupoId() {
        return $this->grupoId;
    }

    function getAlmoxarifadoVirtualId() {
        return $this->almoxarifadoVirtualId;
    }

    function getGrupo() {
        return $this->grupo;
    }

    function getAlmoxarifadoVirtual() {
        return $this->almoxarifadoVirtual;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setSustentavel($sustentavel) {
        $this->sustentavel = $sustentavel;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setDataCadastro($dataCadastro) {
        $this->dataCadastro = $dataCadastro;
    }

    function setDataAtualizacao($dataAtualizacao) {
        $this->dataAtualizacao = $dataAtualizacao;
    }

    function setNaturezaDespesaId($naturezaDespesaId) {
        $this->naturezaDespesaId = $naturezaDespesaId;
    }

    function setGrupoId($grupoId) {
        $this->grupoId = $grupoId;
    }

    function setAlmoxarifadoVirtualId($almoxarifadoVirtualId) {
        $this->almoxarifadoVirtualId = $almoxarifadoVirtualId;
    }

    function setGrupo($grupo) {
        $this->grupo = $grupo;
    }

    function setAlmoxarifadoVirtual($almoxarifadoVirtual) {
        $this->almoxarifadoVirtual = $almoxarifadoVirtual;
    }

    
    function toString() {
        $string = "id=>{$this->getId()}, " .
                "codigo=>{$this->getCodigo()}, " .
                "nome=>{$this->getNome()}, " .
                "descricao=>{$this->getDescricao()}, " .
                "sustentavel=>{$this->getSustentavel()}, " .
                "dataCadastro=>{$this->getDataCadastro()}, " .
                "dataAtualizacao=>{$this->getDataAtualizacao()}, " .
                "grupoId=>{$this->getGrupoId()}, " .
                "almoxarifadoVirtualId=>{$this->getAlmoxarifadoVirtualId()}, " .
                "situacao=>{$this->getSituacao()}";
        return $string;
    }

}
