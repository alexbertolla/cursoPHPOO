<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace dao\compras;

use bibliotecas\persistencia\BD,
    ArrayObject;

/**
 * Description of PedidoSPSDao
 *
 * @author alex.bertolla
 */
class PedidoSPSDao {

    private $sql;
    private $bd;
    private $resultado;

    public function __construct() {
        $this->bd = new BD();
    }

    public function __destruct() {
        unset($this->bd);
    }

    private function fetchLitaObject() {
        $arrPedio = new ArrayObject();
        while ($pedido = $this->fetchObject()) {
            $arrPedio->append($pedido);
        }
        return $arrPedio;
    }

    private function fetchObject() {
        return $this->bd->fetch_object("modelo\compras\PedidoSPS");
    }

    function inserirDao($id) {
        $this->sql = "INSERT INTO bd_siga.pedidoSPS (id, recebido, encaminhado) VALUES ({$id}, 0, 0);";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function receberPedidoDao($id, $matriculaResponsavel) {
        $this->sql = "UPDATE bd_siga.pedidoSPS SET recebido=1, dataRecebido=DATE(NOW()), matriculaResponsavel=\"{$matriculaResponsavel}\" WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function adicionarEmProcessoCompraDao($id) {
        $this->sql = "UPDATE bd_siga.pedidoSPS SET encaminhado=1 WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarPedidosAReceberDao() {
        $this->sql = "SELECT * FROM bd_siga.pedidoSPS WHERE recebido = 0;";
        $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    function listarPedidosRecebidoDao() {
        $this->sql = "SELECT * FROM bd_siga.pedidoSPS WHERE recebido = 1 AND encaminhado=0;";
        $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    function buscarPedidoRecebidoPorNumeroAnoDao($numero, $ano) {
        $this->sql = "SELECT * FROM bd_siga.pedidoSPS SPS "
                . " INNER JOIN bd_siga.pedido P ON SPS.id=P.id "
                . " WHERE SPS.recebido = 1 and P.numero LIKE \"{$numero}\" AND ano =\"{$ano}\";";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.pedidoSPS WHERE id={$id};";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarPorCodigoDao($codigo, $ano) {
        $this->sql = "SELECT * FROM bd_siga.pedidoSPS SPS INNER JOIN bd_siga.pedido P ON SPS.id=P.id WHERE P.codigo=\"{$codigo}\" AND P.ano=\"{$ano}\";";
        $this->bd->query($this->sql);
        return $this->fetchObject();
    }

}
