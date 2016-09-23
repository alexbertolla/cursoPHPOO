<?php

/* * 
 * ***************************************************************************
 * Representação lógica dos órgãos controladores.
 * 
 * Atributos:
 * id: representa a chave de indexação do banco de dados e não deve ser alterado
 * pelo sistema;

 * 
 * nome: nome do orgão controlador;
 * 
 * situacao: Não é recomendado a exclusão do banco de dados, por isso, esse
 * atribudo indica se a natureza de despesa está ativa ou não para uso do
 * sistema.
 * 
 * listaItensControlados: relacionamento com a classe ItemControlado. Um órgão
 * controlador pode controlar vários itens.
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

use ArrayObject;

class OrgaoControlador {

    private $id;
    private $nome;
    private $situacao;
    private $listaItensControlados;

    public function __construct() {
//        $this->listaItensControlados = new ArrayObject();
    }

    public function __destruct() {
        unset($this->listaItensControlados);
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function getListaItensControlados() {
        return $this->listaItensControlados;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setListaItensControlados($listaItensControlados) {
        $this->listaItensControlados = $listaItensControlados;
    }

    function adicionarItemControlado(ItemControlado $itemControlado) {
        $this->listaItensControlados->append($itemControlado);
    }

    function toString() {
        $string = "(" .
                "id=>{$this->getId()}," .
                "nome=>{$this->getNome()}," .
                "situacao=>{$this->getSituacao()}," .
                ")";
        return $string;
    }

}
