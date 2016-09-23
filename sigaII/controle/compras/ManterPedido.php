<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use modelo\compras\Pedido,
    dao\compras\PedidoDao,
    configuracao\DataSistema,
    controle\compras\ManterItemPedido,
    controle\compras\GerarPedidoAtividade,
    controle\compras\AutorizarPedido,
    sgp\Funcionario,
    sof\PA,
    sgp\Lotacao,
    controle\cadastros\ManterGrupo,
    controle\cadastros\ManterNaturezaDespesa,
    controle\email\EmailPedido,
    controle\configuracao\GerenciarLog,
    controle\compras\ManterSituacaoPedido,
    modelo\compras\EnumSituacaoPedido;

/**
 * Description of ManterPedido
 *
 * @author alex.bertolla
 */
class ManterPedido {

    private $pedido;
    private $pedidoDao;
    private $manterItem;
    private $data;
    private $manterItemPedido;
    private $pedidoAtividade;
    private $gerenciarLog;
    private $gerenciarSituacaoPedido;

    public function __construct() {
        $this->pedido = new Pedido();
        $this->pedidoDao = new PedidoDao();
        $this->data = new DataSistema();
        $this->pedidoAtividade = new GerarPedidoAtividade();
        $this->gerenciarLog = new GerenciarLog();
        $this->gerenciarSituacaoPedido = new ManterSituacaoPedido();
    }

    function setInfoPedido() {
        $this->setInfoSolicitantePedido();
        $this->setInfoPA();
        $this->setInfoLotacao();
        $this->setInfoGrupo();
        $this->setSituacaoPorId($this->pedido->getSituacaoId());
        $this->setListaItemPedido();
    }

    protected function setInfoSolicitantePedido() {
        $solicitante = new Funcionario();
        $solicitanteClass = $solicitante->buscarPorMatricula($this->pedido->getMatriculaSolicitante());
        $this->pedido->setSolicitante($solicitanteClass);
//        unset($solicitante);
    }

    protected function setInfoPA() {
        $pa = new PA();
        $infoPA = $pa->buscarPaPorId($this->pedido->getPaId(), $this->pedido->getAno());
//        $saldoPA = $pa->buscarSaldoPA($this->pedido->getAno(), $infoPA->getCodigo());
        $this->pedido->setPa($infoPA);
        unset($pa, $infoPA);
    }

    protected function setInfoLotacao() {
        $lotacao = new Lotacao();
        $this->pedido->setLotacao($lotacao->buscarPorId($this->pedido->getLotacaoId()));
        unset($lotacao);
    }

    protected function setInfoGrupo() {
        $grupo = new ManterGrupo();
        $this->pedido->setGrupo($grupo->buscarPorId($this->pedido->getGrupoId()));
        unset($grupo);
    }

    protected function setInfoNaturezaDespesa() {
        $nd = new ManterNaturezaDespesa();
        $this->pedido->setNaturezaDespesa($nd->buscarPorId($this->pedido->getNaturezaDespesaId()));
        unset($nd);
    }

    protected function setSituacaoPorId($situacaoId) {
        $situacao = $this->gerenciarSituacaoPedido->buscarPorId($situacaoId);
        $this->pedido->setSituacao($situacao);
        unset($situacao);
    }

    protected function setSituacaoPorCodigo($codigoSituacao) {
        $situacao = $this->gerenciarSituacaoPedido->buscarPorCodigo($codigoSituacao);
        $this->pedido->setSituacaoId($situacao->getId());
        $this->pedido->setSituacao($situacao);
        unset($situacao);
    }

    function listarItem() {
        return $this->manterItem->listar();
    }

    function listarlistarPedidoPorSolicitante($matriculaSolicitante) {
        $listaPedido = $this->pedidoDao->listarPedidoPorSolicitanteDao($matriculaSolicitante);
        $this->listaBdToForm($listaPedido);

        return $listaPedido;
    }

    function buscarPorId($id) {
        $this->setPedido($this->pedidoDao->buscarPedidoPorIdDao($id));
        if ($this->getPedido()) {
            $this->setInfoPedido();
            $this->bdToForm();
        }
        return $this->getPedido();
    }

    function buscarPorNumero($numero) {
        $array = explode("/", $numero);
        $numero = $array[0];
        $ano = $array[1];
        $this->setPedido($this->pedidoDao->buscarPorNumeroEAnoDao($numero, $ano));
        $this->bdToForm();
        $this->setListaItemPedido();
        return $this->getPedido();
    }

    function salvar($opcao) {
        $this->formToBd();
        switch ($opcao) {
            case "inserir":
                $resultado = $this->inserir();
                break;
            case "alterar":
                $resultado = $this->alterar();
                break;
            case "excluir":
                $resultado = $this->excluir();
                break;
        }



        return $resultado;
    }

    private function inserir() {
        $this->setPedidoEmEdicao();
        $id = $this->pedidoDao->inserirDao($this->pedido->getMatriculaSolicitante(), $this->pedido->getPaId(), $this->pedido->getLotacaoId(), $this->pedido->getJustificativa(), $this->pedido->getGrupoId(), $this->pedido->getNaturezaDespesaId(), $this->pedido->getAno(), $this->pedido->getTipo(), $this->pedido->getSituacaoId());
        $this->pedido->setId($id);
        return ($id) ? TRUE : FALSE;
    }

    private function alterar() {
        $this->setPedidoEmEdicao();
        return $this->pedidoDao->alterarDao($this->pedido->getId(), $this->pedido->getPaId(), $this->pedido->getLotacaoId(), $this->pedido->getJustificativa(), $this->pedido->getTipo());
    }

    private function setPedidoEmEdicao() {
        $codigo = EnumSituacaoPedido::EmEdicao;
        $situacao = $this->gerenciarSituacaoPedido->buscarPorCodigo($codigo);
        $this->pedido->setSituacaoId($situacao->getId());
    }

    function alterarSituacao($codigoSituacao) {
        $this->setSituacaoPorCodigo($codigoSituacao);
        $this->atualizarSitacaoItemPedido();
        return $this->pedidoDao->alterarSituacaoDao($this->pedido->getId(), $this->pedido->getSituacaoId());
    }

    private function excluir() {
        return $this->pedidoDao->excluirDao($this->pedido->getId());
    }

    function encaminharParaChefia() {
        if ($this->bloquearPedido(TRUE) && $this->alterarSituacao(EnumSituacaoPedido::EnviadoChefia)) {


            $pedidoChefia = new AutorizarPedido();
            $pedidoChefia->setPedidoAutorizacao($this->getPedido());
            $encaminhar = $pedidoChefia->encaminharPedidoParaChefia();

            unset($pedidoChefia);
            return $encaminhar;
        }
    }

    function atualizarSitacaoItemPedido() {
        if (count($this->pedido->getListaItemPedido()) > 0) {
            $situacao = $this->pedido->getSituacao();
            $this->manterItemPedido = new ManterItemPedido($this->pedido->getTipo());
            $atualizarSituacao = $this->manterItemPedido->atualizarSituacaoPorPedido($this->pedido->getId(), $situacao->getSituacaoItemPedidoId());
            unset($this->manterItemPedido);
            return $atualizarSituacao;
        }
        return FALSE;
    }

    function pedidoSituacaoSPS($id, $codigoSituacao) {
        $this->alterarSituacao($id, $codigoSituacao);
    }

    function bloquearPedido($bloquear) {
        return $this->pedidoDao->bloquearPedidoDao($this->pedido->getId(), $bloquear);
    }

    function enviarEmail() {
        $email = new EmailPedido();
        $email->emailPedidoEnviado($this->getPedido());

        unset($email);
    }

    protected function listaBdToForm($listaPedido) {
        foreach ($listaPedido as $pedido) {
            $this->setPedido($pedido);
            $this->setInfoPedido();
//            $this->setListaItemPedido();
            $this->bdToForm();
        }
        return $listaPedido;
    }

    function setListaItemPedido() {
        $this->manterItemPedido = new ManterItemPedido($this->pedido->getTipo());
        $listaItemPedido = $this->manterItemPedido->listarItemPedidoPorPedido($this->pedido->getId());
        $this->pedido->setListaItemPedido($listaItemPedido);
    }

    function gerarAitvidadePedido() {
        $situacao = $this->pedido->getSituacao();
        return $this->pedidoAtividade->registarAtividade($this->pedido->getId(), $situacao->getMensagem(), $this->pedido->getMatriculaSolicitante());
    }

    protected function bdToForm() {
        $this->pedido->setNumero($this->pedido->getNumero() . "/" . $this->pedido->getAno());
        $this->pedido->setJustificativa($this->utf8Encode($this->pedido->getJustificativa()));
        $this->pedido->setDataCriacao($this->data->ISOtoBR($this->pedido->getDataCriacao()));
        $this->pedido->setDataEnvio($this->data->ISOtoBR($this->pedido->getDataEnvio()));
    }

    protected function formToBd() {
        $this->pedido->setJustificativa($this->utf8Decode($this->pedido->getJustificativa()));
        $this->addSlash();
    }

    protected function addSlash() {
        $this->pedido->setJustificativa(addslashes($this->pedido->getJustificativa()));
    }

    function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    function setAtributos($artributos) {
        $this->pedido->setId($artributos->id);
        $this->pedido->setNumero($artributos->numero);
        $this->pedido->setMatriculaSolicitante($artributos->matriculaSolicitante);
        $this->pedido->setPaId($artributos->paId);
        $this->pedido->setLotacaoId($artributos->lotacaoId);
        $this->pedido->setJustificativa($artributos->justificativa);
        $this->pedido->setGrupoId($artributos->grupoId);
        $this->pedido->setNaturezaDespesaId($artributos->naturezaDespesaId);
        $this->pedido->setBloqueado(($artributos->bloqueado) ? 1 : 0);
        $this->pedido->setAno($artributos->ano);
        $this->pedido->setTipo($artributos->tipo);
    }

    function getPedido() {
        return $this->pedido;
    }

    function setPedido($pedido) {
        $this->pedido = $pedido;
    }

    public function __destruct() {
        unset($this->pedido);
    }

}
