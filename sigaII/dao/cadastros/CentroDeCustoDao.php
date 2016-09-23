<?php

/* * 
 * ***************************************************************************
 * Classe que controla o acesso ao banco de dados.
 * Sistema Gerenciador de Banco de dados: MySQL 5.
 * 
 * Resumo: Nesta classe estão as instruções SQLs referentes a classe modelo
 * CentroDeCusto.
 * 
 * As isntruções são enviadas através da classe BD que é importada como uma
 * biblioteca e está bo pacote biblioteca\persistencia
 * Os metétodos desta classe devem ser chamados somente através da classe de
 * controle ManterCentroDeCusto.
 * 
 * Alex Bisetto Bertolla
 * alex.bertolla@embrapa.br
 * (85)3391-7163
 * Núcleo de Tecnologia da Informação
 * Embrapa Agroidústria Tropical
 * 
 * ***************************************************************************
 */

namespace dao\cadastros;

use bibliotecas\persistencia\BD,
    ArrayObject;

class CentroDeCustoDao {

    private $sql;
    private $bd;
    private $resultado;

    public function __construct() {
        $this->bd = new BD();
    }

    public function __destruct() {
        unset($this->bd);
    }

    private function fetchListaObject() {
        $arrCentroDeCusto = new ArrayObject();
        while ($centroDeCusto = $this->fetchObject()) {
            $arrCentroDeCusto->append($centroDeCusto);
        }
        return $arrCentroDeCusto;
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\cadastros\CentroDeCusto");
    }

    function inserirDao($codigo, $nome, $situacao) {
        $this->sql = "INSERT INTO bd_siga.centroCusto (codigo, nome, situacao) VALUES (\"{$codigo}\",\"{$nome}\",{$situacao});";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function alterarDao($id, $codigo, $nome, $situacao) {
        $this->sql = "UPDATE bd_siga.centroCusto SET codigo=\"{$codigo}\", nome=\"{$nome}\", situacao={$situacao} WHERE id = {$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirDao($id) {
        $this->sql = "DELETE FROM bd_siga.centroCusto WHERE id = {$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function ListarDao() {
        $this->sql = "SELECT * FROM bd_siga.centroCusto ORDER BY codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarAtivosDao() {
        $this->sql = "SELECT * FROM bd_siga.centroCusto WHERE situacao=true ORDER BY codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.centroCusto WHERE nome LIKE \"%{$nome}%\" ORDER BY codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeAtivoDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.centroCusto WHERE nome LIKE \"%{$nome}%\" situacao=true ORDER BY codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorMaterialConsumoIdDao($materialConsumoId) {
        $this->sql = "SELECT CC.* FROM bd_siga.centroCusto CC "
                . " INNER JOIN bd_siga.materialConsumoCentroCusto mCC ON CC.id=mCC.centroCustoId "
                . " INNER JOIN bd_siga.materialConsumo MC ON mCC.materialConsumoId=MC.id "
                . " WHERE MC.id= {$materialConsumoId} "
                . " ORDER BY CC.nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.centroCusto WHERE id = {$id}";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

}
