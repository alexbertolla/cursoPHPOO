<?php

/* * 
 * ***************************************************************************
 * Classe referente ao caso de uso Manter Conta Contabil, que está
 * documentado no Documento de Especificação de Arquitetura do Produto de
 * Software.
 * 
 * Perfil dos usuários que a utilizarão: Usuário SPS e Administrador do Sistema
 * 
 * Resumo: Faz o controle da classe modelo ContaContabil e da classe de acesso
 * ao banco de dados ContaContabilDao.
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

use modelo\cadastros\ContaContabil,
    dao\cadastros\ContaContabilDao,
    controle\configuracao\GerenciarLog;

class ManterContaContabil {

    private $contaContabil;
    private $contaContabilDao;
    private $log;

    public function __construct() {
        $this->contaContabil = new ContaContabil();
        $this->contaContabilDao = new ContaContabilDao();
        $this->log = new GerenciarLog();
    }

    public function __destruct() {
        unset($this->contaContabil, $this->contaContabilDao, $this->log);
    }

    function listar() {
        return $this->listaBdToForm($this->contaContabilDao->listarDao());
    }

    function listarAtivas() {
        return $this->listaBdToForm($this->contaContabilDao->listarAtivasDao());
    }

    function listarPorNome($nome) {
        $nome = $this->utf8Decode($nome);
        return $this->listaBdToForm($this->contaContabilDao->listarPorNomeDao($nome));
    }

    function listarPorNomeAtivo($nome) {
        $nome = $this->utf8Decode($nome);
        return $this->listaBdToForm($this->contaContabilDao->listarPorNomeAtivoDao($nome));
    }

    function buscarPorCodigoAtivo($codigo) {
        $this->setContaContabil($this->contaContabilDao->buscarPorCodigoAtivoDao($codigo));
        $this->bdToForm();
        return $this->getContaContabil();
    }

    function buscarPorId($id) {
        $this->setContaContabil($this->contaContabilDao->buscarPorIdDao($id));
        $this->bdToForm();
        return $this->getContaContabil();
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
        $this->log->registarLog($opcao, "{$ação} - Conta Contabil", $this->contaContabil->toString());
        return $resultado;
    }

    private function inserir() {
        $id = $this->contaContabilDao->inserirDao($this->contaContabil->getCodigo(), $this->contaContabil->getNome(), $this->contaContabil->getSituacao());
        if ($id) {
            $this->contaContabil->setId($id);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function alterar() {
        return $this->contaContabilDao->alterarDao($this->contaContabil->getId(), $this->contaContabil->getCodigo(), $this->contaContabil->getNome(), $this->contaContabil->getSituacao());
    }

    private function excluir() {
        return $this->contaContabilDao->excluirDao($this->contaContabil->getId());
    }

    function listaBdToForm($lista) {
        foreach ($lista as $contaContabil) {
            $this->setContaContabil($contaContabil);
            $this->bdToForm();
        }
        return $lista;
    }

    function bdToForm() {
        if (!is_null($this->contaContabil)) {
            $this->encode();
        }
    }

    function formToBd() {
        $this->decode();
    }

    private function encode() {
        $this->contaContabil->setNome($this->utf8Encode($this->contaContabil->getNome()));
    }

    private function decode() {
        $this->contaContabil->setNome($this->utf8Decode($this->contaContabil->getNome()));
    }

    private function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    private function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    function setAtributos($atributos) {
        $this->contaContabil->setId($atributos->id);
        $this->contaContabil->setCodigo($atributos->codigo);
        $this->contaContabil->setNome($atributos->nome);
        $this->contaContabil->setSituacao(($atributos->situacao) ? 1 : 0);
    }

    function getContaContabil() {
        return $this->contaContabil;
    }

    function setContaContabil($contaContabil) {
        $this->contaContabil = $contaContabil;
    }

}
