<?php

/* * 
 * ***************************************************************************
 * Classe que controla o acesso ao banco de dados.
 * Sistema Gerenciador de Banco de dados: MySQL 5.
 * 
 * Resumo: Subclasse da classe ItemDao.Nesta classe estão as instruções SQLs 
 * referentes a classe modelo MaterialPermanente, e também chamas à super classe.
 * 
 * As isntruções são enviadas através da classe BD que é importada como uma
 * biblioteca e está bo pacote biblioteca\persistencia
 * Os metétodos desta classe devem ser chamados somente através da classe de
 * controle ManterMaterialConsumo.
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

class MaterialConsumoDao extends ItemDao {

    public function __construct() {
        parent::__construct();
        $this->classeModelo = "modelo\cadastros\MaterialConsumo";
    }

    public function __destruct() {
        parent::__destruct();
        unset($this->classeModelo);
    }

    function inserirMaterialConsumoDao($id, $controlado, $marca, $modelo, $partNumber, $codigoSinap, $orgaoControladorId, $itemControladoId, $apresentacaoComercialId) {
        $this->sql = "INSERT INTO bd_siga.materialConsumo (id, controlado, marca, modelo, partNumber, codigoSinap, orgaoControladorId, itemControladoId, apresentacaoComercialId) "
                . " VALUES ({$id}, {$controlado}, \"{$marca}\", \"{$modelo}\", \"{$partNumber}\", \"{$codigoSinap}\", {$orgaoControladorId}, {$itemControladoId}, {$apresentacaoComercialId})";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function inserirCentroDeCusto($materialConsumoId, $centroCustoId) {
        $this->sql = "INSERT INTO bd_siga.materialConsumoCentroCusto (materialConsumoId, centroCustoId) VALUES ({$materialConsumoId}, {$centroCustoId})";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirCentroDeCusto($materialConsumoId) {
        $this->sql = "DELETE FROM bd_siga.materialConsumoCentroCusto WHERE materialConsumoId={$materialConsumoId};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function alterarMaterialConsumoDao($id, $controlado, $marca, $modelo, $partNumber, $codigoSinap, $orgaoControladorId, $itemControladoId, $apresentacaoComercialId) {
        $this->sql = "UPDATE bd_siga.materialConsumo SET controlado={$controlado}, marca=\"{$marca}\", modelo=\"{$modelo}\", partNumber=\"{$partNumber}\", codigoSinap=\"{$codigoSinap}\", orgaoControladorId={$orgaoControladorId}, itemControladoId={$itemControladoId}, apresentacaoComercialId={$apresentacaoComercialId} WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirMaterialConsumoDao($id) {
        $this->sql = "DELETE FROM bd_siga.materialConsumo WHERE id={$id}";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarDao() {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.materialConsumo M ON I.id=M.id ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarAtivosDao() {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.materialConsumo M ON I.id=M.id WHERE I.situacao=true ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorGrupoAtivoDao($grupoId) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.materialConsumo M ON I.id=M.id WHERE I.grupoId={$grupoId} AND I.situacao=true ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.materialConsumo M ON I.id=M.id WHERE I.nome LIKE \"%{$nome}%\" ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarPorCodigoDao($codigo) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.materialConsumo M ON I.id=M.id WHERE I.codigo=\"{$codigo}\"";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.item I INNER JOIN bd_siga.materialConsumo M ON I.id=M.id WHERE I.id={$id}";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function listarPorNomeDescricaoOuCodigoDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.item I "
                . " INNER JOIN bd_siga.materialConsumo M ON I.id=M.id "
                . " WHERE (I.nome LIKE \"%{$nome}%\") "
                . " OR (I.descricao LIKE \"%{$nome}%\") "
                . " OR (I.codigo LIKE \"%{$nome}%\") "
                . " ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeDescricaoOuCodigoAtivoDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.item I "
                . " INNER JOIN bd_siga.materialConsumo M ON I.id=M.id "
                . " WHERE ((I.nome LIKE \"%{$nome}%\") "
                . " OR (I.descricao LIKE \"%{$nome}%\") "
                . " OR (I.codigo LIKE \"%{$nome}%\")) "
                . " AND (I.situacao=true)"
                . " ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeDescricaoOuCodigoEGrupoAtivoDao($nome, $grupoId) {
        $this->sql = "SELECT * FROM bd_siga.item I "
                . " INNER JOIN bd_siga.materialConsumo M ON I.id=M.id "
                . " WHERE ((I.nome LIKE \"%{$nome}%\") "
                . " OR (I.descricao LIKE \"%{$nome}%\") "
                . " OR (I.codigo LIKE \"%{$nome}%\") )"
                . " AND (I.situacao=true)"
                . " AND (I.grupoId={$grupoId})"
                . " ORDER BY I.codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

}
