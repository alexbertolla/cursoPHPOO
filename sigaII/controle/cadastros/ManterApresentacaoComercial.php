<?php

/* * 
 * ***************************************************************************
 * Classe referente ao caso de uso Manter Apresentação Comercial, que está
 * documentado no Documento de Especificação de Arquitetura do Produto de
 * Software.
 * 
 * Perfil dos usuários que a utilizarão: Usuário SPS e Administrador do Sistema
 * 
 * Resumo: Faz o controle da classe modelo ApresentacaoComercial e da classe de acesso
 * ao banco de dados ApresentacaoComercialDao.
 * 
 * Se relaciona com a classe modelo Grupo através da classe de controle ManterGrupo
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

use modelo\cadastros\ApresentacaoComercial,
    dao\cadastros\ApresentacaoComercialDao,
    controle\cadastros\ManterGrupo,
    controle\configuracao\GerenciarLog;

class ManterApresentacaoComercial {

    private $apresentacaoComercial;
    private $apresentacaoComercialDao;
    private $log;

    public function __construct() {
        $this->apresentacaoComercial = new ApresentacaoComercial();
        $this->apresentacaoComercialDao = new ApresentacaoComercialDao();
        $this->log = new GerenciarLog();
    }

    public function __destruct() {
        unset($this->apresentacaoComercial, $this->apresentacaoComercialDao, $this->log);
    }

    function setDetalhesApresentacaoComercial() {
        $manterGrupo = new ManterGrupo();
        $this->apresentacaoComercial->setGrupo($manterGrupo->buscarPorId($this->apresentacaoComercial->getGrupoId()));
        unset($manterGrupo);
    }

    function setDetalhesListaApresentacaoComercial($lista) {
        foreach ($lista as $apresentacaoComercial) {
            $this->setApresentacaoComercial($apresentacaoComercial);
            $this->setDetalhesApresentacaoComercial();
        }
        return $lista;
    }

    function listar() {
        return $this->listaBDToForm($this->setDetalhesListaApresentacaoComercial($this->apresentacaoComercialDao->listarDao()));
    }

    function listarAtivas() {
        return $this->listaBDToForm($this->setDetalhesListaApresentacaoComercial($this->apresentacaoComercialDao->listarAtivasDao()));
    }

    function listarPorGrupo($grupoId) {
        return $this->listaBDToForm($this->setDetalhesListaApresentacaoComercial($this->apresentacaoComercialDao->listarPorGrupoDao($grupoId)));
    }

    function listarPorGrupoAtivo($grupoId) {
        return $this->listaBDToForm($this->setDetalhesListaApresentacaoComercial($this->apresentacaoComercialDao->listarPorGrupoAtivoDao($grupoId)));
    }

    function listarPorNome($nome) {
        $nome = $this->utf8Decode($nome);
        return $this->listaBDToForm($this->setDetalhesListaApresentacaoComercial($this->apresentacaoComercialDao->listarPorNomeDao($nome)));
    }

    function listarPorNomeAtivo($nome) {
        $nome = $this->utf8Decode($nome);
        return $this->listaBDToForm($this->setDetalhesListaApresentacaoComercial($this->apresentacaoComercialDao->listarPorNomeAtivoDao($nome)));
    }

    function buscarPorId($id) {
        $this->setApresentacaoComercial($this->apresentacaoComercialDao->buscarPorIdDao($id));
        $this->bdToForm();
        return $this->apresentacaoComercial;
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
        $this->log->registarLog($opcao, "{$ação} - Apresentação Comercial", $this->apresentacaoComercial->toString());
        return $resultado;
    }

    private function inserir() {
        $id = $this->apresentacaoComercialDao->inserirDao($this->apresentacaoComercial->getNome(), $this->apresentacaoComercial->getApresentacaoComercial(), $this->apresentacaoComercial->getQuantidade(), $this->apresentacaoComercial->getSituacao(), $this->apresentacaoComercial->getGrupoId());
        if ($id) {
            $this->apresentacaoComercial->setId($id);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function alterar() {
        return $this->apresentacaoComercialDao->alterarDao($this->apresentacaoComercial->getId(), $this->apresentacaoComercial->getNome(), $this->apresentacaoComercial->getApresentacaoComercial(), $this->apresentacaoComercial->getQuantidade(), $this->apresentacaoComercial->getSituacao(), $this->apresentacaoComercial->getGrupoId());
    }

    private function excluir() {
        return $this->apresentacaoComercialDao->excluirDao($this->apresentacaoComercial->getId());
    }

    function listaBDToForm($lista) {
        foreach ($lista as $apresentacaoComercial) {
            $this->setApresentacaoComercial($apresentacaoComercial);
            $this->bdToForm();
        }
        return $lista;
    }

    function bdToForm() {
        if (!is_null($this->apresentacaoComercial)) {
            $this->encode();
        }
    }

    function formToBd() {
        $this->decode();
    }

    private function encode() {
        $this->apresentacaoComercial->setApresentacaoComercial($this->utf8Encode($this->apresentacaoComercial->getApresentacaoComercial()));
        $this->apresentacaoComercial->setNome($this->utf8Encode($this->apresentacaoComercial->getNome()));
    }

    private function decode() {
        $this->apresentacaoComercial->setApresentacaoComercial($this->utf8Decode($this->apresentacaoComercial->getApresentacaoComercial()));
        $this->apresentacaoComercial->setNome($this->utf8Decode($this->apresentacaoComercial->getNome()));
    }

    private function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    private function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    function setAttributos($atributos) {
        $this->apresentacaoComercial->setId($atributos->id);
        $this->apresentacaoComercial->setGrupoId($atributos->grupoId);
        $this->apresentacaoComercial->setNome($atributos->nome);
        $this->apresentacaoComercial->setApresentacaoComercial($atributos->apresentacaoComercial);
        $this->apresentacaoComercial->setQuantidade($atributos->quantidade);
        $this->apresentacaoComercial->setSituacao(($atributos->situacao) ? 1 : 0);
    }

    function getApresentacaoComercial() {
        return $this->apresentacaoComercial;
    }

    function setApresentacaoComercial($apresentacaoComercial) {
        $this->apresentacaoComercial = $apresentacaoComercial;
    }

}
