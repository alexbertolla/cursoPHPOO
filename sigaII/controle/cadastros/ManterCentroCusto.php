<?php

/* * 
 * ***************************************************************************
 * Classe referente ao caso de uso Manter Centro de Custo, que está
 * documentado no Documento de Especificação de Arquitetura do Produto de
 * Software.
 * 
 * Perfil dos usuários que a utilizarão: Usuário SPS e Administrador do Sistema
 * 
 * Resumo: Faz o controle da classe modelo CentroDeCusto e da classe de acesso
 * ao banco de dados CentroDeCustoDao.
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

use modelo\cadastros\CentroDeCusto,
    dao\cadastros\CentroDeCustoDao,
    controle\configuracao\GerenciarLog;

class ManterCentroCusto {

    private $centroCusto;
    private $centroCustoDao;
    private $log;

    public function __construct() {
        $this->centroCusto = new CentroDeCusto();
        $this->centroCustoDao = new CentroDeCustoDao();
        $this->log = new GerenciarLog();
    }

    function listar() {
        return $this->listaBdToForm($this->centroCustoDao->ListarDao());
    }

    function listarAtivos() {
        return $this->listaBdToForm($this->centroCustoDao->listarAtivosDao());
    }

    function listarPorNome($nome) {
        $nome = $this->utf8Decode($nome);
        return $this->listaBdToForm($this->centroCustoDao->listarPorNomeDao($nome));
    }

    function listarPorNomeAtivo($nome) {
        $nome = $this->utf8Decode($nome);
        return $this->listaBdToForm($this->centroCustoDao->listarPorNomeAtivoDao($nome));
    }

    function listarPorMaterialConsumoId($materialConsumoId) {
        return $this->listaBdToForm($this->centroCustoDao->listarPorMaterialConsumoIdDao($materialConsumoId));
    }

    function buscarPorId($id) {
        $this->setCentroCusto($this->centroCustoDao->buscarPorIdDao($id));
        $this->bdToForm();
        return $this->getCentroCusto();
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
        $this->log->registarLog($opcao, "{$ação} - Centro de Custo", $this->centroCusto->toString());
        
        return $resultado;
    }

    private function inserir() {

        $id = $this->centroCustoDao->inserirDao($this->centroCusto->getCodigo(), $this->centroCusto->getNome(), $this->centroCusto->getSituacao());
        if ($id) {
            $this->centroCusto->setId($id);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function alterar() {
        return $this->centroCustoDao->alterarDao($this->centroCusto->getId(), $this->centroCusto->getCodigo(), $this->centroCusto->getNome(), $this->centroCusto->getSituacao());
    }

    private function excluir() {
        return $this->centroCustoDao->excluirDao($this->centroCusto->getId());
    }

    function listaBdToForm($lista) {
        foreach ($lista as $centroCusto) {
            $this->setCentroCusto($centroCusto);
            $this->bdToForm();
        }
        return $lista;
    }

    function bdToForm() {
        if (!is_null($this->centroCusto)) {
            $this->encode();
        }
    }

    function formToBd() {
        $this->decode();
    }

    private function encode() {
        $this->centroCusto->setNome($this->utf8Encode($this->centroCusto->getNome()));
    }

    private function decode() {
        $this->centroCusto->setNome($this->utf8Decode($this->centroCusto->getNome()));
    }

    private function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    private function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    function setAtributos($atributos) {
        $this->centroCusto->setId($atributos->id);
        $this->centroCusto->setCodigo($atributos->codigo);
        $this->centroCusto->setNome($atributos->nome);
        $this->centroCusto->setSituacao(($atributos->situacao) ? 1 : 0);
    }

    function getCentroCusto() {
        return $this->centroCusto;
    }

    function setCentroCusto($centroCusto) {
        $this->centroCusto = $centroCusto;
    }

    public function __destruct() {
        unset($this->centroCusto, $this->centroCustoDao, $this->log);
    }

}
