<?php

/* * 
 * ***************************************************************************
 * Classe referente ao caso de uso Manter Órgão Controlador, que está
 * documentado no Documento de Especificação de Arquitetura do Produto de
 * Software.
 * 
 * Perfil dos usuários que a utilizarão: Usuário SPS e Administrador do Sistema
 * 
 * Resumo: Faz o controle da classe modelo OrgaoControlador e da classe de acesso
 * ao banco de dados OrgaoControladorDao.
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

use modelo\cadastros\OrgaoControlador,
    dao\cadastros\OrgaoControladorDao,
    controle\configuracao\GerenciarLog;

class ManterOrgaoControlador {

    private $orgaoControlador;
    private $orgaoControladorDao;
    private $log;

    public function __construct() {
        $this->orgaoControlador = new OrgaoControlador();
        $this->orgaoControladorDao = new OrgaoControladorDao();
        $this->log = new GerenciarLog();
    }

    public function __destruct() {
        unset($this->log, $this->orgaoControlador, $this->orgaoControladorDao);
    }

    function listar() {
        return $this->listaBdToForm($this->orgaoControladorDao->listarDao());
    }

    function listarAtivos() {
        return $this->listaBdToForm($this->orgaoControladorDao->listarAtivosDao());
    }

    function listarPorNome($nome) {
        $nome = $this->utf8Decode($nome);
        return $this->listaBdToForm($this->orgaoControladorDao->listarPorNomeDao($nome));
    }

    function listarPorNomeAtivo($nome) {
        $nome = $this->utf8Decode($nome);
        return $this->listaBdToForm($this->orgaoControladorDao->listarPorNomeAtivoDao($nome));
    }

    function buscarPorId($id) {
        $this->setOrgaoControlador($this->orgaoControladorDao->buscarPorIdDao($id));
        $this->bdToForm();
        return $this->getOrgaoControlador();
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
        $this->log->registarLog($opcao, "{$ação} - Orgão Controlador", $this->orgaoControlador->toString());
        return $resultado;
    }

    private function inserir() {
        $id = $this->orgaoControladorDao->inserirDao($this->orgaoControlador->getNome(), $this->orgaoControlador->getSituacao());
        if ($id) {
            $this->orgaoControlador->setId($id);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function alterar() {
        return $this->orgaoControladorDao->alterarDao($this->orgaoControlador->getId(), $this->orgaoControlador->getNome(), $this->orgaoControlador->getSituacao());
    }

    private function excluir() {
        return $this->orgaoControladorDao->excluirDao($this->orgaoControlador->getId());
    }

    function formToBd() {
        $this->decode();
    }

    function bdToForm() {
        if (!is_null($this->orgaoControlador)) {
            $this->encode();
        }
    }

    function listaBdToForm($lista) {
        foreach ($lista as $orgaoControlador) {
            $this->setOrgaoControlador($orgaoControlador);
            $this->bdToForm();
        }
        return $lista;
    }

    private function decode() {
        $this->orgaoControlador->setNome($this->utf8Decode($this->orgaoControlador->getNome()));
    }

    private function encode() {
        $this->orgaoControlador->setNome($this->utf8Encode($this->orgaoControlador->getNome()));
    }

    private function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    private function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    function setAtributos($atributos) {
        $this->orgaoControlador->setId($atributos->id);
        $this->orgaoControlador->setNome($atributos->nome);
        $this->orgaoControlador->setSituacao(($atributos->situacao) ? 1 : 0);
    }

    function getOrgaoControlador() {
        return $this->orgaoControlador;
    }

    function setOrgaoControlador($orgaoControlador) {
        $this->orgaoControlador = $orgaoControlador;
    }

}
