<?php

/* * 
 * ***************************************************************************
 * Classe referente ao caso de uso Manter Natureza de Despesas, que está
 * documentado no Documento de Especificação de Arquitetura do Produto de
 * Software.
 * 
 * Perfil dos usuários que a utilizarão: Usuário SPS e Administrador do Sistema
 * 
 * Resumo: Faz o controle da classe modelo NaturezaDespesa e da classe de acesso
 * ao banco de dados NaturezaDespesaDao.
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

use modelo\cadastros\NaturezaDespesa,
    dao\cadastros\NaturezaDespesaDao,
    controle\configuracao\GerenciarLog;

class ManterNaturezaDespesa {

    private $nd;
    private $ndDao;
    private $log;

    function listar() {
        return $this->listaBDToForm($this->ndDao->listarDao());
    }

    function listarAtivas() {
        return $this->listaBDToForm($this->ndDao->listarAtivasDao());
    }

    function listarPorNome($nome) {
        return $this->listaBDToForm($this->ndDao->listarPorNomeDao($nome));
    }

    function listarPorNomeOuCodigo($pesquisa) {
        return $this->listaBDToForm($this->ndDao->listarPorNomeOuCodigoDao($this->utf8Decode($pesquisa)));
    }

    function buscarPorId($id) {
        $this->setNd($this->ndDao->buscarPorIdDao($id));
        $this->BDToForm();
        return $this->getNd();
    }

    function buscarPorCodigoAtivo($codigo) {
        $this->setNd($this->ndDao->buscarPorCodigoAtivoDao($codigo));
        $this->BDToForm();
        return $this->getNd();
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
        $ação = ($resultado) ? "manutenção cadastral realizada com sucesso" : "erro ao realizar manutenção cadastral";
        $this->log->registarLog($opcao, "{$ação} - Natureza de Despesas", $this->nd->toString());
        return $resultado;
    }

    private function inserir() {
        $id = $this->ndDao->inserirDao($this->nd->getCodigo(), $this->nd->getNome(), $this->nd->getSituacao(), $this->nd->getTipo());
        if ($id) {
            $this->nd->setId($id);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function alterar() {
        return $this->ndDao->alterarDao($this->nd->getId(), $this->nd->getCodigo(), $this->nd->getNome(), $this->nd->getSituacao(), $this->nd->getTipo());
    }

    private function excluir() {
        return $this->ndDao->excluirDao($this->nd->getId());
    }

    function listaBDToForm($listaNaturezaDespesa) {
        if (!is_null($listaNaturezaDespesa)) {
            foreach ($listaNaturezaDespesa as $naturezaDespesa) {
                $this->setNd($naturezaDespesa);
                $this->BDToForm();
            }
        }
        return $listaNaturezaDespesa;
    }

    function BDToForm() {
        if (!is_null($this->nd)) {
            $this->encode();
        }
    }

    function formToBD() {
        $this->decode();
    }

    private function encode() {
        $this->nd->setNome($this->utf8Encode($this->nd->getNome()));
    }

    private function decode() {
        $this->nd->setNome($this->utf8Decode($this->nd->getNome()));
    }

    private function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    private function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    function __construct() {
        $this->nd = new NaturezaDespesa();
        $this->ndDao = new NaturezaDespesaDao();
        $this->log = new GerenciarLog();
    }

    function __destruct() {
        unset($this->ndDao, $this->log, $this->nd);
    }

    function setAtributos($atributos) {
        $this->nd->setId($atributos->id);
        $this->nd->setCodigo($atributos->codigo);
        $this->nd->setNome($atributos->nome);
        $this->nd->setSituacao(($atributos->situacao) ? 1 : 0);
        $this->nd->setTipo($atributos->tipo);
    }

    function toString($nd) {
        var_dump($nd);
    }

    function getNd() {
        return $this->nd;
    }

    function setNd($nd) {
        $this->nd = $nd;
    }

}
