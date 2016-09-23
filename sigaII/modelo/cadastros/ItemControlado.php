<?php

namespace modelo\cadastros;
use modelo\cadastros\OrgaoControlador;
/* * 
 * ***************************************************************************
 * Representação lógica dos intens controlados.
 * 
 * Atributos:
 * id: representa a chave de indexação do banco de dados e não deve ser alterado
 * pelo sistema;

 * 
 * nome: nome do item controlado, não é necessariamente igual ao item cadastrado
 * no sistema;
 * 
 * fonte: Fonte do documento no qual o órgão controlador indica qual o item e a
 * quantidade controlada;
 * 
 * quantidade: quantidade controlada do item;
 * 
 * apresentacaoComercial: apresentação comercial do item controlado, não está
 * relacionado a classe ApresentacaoComercial;
 * 
 * situacao: Não é recomendado a exclusão do banco de dados, por isso, esse
 * atribudo indica se a natureza de despesa está ativa ou não para uso do
 * sistema.
 * 
 * orgaoControladorId: chave estrangeira de indexação do banco de dados. utilizado
 * apenas para facilitar inserção e consultas. não deve ser alterado pelo sistema;
 * 
 * orgaoControlador: relacionamento com a classe OrgaoControlador. Pelos requisitos,
 * um item é controlado somente por um órgão.
 * 
 * grupoId:chave estrangeira de indexação do banco de dados. utilizado
 * apenas para facilitar inserção e consultas. não deve ser alterado pelo sistema;
 * 
 * grupo: relacionamento com a classe Grupo.
 * 
 * Alex Bisetto Bertolla
 * alex.bertolla@embrapa.br
 * (85)3391-7163
 * Núcleo de Tecnologia da Informação
 * Embrapa Agroidústria Tropical
 * 
 * ***************************************************************************
 */



class ItemControlado {

    private $id;
    private $nome;
    private $fonte;
    private $quantidade;
    private $apresentacaoComercial;
    private $situacao;
    private $orgaoControladorId;
    private $orgaoControlador;
    private $grupoId;
    private $grupo;

    public function __construct() {
        $this->orgaoControlador = new OrgaoControlador();
        $this->grupo = new Grupo();
    }

    public function __destruct() {
        unset($this->orgaoControlador, $this->grupo);
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getFonte() {
        return $this->fonte;
    }

    function getQuantidade() {
        return $this->quantidade;
    }

    function getApresentacaoComercial() {
        return $this->apresentacaoComercial;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function getOrgaoControladorId() {
        return $this->orgaoControladorId;
    }

    function getOrgaoControlador() {
        return $this->orgaoControlador;
    }

    function getGrupoId() {
        return $this->grupoId;
    }

    function getGrupo() {
        return $this->grupo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setFonte($fonte) {
        $this->fonte = $fonte;
    }

    function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    function setApresentacaoComercial($apresentacaoComercial) {
        $this->apresentacaoComercial = $apresentacaoComercial;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setOrgaoControladorId($orgaoControladorId) {
        $this->orgaoControladorId = $orgaoControladorId;
    }

    function setOrgaoControlador($orgaoControlador) {
        $this->orgaoControlador = $orgaoControlador;
    }

    function setGrupoId($grupoId) {
        $this->grupoId = $grupoId;
    }

    function setGrupo($grupo) {
        $this->grupo = $grupo;
    }

    function toString() {
        $string = "(" .
                "id=>{$this->getId()}," .
                "nome=>{$this->getNome()}," .
                "quantidade=>{$this->getQuantidade()}," .
                "apresentacaoComercial=>{$this->getApresentacaoComercial()}," .
                "orgaoControladorId=>{$this->getOrgaoControladorId()}," .
                "grupoId=>{$this->getGrupoId()}," .
                "fonte=>{$this->getFonte()}," .
                "situacao=>{$this->getSituacao()}," .
                ")";
        return $string;
    }

}
