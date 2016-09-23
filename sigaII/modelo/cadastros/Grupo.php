<?php

/* * 
 * ***************************************************************************
 * Representação lógica do grupo no sistema.
 * Relacionamentos com outras calsses: NaturezaDespesa e ContaContabil
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
 * descrição: Uma breve descrição sobre o grupo.
 * 
 * situacao: Não é recomendado a exclusão do banco de dados, por isso, esse
 * atribudo indica se a natureza de despesa está ativa ou não para uso do
 * sistema.
 * 
 * naturezaDespesaId: representa a chave estrangeira de relacionamento com a
 * natureza de despesas. Utilizada apenas para facilitar a manipulação no banco
 * de dados. Não deve ser alterado pelo sistema.
 * 
 * contaContabilId: representa a chave estrangeira de relacionamento com a
 * conta contabil. Utilizada apenas para facilitar a manipulação no banco
 * de dados. Não deve ser alterado pelo sistema.
 * 
 * naturezaDespesa: relacionamento com a classe NaturezaDespesa.
 * 
 * contaContabil: relacionamento com a classe ContaContabil.
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

use modelo\cadastros\NaturezaDespesa,
    modelo\cadastros\ContaContabil;

class Grupo {

    private $id;
    private $codigo;
    private $nome;
    private $descricao;
    private $situacao;
    private $naturezaDespesaId;
    private $contaContabilId;
    private $naturezaDespesa;
    private $contaContabil;
    private $tipo;

    public function __construct() {
        $this->naturezaDespesa = new NaturezaDespesa();
        $this->contaContabil = new ContaContabil();
    }

    public function __destruct() {
        unset($this->naturezaDespesa, $this->contaContabil);
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

    function getSituacao() {
        return $this->situacao;
    }

    function getNaturezaDespesaId() {
        return $this->naturezaDespesaId;
    }

    function getContaContabilId() {
        return $this->contaContabilId;
    }

    function getNaturezaDespesa() {
        return $this->naturezaDespesa;
    }

    function getContaContabil() {
        return $this->contaContabil;
    }

    function getTipo() {
        return $this->tipo;
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

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setNaturezaDespesaId($naturezaDespesaId) {
        $this->naturezaDespesaId = $naturezaDespesaId;
    }

    function setContaContabilId($contaContabilId) {
        $this->contaContabilId = $contaContabilId;
    }

    function setNaturezaDespesa($naturezaDespesa) {
        $this->naturezaDespesa = $naturezaDespesa;
    }

    function setContaContabil($contaContabil) {
        $this->contaContabil = $contaContabil;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function toString() {
        $string = "(" .
                "id=>{$this->getId()}, " .
                "codigo=>{$this->getCodigo()}, " .
                "nome=>{$this->getNome()}, " .
                "descricao=>{$this->getDescricao()}, " .
                "naturezaDespesaId=>{$this->getNaturezaDespesaId()}, " .
                "contaContabilId=>{$this->getContaContabilId()}, " .
                "situacao=>{$this->getSituacao()}" .
                "tipo=>{$this->getTipo()}"
                . ")";
        return $string;
    }

}
