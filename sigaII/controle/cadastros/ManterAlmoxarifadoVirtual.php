<?php

/* * 
 * ***************************************************************************
 * Classe referente ao caso de uso Manter Almoxarifado Virtual, que está
 * documentado no Documento de Especificação de Arquitetura do Produto de
 * Software.
 * 
 * Perfil dos usuários que a utilizarão: Usuário SPS e Administrador do Sistema
 * 
 * Resumo: Faz o controle da classe modelo AlmoxarifadoVirtual e da classe de acesso
 * ao banco de dados AlmoxarifadoVirtualDao.
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

use modelo\cadastros\AlmoxarifadoVirtual,
    dao\cadastros\AlmoxarifadoVirtualDao,
    controle\configuracao\GerenciarLog;

class ManterAlmoxarifadoVirtual {

    private $almoxarifadoVirtual;
    private $almoxarifadoVirtualDao;
    private $log;

    public function __construct() {
        $this->almoxarifadoVirtual = new AlmoxarifadoVirtual();
        $this->almoxarifadoVirtualDao = new AlmoxarifadoVirtualDao();
        $this->log = new GerenciarLog();
    }

    public function __destruct() {
        unset($this->almoxarifadoVirtual, $this->almoxarifadoVirtualDao, $this->log);
    }

    function listar() {
        return $this->listaBDToForm($this->almoxarifadoVirtualDao->listarDao());
    }

    function listarAtivos() {
        return $this->listaBDToForm($this->almoxarifadoVirtualDao->listarAtivosDao());
    }

    function listarPorNome($nome) {
        $nome = $this->utf8Decode($nome);
        return $this->listaBDToForm($this->almoxarifadoVirtualDao->listarPorNomeDao($nome));
    }

    function listarPorNomeAtivo($nome) {
        return $this->listaBDToForm($this->almoxarifadoVirtualDao->listarPorNomeAtivoDao($nome));
    }

    function buscarPorId($id) {
        $this->setAlmoxarifadoVirtual($this->almoxarifadoVirtualDao->buscarPorIdDao($id));
        $this->bdToForm();
        return $this->almoxarifadoVirtual;
    }

    function salvar($opcao) {
        $this->formToBD();
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
        $acao = ($resultado) ? "manutenção cadastral realizada com sucesso" : "erro ao realizar manutenção cadastral";
        $this->log->registarLog($opcao, "{$acao} - Almoxarifado Virtual", $this->almoxarifadoVirtual->toString());
        return $resultado;
    }

    private function inserir() {
        $id = $this->almoxarifadoVirtualDao->inserirDao($this->almoxarifadoVirtual->getNome(), $this->almoxarifadoVirtual->getSituacao());
        if ($id) {
            $this->almoxarifadoVirtual->setId($id);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function alterar() {
        return $this->almoxarifadoVirtualDao->alterarDao($this->almoxarifadoVirtual->getId(), $this->almoxarifadoVirtual->getNome(), $this->almoxarifadoVirtual->getSituacao());
    }

    private function excluir() {
        return $this->almoxarifadoVirtualDao->excluirDao($this->almoxarifadoVirtual->getId());
    }

    function listaBDToForm($lista) {
        foreach ($lista as $almoxarifadoVirtual) {
            $this->setAlmoxarifadoVirtual($almoxarifadoVirtual);
            $this->bdToForm();
        }
        return $lista;
    }

    function formToBD() {
        $this->decode();
    }

    function bdToForm() {
        if (!is_null($this->almoxarifadoVirtual)) {
            $this->encode();
        }
    }

    private function encode() {
        $this->almoxarifadoVirtual->setNome($this->utf8Encode($this->almoxarifadoVirtual->getNome()));
    }

    private function decode() {
        $this->almoxarifadoVirtual->setNome($this->utf8Decode($this->almoxarifadoVirtual->getNome()));
    }

    private function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    private function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    function setAtributos($atributos) {
        $this->almoxarifadoVirtual->setId($atributos->id);
        $this->almoxarifadoVirtual->setNome($atributos->nome);
        $this->almoxarifadoVirtual->setSituacao(($atributos->situacao) ? 1 : 0);
    }

    function getAlmoxarifadoVirtual() {
        return $this->almoxarifadoVirtual;
    }

    function setAlmoxarifadoVirtual($almoxarifadoVirtual) {
        $this->almoxarifadoVirtual = $almoxarifadoVirtual;
    }

}
