<?php

namespace dao\compras;

use bibliotecas\persistencia\BD,
    ArrayObject;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PedidoDao
 *
 * @author alex.bertolla
 */
class PedidoDao {

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
        return $this->bd->fetch_object("modelo\compras\Pedido");
    }

    function inserirDao($matriculaSolicitante, $paId, $lotacaoId, $justificativa, $grupoId, $naturezaDespesaId, $ano, $tipo, $situacaoId) {
        $numero = "(SELECT COUNT(*)+1 FROM bd_siga.pedido P WHERE P.ano={$ano} GROUP BY P.ano)";
        $this->sql = "INSERT INTO bd_siga.pedido (numero, matriculaSolicitante, paId, lotacaoId, justificativa, grupoId, dataCriacao, ano, tipo, bloqueado, situacaoId) "
                . " VALUES (ifnull({$numero},1),\"{$matriculaSolicitante}\",\"{$paId}\",{$lotacaoId},\"{$justificativa}\",{$grupoId}, DATE(NOW()), {$ano}, \"{$tipo}\",0,{$situacaoId});";
        return ($this->bd->query($this->sql)) ? $this->bd->insert_id() : FALSE;
    }

    function bloquearPedidoDao($id, $bloquear) {
        $this->sql = "UPDATE bd_siga.pedido SET bloqueado={$bloquear}, dataEnvio=DATE(NOW()) "
                . " WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function alterarDao($id, $paId, $lotacaoId, $justificativa, $tipo) {
        $this->sql = "UPDATE bd_siga.pedido SET paId=\"{$paId}\", lotacaoId={$lotacaoId}, justificativa=\"{$justificativa}\", tipo=\"{$tipo}\" "
                . " WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function alterarSituacaoDao($id, $situacaoId) {
        $this->sql = "UPDATE bd_siga.pedido SET situacaoId=\"{$situacaoId}\" WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function excluirDao($id) {
        $this->sql = "DELETE FROM bd_siga.pedido WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function devolverDao($id) {
        $this->sql = "UPDATE bd_siga.pedido SET bloqueado=0 WHERE id={$id};";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarPorProcessoDeCompraIdDao($processoCompraId) {
        $this->sql = "SELECT P.* FROM bd_siga.pedido P "
                . " INNER JOIN bd_siga.loteHasItemPedido LHIP ON P.id=LHIP.pedidoId "
                . " WHERE LHIP.processoCompraId={$processoCompraId} "
                . " ORDER BY P.numero ASC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    function listarPedidoPorSolicitanteDao($matriculaSolicitante) {
        $this->sql = "SELECT * FROM bd_siga.pedido WHERE matriculaSolicitante=\"{$matriculaSolicitante}\" ORDER BY dataCriacao DESC";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchLitaObject();
    }

    function buscarPedidoPorIdDao($id) {
        $this->sql = "SELECT * FROM bd_siga.pedido WHERE id={$id};";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

    function buscarPorNumeroEAnoDao($numero, $ano) {
        $this->sql = "SELECT * FROM bd_siga.pedido WHERE numero=\"{$numero}\" AND ano=\"{$ano}\";";
        $this->resultado = $this->bd->query($this->sql);
        return $this->fetchObject();
    }

}
