<?php

/* * 
 * ***************************************************************************
 * Classe referente ao caso de uso Manter Item Controlado, que está
 * documentado no Documento de Especificação de Arquitetura do Produto de
 * Software.
 * 
 * Perfil dos usuários que a utilizarão: Usuário SPS e Administrador do Sistema
 * 
 * Resumo: Faz o controle da classe modelo ItemControlado e da classe de acesso
 * ao banco de dados ItemControladoDao.
 * 
 * Ações: 
 * 
 * Alex Bisetto Bertolla
 * alex.bertolla@embrapa.br
 * (85)3391-7163
 * Núcleo de Tecnologia da Informação
 * Embrapa Agroidústria Tropical
 * 
 * ***************************************************************************
 */

namespace controle\cadastros;

use modelo\cadastros\ItemControlado,
    dao\cadastros\ItemControladoDao,
    controle\cadastros\ManterGrupo,
    controle\cadastros\ManterOrgaoControlador,
    controle\configuracao\GerenciarLog;


class ManterItemControlado {

    private $itemControlado;
    private $itemControladoDao;
    private $log;

    public function __construct() {
        $this->itemControlado = new ItemControlado();
        $this->itemControladoDao = new ItemControladoDao();
        $this->log = new GerenciarLog();
    }

    public function __destruct() {
        unset($this->itemControlado, $this->itemControladoDao, $this->log);
    }

    function setDadosItemControlado() {
        $this->setGrupo();
        $this->setOrgaoControlador();
    }

    function setDadosListaItensControlados($listaItemControlado) {
        foreach ($listaItemControlado as $itemControlado) {
            $this->setItemControlado($itemControlado);
            $this->setDadosItemControlado();
        }
        return $listaItemControlado;
    }

    private function setGrupo() {
        $manterGrupo = new ManterGrupo();
        $this->itemControlado->setGrupo($manterGrupo->buscarPorId($this->itemControlado->getGrupoId()));
        unset($manterGrupo);
    }

    private function setOrgaoControlador() {
        $manterOrgaoControlador = new ManterOrgaoControlador();
        $this->itemControlado->setOrgaoControlador($manterOrgaoControlador->buscarPorId($this->itemControlado->getOrgaoControladorId()));
        unset($manterOrgaoControlador);
    }

    function listar() {
        return $this->listaBdToForm($this->itemControladoDao->listarDao());
    }

    function listarAtivos() {
        return $this->listaBdToForm($this->itemControladoDao->listarAtivosDao());
    }

    function listarPorNome($nome) {
        return $this->listaBdToForm($this->itemControladoDao->listarPorNomeDao($nome));
    }

    function listarPorNomeAtivo($nome) {
        return $this->listaBdToForm($this->itemControladoDao->listarPorNomeAtivoDao($nome));
    }

    function listarPorGrupo($grupoId) {
        return $this->listaBdToForm($this->itemControladoDao->listarPorGrupoDao($grupoId));
    }

    function listarPorGrupoAtivo($grupoId) {
        return $this->listaBdToForm($this->itemControladoDao->listarPorGrupoAtivoDao($grupoId));
    }

    function listarPorOrgaoControlador($orgaoControladorId) {
        return $this->listaBdToForm($this->itemControladoDao->listarPorOrgaoControladorDao($orgaoControladorId));
    }

    function listarPorOrgaoControladorAtivo($orgaoControladorId) {
        return $this->listaBdToForm($this->itemControladoDao->listarPorOrgaoControladorAtivoDao($orgaoControladorId));
    }

    function listarPorGrupoEOrgaoControlador($grupoId, $orgaoControladorId) {
        return $this->listaBdToForm($this->itemControladoDao->listarPorGrupoEOrgaoControladorDao($grupoId, $orgaoControladorId));
    }

    function buscarPorId($id) {
        $this->setItemControlado($this->itemControladoDao->buscarPorIdDao($id));
        $this->bdToForm();
        return $this->getItemControlado();
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
        $ação = ($resultado) ? "manutenção cadastral realizada com sucesso" : "erro ao realizar manutenção cadastral";
        $this->log->registarLog($opcao, "{$ação} - Item Controlado", $this->itemControlado->toString());
        return $resultado;
    }

    private function inserir() {
        $id = $this->itemControladoDao->inserirDao($this->itemControlado->getNome(), $this->itemControlado->getFonte(), $this->itemControlado->getQuantidade(), $this->itemControlado->getApresentacaoComercial(), $this->itemControlado->getSituacao(), $this->itemControlado->getOrgaoControladorId(), $this->itemControlado->getGrupoId());
        if ($id) {
            $this->itemControlado->setId($id);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function alterar() {
        return $this->itemControladoDao->alterarDao($this->itemControlado->getId(), $this->itemControlado->getNome(), $this->itemControlado->getFonte(), $this->itemControlado->getQuantidade(), $this->itemControlado->getApresentacaoComercial(), $this->itemControlado->getSituacao(), $this->itemControlado->getOrgaoControladorId(), $this->itemControlado->getGrupoId());
    }

    private function excluir() {
        return $this->itemControladoDao->excluirDao($this->itemControlado->getId());
    }

    function formToBd() {
        $this->decode();
    }

    function bdToForm() {
        if (!is_null($this->itemControlado)) {
            $this->encode();
        }
    }

    function listaBdToForm($lista) {
        foreach ($lista as $itemControlado) {
            $this->setItemControlado($itemControlado);
            $this->bdToForm();
        }
        return $lista;
    }

    private function decode() {
        $this->itemControlado->setNome($this->utf8Decode($this->itemControlado->getNome()));
        $this->itemControlado->setApresentacaoComercial($this->utf8Decode($this->itemControlado->getApresentacaoComercial()));
        $this->itemControlado->setFonte($this->utf8Decode($this->itemControlado->getFonte()));
    }

    private function encode() {
        $this->itemControlado->setNome($this->utf8Encode($this->itemControlado->getNome()));
        $this->itemControlado->setApresentacaoComercial($this->utf8Encode($this->itemControlado->getApresentacaoComercial()));
        $this->itemControlado->setFonte($this->utf8Encode($this->itemControlado->getFonte()));
    }

    private function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    private function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    function setAtributos($atributos) {
        $this->itemControlado->setId($atributos->id);
        $this->itemControlado->setNome($atributos->nome);
        $this->itemControlado->setFonte($atributos->fonte);
        $this->itemControlado->setApresentacaoComercial($atributos->apresentacaoComercial);
        $this->itemControlado->setQuantidade($atributos->quantidade);
        $this->itemControlado->setSituacao(($atributos->situacao) ? 1 : 0);
        $this->itemControlado->setOrgaoControladorId($atributos->orgaoControladorId);
        $this->itemControlado->setGrupoId($atributos->grupoId);
    }

    function getItemControlado() {
        return $this->itemControlado;
    }

    function setItemControlado($itemControlado) {
        $this->itemControlado = $itemControlado;
    }

}
