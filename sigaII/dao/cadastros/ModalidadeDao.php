<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace dao\cadastros;

/**
 * Description of Modalidadedao
 *
 * @author alex.bertolla
 */
use bibliotecas\persistencia\BD,
    ArrayObject;

class ModalidadeDao {

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
        $arrModalidade = new ArrayObject();
        while ($modalidade = $this->fetchObject()) {
            $arrModalidade->append($modalidade);
        }
        return $arrModalidade;
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\cadastros\Modalidade");
    }

    function inserirDao($nome) {
        $this->sql = "INSERT INTO bd_siga.modalidade (nome) VALUES (\"{$nome}\")";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function alterarDao($id, $nome) {
        $this->sql = "UPDATE bd_siga.modalidade SET nome=\"{$nome}\" WHERE id={$id}";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirDao($id) {
        $this->sql = "DELETE FROM bd_siga.modalidade WHERE id={$id}";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarDao() {
        $this->sql = "SELECT * FROM bd_siga.modalidade ORDER BY nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function listarPorNomeDao($nome) {
        $this->sql = "SELECT * FROM bd_siga.modalidade WHERE nome LIKE \"%{$nome}%\" ORDER BY nome ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchListaObject();
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.modalidade WHERE id = {$id}";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

}
