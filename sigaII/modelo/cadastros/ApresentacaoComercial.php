<?php

/* * 
 * ***************************************************************************
 * Representação lógica da apresentação comercial de um item no sistema.
 * Por exemplo: frasco 10gramas, saca 10kg, unidade, etc
 * 
 * Atributos:
 * id: representa a chave de indexação do banco de dados e não deve ser alterado
 * pelo sistema;

 * nome: nome da apresentação comercial (frasco, unidade, saca, etc);
 * 
 * apresentacaoComercial: representa uma unidade de medida que caracteriza um
 * item (litro, grama, etc)
 * 
 * quantidade: representa a quantidade da apresentação comercial (1 litro,
 * 10 gramas, 10 kilos,etc)
 * 
 * idGrupo: chave estrangeira de indexação do banco de dados. Utilizada apenas
 * para facilitar a insersão e consultas. Não deve ser alterado pelo sistema.
 * 
 * grupo: as apresentações comerciais estão associadas aos grupos. Um grupo
 * pode ter mais de uma apresentação comercial, mas um apresentação comercial
 * está associada a somente um grupo;
 * 
 * situacao: Não é recomendado a exclusão do banco de dados, por isso, esse
 * atribudo indica se a natureza de despesa está ativa ou não para uso do
 * sistema.
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

use modelo\cadastros\Grupo;

class ApresentacaoComercial {

    private $id;
    private $nome;
    private $apresentacaoComercial;
    private $quantidade;
    private $grupoId;
    private $grupo;
    private $situacao;

    public function __construct() {
        $this->grupo = new Grupo();
    }

    public function __destruct() {
        unset($this->grupo);
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getApresentacaoComercial() {
        return $this->apresentacaoComercial;
    }

    function getQuantidade() {
        return $this->quantidade;
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

    function setApresentacaoComercial($apresentacaoComercial) {
        $this->apresentacaoComercial = $apresentacaoComercial;
    }

    function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    function setGrupoId($grupoId) {
        $this->grupoId = $grupoId;
    }

    function setGrupo($grupo) {
        $this->grupo = $grupo;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function toString() {
        $string = "(" .
                "id=>" . $this->getId() . ", " .
                "nome=>" . $this->getNome() . ", " .
                "apresentacaoComercial=>" . $this->getApresentacaoComercial() . ", " .
                "quantidade=>" . $this->getQuantidade() . ", " .
                "grupoId=>" . $this->getGrupoId() . ", " .
                "situacao=>" . $this->getSituacao()
                . ")";
        return $string;
    }

}
