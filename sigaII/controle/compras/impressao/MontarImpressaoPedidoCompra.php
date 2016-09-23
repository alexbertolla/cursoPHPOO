<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras\impressao;

use modelo\compras\Pedido,
    controle\compras\ManterPedido,
    configuracao\Usuario,
    sof\PA,
    sgp\Lotacao,
    controle\cadastros\ManterGrupo,
    controle\cadastros\ManterNaturezaDespesa,
    controle\compras\ManterItemPedido;

/**
 * Description of ImpressaoPedidoCompra
 *
 * @author alex.bertolla
 */
class MontarImpressaoPedidoCompra {

    private $pedidoCompra;

    public function __construct() {
        $this->pedidoCompra = new Pedido();
    }

    function buscarPedido($pedidoId) {
        $manterPedido = new ManterPedido();
        $this->setPedidoCompra($manterPedido->buscarPorId($pedidoId));
        $this->detalharPedido();
    }

    private function detalharPedido() {
        $this->setSolicitante();
        $this->setPA();
        $this->setLotacaoPedido();
        $this->setGrupo();
        $this->setNaturezaDespesa();
        $this->setListaItensPedido();
    }

    function getPedidoCompra() {
        return $this->pedidoCompra;
    }

    private function setPedidoCompra($pedidoCompra) {
        $this->pedidoCompra = $pedidoCompra;
    }

    private function setSolicitante() {
        $usuario = new Usuario();
        $this->pedidoCompra->setSolicitante($usuario->buscarPorMatricula($this->pedidoCompra->getMatriculaSolicitante()));
    }

    private function setPA() {
        $pa = new PA();
        $infoPA = $pa->buscarPaPorId($this->pedidoCompra->getPaId());
        $this->pedidoCompra->setPa($pa->buscarSaldoPA($this->pedidoCompra->getAno(), $infoPA->getCodigo()));
    }

    private function setLotacaoPedido() {
        $lotacao = new Lotacao();
        $this->pedidoCompra->setLotacao($lotacao->buscarPorId($this->pedidoCompra->getLotacaoId()));
    }

    private function setGrupo() {
        $grupo = new ManterGrupo();
        $this->pedidoCompra->setGrupo($grupo->buscarPorId($this->pedidoCompra->getGrupoId()));
    }

    private function setNaturezaDespesa() {
        $nd = new ManterNaturezaDespesa();
        $this->pedidoCompra->setNaturezaDespesa($nd->buscarPorId($this->pedidoCompra->getNaturezaDespesaId()));
    }

    private function setListaItensPedido() {
        $nd = $this->pedidoCompra->getNaturezaDespesa();
        $tipoInterface = $nd->getTipo();
        $manterItemPedido = new ManterItemPedido($tipoInterface);
        $this->pedidoCompra->setListaItemPedido($manterItemPedido->listarItemPedidoPorPedido($this->pedidoCompra->getId()));
    }

}
