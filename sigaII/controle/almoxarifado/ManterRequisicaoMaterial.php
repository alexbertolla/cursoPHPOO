<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\almoxarifado;

use modelo\almoxarifado\RequisicaoMaterial,
    dao\almoxarifado\RequisicaoMaterialDao,
    controle\almoxarifado\ManterSituacaoRequisicao,
    modelo\almoxarifado\EnumSituacaoRequisicao,
    controle\almoxarifado\RegistrarAtividadeRequisicao,
    controle\almoxarifado\ManterItemRequisicaoMaterial,
    controle\email\EmailRequisicao,
    sgp\Funcionario,
    sgp\Lotacao,
    sof\PA;

/**
 * Description of ManterRequisicaoMaterial
 *
 * @author alex.bertolla
 */
class ManterRequisicaoMaterial {

    private $requisicaoMaterial;
    private $requisicaoMaterialDao;
    private $manterItemRequisicaoMaterial;

    public function __construct() {
        $this->requisicaoMaterial = new RequisicaoMaterial();
        $this->requisicaoMaterialDao = new RequisicaoMaterialDao();
        $this->manterItemRequisicaoMaterial = new ManterItemRequisicaoMaterial();
    }

    function listarPorRequisitante($matriculaRequisitante) {
        return $this->setDadosListaRequisicao($this->requisicaoMaterialDao->listarPorRequisitanteDao($matriculaRequisitante));
    }

    function enviarRequisicao() {
        $this->setSituacaoPorCodigo(EnumSituacaoRequisicao::Enviado);
        if ($this->alterarSituacao()) {
            return $this->requisicaoMaterialDao->enviarDao($this->requisicaoMaterial->getId());
        } else {
            throw new \Exception("ERRO AO ALTERAR SITUACAO DA REQUISICAO - " . __FILE__ . " - " . __METHOD__ . " - " . __FUNCTION__ . "|" . __LINE__);
        }
        return FALSE;
    }

    function receberRequisicao() {
        $this->setSituacaoPorCodigo(EnumSituacaoRequisicao::Recebido);

        if ($this->alterarSituacao()) {
            return $this->requisicaoMaterialDao->receberDao($this->requisicaoMaterial->getId(), $this->requisicaoMaterial->getMatriculaResponsavel());
        }
        return FALSE;
    }

    function devolverRequisicao() {
        $this->setSituacaoPorCodigo(EnumSituacaoRequisicao::Devolvido);
        if ($this->alterarSituacao()) {
            return $this->requisicaoMaterialDao->devolvidaDao($this->requisicaoMaterial->getId());
        }
        return FALSE;
    }

    function cancelarRequisicao() {
        $this->setSituacaoPorCodigo(EnumSituacaoRequisicao::Cancelado);
        if ($this->alterarSituacao()) {
            return $this->requisicaoMaterialDao->encerrarDao($this->requisicaoMaterial->getId());
        }
        return FALSE;
    }

    function atender($opcao) {
        switch ($opcao) {
            case "atenderEntregar":
                $atendido = $this->atenderEntregar();
                break;
            case "atenderColetar":
                $atendido = $this->atenderColetar();
                break;
        }

        return $atendido;
    }

    private function atenderEntregar() {
        $this->setSituacaoPorCodigo(EnumSituacaoRequisicao::AtendidoAgEntrega);
        if ($this->alterarSituacao()) {
            return $this->requisicaoMaterialDao->atendidaDao($this->requisicaoMaterial->getId());
        }
        return FALSE;
    }

    private function atenderColetar() {
        $this->setSituacaoPorCodigo(EnumSituacaoRequisicao::AtendiDoAgColeta);
        if ($this->alterarSituacao()) {
            return $this->requisicaoMaterialDao->atendidaDao($this->requisicaoMaterial->getId());
        }
        return FALSE;
    }

    function encerrarRequisicao() {
        $this->setSituacaoPorCodigo(EnumSituacaoRequisicao::EntregueAssinado);
        if ($this->alterarSituacao()) {
            return $this->requisicaoMaterialDao->encerrarDao($this->requisicaoMaterial->getId());
        }
        return FALSE;
    }

    function registrarSaidaMaterial() {
        foreach ($this->requisicaoMaterial->getListaItemRequisicao() as $itemRequisicao) {
            $this->manterItemRequisicaoMaterial->setItemRequisicao($itemRequisicao);
            $this->manterItemRequisicaoMaterial->registrarSaidaMaterial();
        }
    }

    function buscarPorId($id) {
        $requisicaoMaterial = $this->requisicaoMaterialDao->buscarPorIdDao($id);
        $this->setRequisicaoMaterial($requisicaoMaterial);
        $this->setDadosRequisicao();
        return $this->getRequisicaoMaterial();
    }

    function salvar($opcao) {
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
        $this->setSituacaoPorCodigo(EnumSituacaoRequisicao::EmEdicao);
        $id = $this->requisicaoMaterialDao->inserirDao($this->requisicaoMaterial->getMatriculaRequisitante(), $this->requisicaoMaterial->getPaId(), $this->requisicaoMaterial->getLotacaoId(), $this->requisicaoMaterial->getSituacaoId(), $this->requisicaoMaterial->getAno());
        if ($id) {
            $this->requisicaoMaterial->setId($id);
            $this->inserirItemRequisicao();
        }
        return $id;
    }

    private function alterar() {
        $alterar = $this->requisicaoMaterialDao->alterarDao($this->requisicaoMaterial->getId(), $this->requisicaoMaterial->getPaId(), $this->requisicaoMaterial->getLotacaoId());
        $this->inserirItemRequisicao();
        return $alterar;
    }

    private function excluir() {
        return $this->requisicaoMaterialDao->excluirDao($this->requisicaoMaterial->getId());
    }

    private function alterarSituacao() {
        return $this->requisicaoMaterialDao->alterarSituacaoIdDao($this->requisicaoMaterial->getId(), $this->requisicaoMaterial->getSituacaoId());
    }

    function registrarAtividade($matricula) {
        $registrarAtividade = new RegistrarAtividadeRequisicao();
        return $registrarAtividade->registarAtividadeRequisicao($matricula, $this->requisicaoMaterial->getId(), $this->requisicaoMaterial->getSituacaoId());
    }

    private function inserirItemRequisicao() {
        $inserir = FALSE;
        $this->excluirItensRequisicao();
        if (count($this->requisicaoMaterial->getListaItemRequisicao()) > 0) {
            foreach ($this->requisicaoMaterial->getListaItemRequisicao() as $itemRequisicao) {
                $itemRequisicao->setRequisicaoId($this->requisicaoMaterial->getId());
                $this->manterItemRequisicaoMaterial->setItemRequisicao($itemRequisicao);
                $inserir = $this->manterItemRequisicaoMaterial->inserir();
            }
            $this->requisicaoMaterialDao->alterarValorDao($this->requisicaoMaterial->getId(), $this->requisicaoMaterial->getValor());
        }
        return $inserir;
    }

    private function excluirItensRequisicao() {
        $this->manterItemRequisicaoMaterial->excluir($this->requisicaoMaterial->getId());
        $this->requisicaoMaterialDao->alterarValorDao($this->requisicaoMaterial->getId(), 0.00);
    }

    function enviarEmailRequisicao() {
        $emailRequisicao = new EmailRequisicao();
        if ($emailRequisicao->emailRequisicaoEnviado($this->getRequisicaoMaterial())) {
            return TRUE;
        } else {
            throw new \Exception("ERRO AO ENVIAR E-MAIL");
        }
//        unset($emailRequisicao);
    }

    function setDadosListaRequisicao($lista) {
        foreach ($lista as $requisicaoMaterial) {
            $this->setRequisicaoMaterial($requisicaoMaterial);
            $this->setDadosRequisicao();
        }
        return $lista;
    }

    function setDadosRequisicao() {
        $this->setResponsavel();
        $this->setRequisitante();
        $this->setLotacao();
        $this->setPA();
        $this->setListaItemRequisicao();
        $this->setSituacaoPorId($this->requisicaoMaterial->getSituacaoId());
    }

    function setRequisitante() {
        $wsFuncionario = new Funcionario();
        $requisitante = $wsFuncionario->buscarPorMatricula($this->requisicaoMaterial->getMatriculaRequisitante());
        $this->requisicaoMaterial->setRequisitante($requisitante);
        unset($wsFuncionario);
    }

    function setResponsavel() {
        $wsFuncionario = new Funcionario();
        $responsavel = $wsFuncionario->buscarPorMatricula($this->requisicaoMaterial->getMatriculaResponsavel());
        $this->requisicaoMaterial->setResponsavel($responsavel);
        unset($wsFuncionario);
    }

    function setLotacao() {
        $wsLotacao = new Lotacao();
        $lotacao = $wsLotacao->buscarPorId($this->requisicaoMaterial->getLotacaoId());
        $this->requisicaoMaterial->setLotacao($lotacao);
        unset($wsLotacao);
    }

    function setListaItemRequisicao() {
        $materItemRequisicao = new ManterItemRequisicaoMaterial();
        $listaItemRequisicao = $materItemRequisicao->listarItensRequisicaoPorId($this->requisicaoMaterial->getId());
//        $this->requisicaoMaterial->adicionarItemRequisicao($itemRequisicao);
        $this->requisicaoMaterial->setListaItemRequisicao($listaItemRequisicao);
        unset($materItemRequisicao);
    }

    private function setSituacaoPorCodigo($codigo) {
        $manterSituacao = new ManterSituacaoRequisicao();
        $situacao = $manterSituacao->buscarPorCodigo($codigo);
        $this->requisicaoMaterial->setSituacao($situacao);
        $this->requisicaoMaterial->setSituacaoId($situacao->getId());
        unset($manterSituacao);
//        return $situacao;
    }

    private function setSituacaoPorId($id) {
        $manterSituacao = new ManterSituacaoRequisicao();
        $situacao = $manterSituacao->buscarPorId($id);
        $this->requisicaoMaterial->setSituacao($situacao);
        $this->requisicaoMaterial->setSituacaoId($situacao->getId());

        unset($manterSituacao);
//        return $situacao;
    }

    private function setPA() {
        $pa = new PA();
        $this->requisicaoMaterial->setPa($pa->buscarPaPorId($this->requisicaoMaterial->getPaId()));
        unset($pa);
    }

    function setAtributos($atributos) {
        $this->requisicaoMaterial->setId($atributos->id);
        $this->requisicaoMaterial->setNumero($atributos->numero);
        $this->requisicaoMaterial->setMatriculaRequisitante($atributos->matriculaRequisitante);
        $this->requisicaoMaterial->setMatriculaResponsavel($atributos->matriculaResponsavel);
        $this->requisicaoMaterial->setPaId($atributos->paId);
        $this->requisicaoMaterial->setLotacaoId($atributos->lotacaoId);
        $this->requisicaoMaterial->setAno($atributos->ano);
    }

    function setListaItemRequisicaoAtributos($listaItemRequisicao) {
        foreach ($listaItemRequisicao as $itemRequisicao) {
            $this->requisicaoMaterial->adicionarItemRequisicao($this->manterItemRequisicaoMaterial->setAtributos((object) $itemRequisicao));
        }
    }

    function getRequisicaoMaterial() {
        return $this->requisicaoMaterial;
    }

    function setRequisicaoMaterial($requisicaoMaterial) {
        $this->requisicaoMaterial = $requisicaoMaterial;
    }

    public function __destruct() {
        unset($this->requisicaoMaterial, $this->requisicaoMaterialDao);
    }

}
