<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace dao\almoxarifado;

use bibliotecas\persistencia\BD,
    ArrayObject;

/**
 * Description of ItemEstoqueDao
 *
 * @author alex.bertolla
 */
class ItemEstoqueDao {

    private $sql;
    private $bd;

    public function __construct() {
        $this->bd = new BD();
    }

    private function fetchListaObject() {
        $arrNotaFiscal = new ArrayObject();
        while ($notaFiscal = $this->fetchObject()) {
            $arrNotaFiscal->append($notaFiscal);
        }
        return $arrNotaFiscal;
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\almoxarifado\ItemEstoque");
    }

    function inserirDao($quantidade, $precoMedio, $diferencaContabil, $itemId, $fornecedorId) {
        $this->sql = "INSERT INTO bd_siga.itemEstoque (quantidade, precoMedio, diferencaContabil, itemId, fornecedorId) "
                . " VALUES ({$quantidade}, {$precoMedio}, {$diferencaContabil}, {$itemId}, \"{$fornecedorId}\");";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function atualizarEstoqueDao($id, $quantidade) {
        $this->sql = "UPDATE bd_siga.itemEstoque SET quantidade={$quantidade} WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function buscarPorCodigoItemDao($codigo) {
        $this->sql = "SELECT IE.* FROM bd_siga.itemEstoque IE "
                . " INNER JOIN bd_siga.item I ON IE.itemId=I.id "
                . " WHERE I.codigo=\"{$codigo}\";";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function listarDao() {
        $this->sql = "SELECT IE.* FROM bd_siga.itemEstoque IE "
                . " INNER JOIN bd_siga.item I ON IE.itemId=I.id "
                . " ORDER BY I.codigo ASC";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarPorItemIdDao($itemId) {
        $this->sql = "SELECT * FROM bd_siga.itemEstoque WHERE itemId={$itemId};";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.itemEstoque WHERE id={$id};";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarQtdUsrPorItemId($itemId) {
        $this->sql = "SELECT 
                tab_e.*, (tab_e.quantidade - tab_r.qt_reserva) AS qt_usuario
            FROM
                (SELECT 
                    SUM(tab1.quantidade) AS qt_reserva, tab1.itemId
                FROM
                    (SELECT 
                    rq.id,
                        rh.requisicaoId,
                        rq.atendida,
                        rh.itemId AS itemId,
                        rh.quantidade AS quantidade
                FROM
                    requisicaoHasItemEstoque AS rh
                INNER JOIN requisicao AS rq ON rq.id = rh.requisicaoId
                WHERE
                    rq.atendida = 0) AS tab1
                WHERE
                    itemId = {$itemId}) AS tab_r
                    INNER JOIN
                (SELECT 
                    *
                FROM
                    itemEstoque
                WHERE
                    itemId = {$itemId}) AS tab_e;";

        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    /*
     * SELECT *,
      IFNULL(
      (
      SELECT
      -- IE.*, IE.quantidade as 'qtdEstoque',
      -- RHIE.quantidade as 'qtdPedida',
      IFNULL((IE.quantidade - RHIE.quantidade),IE.quantidade) as 'qtdDisponivel'

      FROM bd_siga.itemEstoque IE

      LEFT JOIN bd_siga.requisicaoHasItemEstoque RHIE ON IE.itemId = RHIE.itemId
      LEFT JOIN bd_siga.requisicao R ON RHIE.requisicaoId=R.id

      WHERE (R.atendida=0 AND IE.id=I.id)

      GROUP BY (IE.itemId)
      ORDER BY (IE.itemId)
      ),I.quantidade) as 'qtdD'
      FROM bd_siga.itemEstoque I;
     */

    public function __destruct() {
        unset($this->bd);
    }

}
