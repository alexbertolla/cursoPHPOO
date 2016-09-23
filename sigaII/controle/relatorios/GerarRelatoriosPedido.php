<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GerarRelatoriosPedido
 *
 * @author alex.bertolla
 */

namespace controle\relatorios;

use controle\compras\ManterPedido,
    modelo\compras\Pedido,
    controle\ManterGrupo,
    controle\ManterNaturezaDespesa,
    sgp\Funcionario,
    sgp\Lotacao,
    sof\PA;

class GerarRelatoriosPedido {

    private $pedido;
    private $manterPedido;

    public function __construct() {
        $this->manterPedido = new ManterPedido();
        $this->pedido = new Pedido();
    }

    function pedidoDetalhado($id) {
        $this->setPedido($this->manterPedido->buscarPorId($id));
        $this->setInfoPedido();
        return $this->getPedido();
    }

    function pedidosPorSolicitante($matriculaSolicitante) {
        $listaPedido = $this->manterPedido->listarlistarPedidoPorSolicitante($matriculaSolicitante);
        return $listaPedido;
    }

    function setInfoPedido() {
        $this->setInfoSolicitantePedido();
        $this->setInfoPA();
        $this->setInfoLotacao();
        $this->setInfoGrupo();
        $this->setInfoNaturezaDespesa();
        $this->manterPedido->setListaItemPedido();
    }

    private function setInfoSolicitantePedido() {
        $solicitante = new Funcionario();
        $this->pedido->setSolicitante($solicitante->buscarPorMatricula($this->pedido->getMatriculaSolicitante()));
        unset($solicitante);
    }

    private function setInfoPA() {
        $pa = new PA();
        $infoPA = $pa->buscarPaPorId($this->pedido->getPaId());
        $saldoPA = $pa->buscarSaldoPA($this->pedido->getAno(), $infoPA->getCodigo());
        $this->pedido->setPa($saldoPA);
        unset($pa, $saldoPA);
    }

    private function setInfoLotacao() {
        $lotacao = new Lotacao();
        $this->pedido->setLotacao($lotacao->buscarPorId($this->pedido->getLotacaoId()));
        unset($lotacao);
    }

    private function setInfoGrupo() {
        $grupo = new ManterGrupo();
        $this->pedido->setGrupo($grupo->buscarPorId($this->pedido->getGrupoId()));
        unset($grupo);
    }

    private function setInfoNaturezaDespesa() {
        $nd = new ManterNaturezaDespesa();
        $this->pedido->setNaturezaDespesa($nd->buscarPorId($this->pedido->getNaturezaDespesaId()));
        unset($nd);
    }

    function getPedido() {
        return $this->pedido;
    }

    function setPedido($pedido) {
        $this->pedido = $pedido;
    }

    public function __destruct() {
        unset($this->pedido, $this->pedidos);
    }

}
