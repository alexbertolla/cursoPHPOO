<?php

/* * 
 * ***************************************************************************
 * Classe que controla o acesso ao banco de dados.
 * Sistema Gerenciador de Banco de dados: MySQL 5.
 * 
 * Resumo: Nesta classe estão as instruções SQLs referentes a classe modelo
 * Item.
 * 
 * As isntruções são enviadas através da classe BD que é importada como uma
 * biblioteca e está bo pacote biblioteca\persistencia
 * Os metétodos desta classe devem ser chamados somente através das classes de
 * controle ManterItem, ManterMaterialConsumo, ManterMaterialPermanente,
 * ManterServico e ManterObra.
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

class ItemDao {

    protected $sql;
    protected $bd;
    protected $resultado;
    protected $classeModelo;

    public function __construct() {
        $this->bd = new BD();
    }

    public function __destruct() {
        unset($this->bd);
    }

    function inserirItemDao($codigo, $nome, $descricao, $sustentavel, $sistuacao, $grupoId, $almoxarifadoViualId, $naturezaDespesaId) {
        $this->sql = "INSERT INTO bd_siga.item (codigo, nome, descricao, dataCadastro, dataAlteracao, sustentavel, situacao, grupoId, almoxarifadoVirtualId, naturezaDespesaId) "
                . " VALUES ("
                . " (SELECT CONCAT(G.codigo, REPEAT('0',4-LENGTH(COUNT(I.id)+1)),COUNT(I.id)+1) FROM bd_siga.item I RIGHT JOIN bd_siga.grupo G ON I.grupoId = G.id GROUP BY G.id HAVING G.id={$grupoId}),"
                . " \"{$nome}\",\"{$descricao}\",date(now()),date(now()),{$sustentavel},{$sistuacao},{$grupoId},{$almoxarifadoViualId}, $naturezaDespesaId);";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function alterarItemDao($id, $codigo, $nome, $descricao, $sustentavel, $sistuacao, $grupoId, $almoxarifadoViualId, $naturezaDespesaId) {
        $this->sql = "UPDATE bd_siga.item SET nome=\"{$nome}\", descricao=\"{$descricao}\", dataAlteracao=date(now()), sustentavel={$sustentavel}, situacao={$sistuacao}, grupoId={$grupoId}, almoxarifadoVirtualId={$almoxarifadoViualId}, naturezaDespesaId={$naturezaDespesaId} "
                . " WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirItemDao($id) {
        $this->sql = "DELETE FROM bd_siga.item WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    protected function fetchListaObject() {
        $arrItem = new ArrayObject();
        while ($item = $this->fetchObject()) {
            $arrItem->append($item);
        }
        return $arrItem;
    }

    protected function fetchObject() {
        return $this->bd->fetch_object($this->classeModelo);
    }

}
