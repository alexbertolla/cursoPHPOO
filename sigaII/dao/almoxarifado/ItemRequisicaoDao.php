<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace dao\almoxarifado;

use bibliotecas\persistencia\BD,
    ArrayObject,
    Exception;

/**
 * Description of ItemRequisicao
 *
 * @author egidio.ramalho
 */
class ItemRequisicaoDao {

    private $sql;
    private $bd;

    public function __construct() {
        $this->bd = new BD();
    }

    private function fetchListaObject() {
        $arrayItem = new ArrayObject();
        while ($item = $this->fetchObject()) {
            $arrayItem->append($item);
        }
        return $arrayItem;
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\almoxarifado\ItemRequisicao");
    }

    function inserirDao($requisicaoId, $itemEstoqueId, $itemId, $quantidade, $valorUnitario, $valorTotal) {
        $this->sql = "INSERT INTO bd_siga.requisicaoHasItemEstoque (requisicaoId, itemEstoqueId, itemId, quantidade, valorUnitario, valorTotal) "
                . " VALUES ({$requisicaoId}, {$itemEstoqueId}, {$itemId}, {$quantidade}, {$valorUnitario}, {$valorTotal});";
        if ($this->bd->query($this->sql)) {
            return TRUE;
        } else {
            throw new Exception("ERRO INSERIR ITEM REQUISICAO - ERRO SQL [{$this->sql}]");
        }
    }

    function excluirDao($requisicaoId) {
        $this->sql = "DELETE FROM bd_siga.requisicaoHasItemEstoque WHERE requisicaoId={$requisicaoId}";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarPorRequisicaoIdDao($requisicaoId) {
        $this->sql = "SELECT * FROM bd_siga.requisicaoHasItemEstoque WHERE requisicaoId={$requisicaoId}";
        $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    public function __destruct() {
        unset($this->bd);
    }

}
