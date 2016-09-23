<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ItensDeCompraDao
 *
 * @author alex.bertolla
 */

namespace dao\configuracao;

use bibliotecas\persistencia\BD,
    ArrayObject;

class ItensDeCompraDao {

    private $sql;
    private $bd;
    private $resultado;

    public function __construct() {
        $this->bd = new BD();
    }

    public function __destruct() {
        unset($this->bd);
    }

    function inserirDao($nome, $nomeApresentacao, $descricao, $naturezaDespesaId, $arquivo) {
        $this->sql = "INSERT INTO bd_siga.itensDeCompra (nome, nomeApresentacao, descricao, naturezaDespesaId, arquivo) "
                . " VALUES (\"{$nome}\", \"{$nomeApresentacao}\", \"{$descricao}\", {$naturezaDespesaId}, \"{$arquivo}\")";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function alterarDao($id, $nome, $nomeApresentacao, $descricao, $naturezaDespesaId, $arquivo) {
        $this->sql = "UPDATE bd_siga.itensDeCompra SET nome=\"{$nome}\", nomeApresentacao=\"{$nomeApresentacao}\", descricao=\"{$descricao}\", naturezaDespesaId={$naturezaDespesaId}, arquivo=\"{$arquivo}\" "
                . " WHERE id={$id}";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirDao($id) {
        $this->sql = "DELETE FROM bd_siga.itensDeCompra WHERE id={$id}";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarDao() {
        $this->sql = "SELECT * FROM bd_siga.itensDeCompra ORDER BY nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        $arrItensDeCompra = new ArrayObject();
        while ($itensDeCompra = $this->bd->fetch_object("configuracao\ItensDeCompra")) {
            $arrItensDeCompra->append($itensDeCompra);
        }
        return $arrItensDeCompra;
    }

    function listarPorNomeDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.itensDeCompra WHERE nome LIKE \"%{$nome}%\" ORDER BY nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        $arrItensDeCompra = new ArrayObject();
        while ($itensDeCompra = $this->bd->fetch_object("configuracao\ItensDeCompra")) {
            $arrItensDeCompra->append($itensDeCompra);
        }
        return $arrItensDeCompra;
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.itensDeCompra WHERE id = {$id}";
        $this->resultado = $this->bd->query($this->sql);
        return $this->bd->fetch_object("configuracao\ItensDeCompra");
    }

}
