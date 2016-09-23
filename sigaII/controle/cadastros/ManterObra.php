<?php

/* * 
 * ***************************************************************************
 * Classe referente ao caso de uso Manter Obra, que está
 * documentado no Documento de Especificação de Arquitetura do Produto de
 * Software.
 * 
 * Perfil dos usuários que a utilizarão: Usuário SPS e Administrador do Sistema
 * 
 * Resumo: Estensão da classe ManterItem. Faz todo o controle da classe Obra e
 * ObraDao, além de acessar os métodos da super classe.
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

use modelo\cadastros\Obra,
    dao\cadastros\ObraDao,
    sgp\Funcionario,
    configuracao\DataSistema,
    sgp\Lotacao;

class ManterObra extends ManterItem {

    private $obra;
    private $obraDao;

    public function __construct() {
        parent::__construct();
        $this->obra = new Obra();
        $this->obraDao = new ObraDao();
    }

    public function __destruct() {
        parent::__destruct();
        unset($this->obra, $this->obraDao);
    }

    private function setResponsavel() {
        $funcionario = new Funcionario();
        $this->obra->setResponsavelClass($funcionario->buscarPorMatricula($this->obra->getResponsavel()));
        unset($funcionario);
    }

    private function setBemPrinciapl() {
        $lotacao = new Lotacao();
        $this->obra->setBemPrincipalClass($lotacao->buscarPorId($this->obra->getBemPrincipal()));
    }

    function setDadosObra() {
        parent::setDadosItem($this->obra);
        $this->setResponsavel();
        $this->setBemPrinciapl();
    }

    function setDadosListaObras($listaObras) {
        foreach ($listaObras as $obra) {
            $this->setObra($obra);
            $this->setDadosObra();
        }
        return $listaObras;
    }

    function listar() {
        return $this->listaBdToForm($this->obraDao->listarDao());
    }

    function listarAtivos() {
        return $this->listaBdToForm($this->obraDao->listarAtivosDao());
    }

    function listarPorGrupoAtivo($grupoId) {
        return $this->listaBdToForm($this->obraDao->listarPorGrupoAtivoDao($grupoId));
    }

    function listarPorNome($nome) {
        return $this->listaBdToForm($this->obraDao->listarPorNomeDao($nome));
    }

    function listarPorNomeAtivo($nome) {
        return $this->listaBdToForm($this->obraDao->listarPorNomeAtivoDao($nome));
    }

    function listarPorNomeDescricaoOuCodigo($nome) {
        return $this->listaBdToForm($this->obraDao->listarPorNomeDescricaoOuCodigoDao($this->utf8Decode($nome)));
    }

    function listarPorNomeDescricaoOuCodigoAtivo($nome) {
        return $this->listaBdToForm($this->obraDao->listarPorNomeDescricaoOuCodigoAtivoDao($this->utf8Decode($nome)));
    }

    function listarPorNomeDescricaoOuCodigoEGrupoAtivo($nome, $grupoId) {
        return $this->listaBdToForm($this->obraDao->listarPorNomeDescricaoOuCodigoEGrupoAtivoDao($this->utf8Decode($nome), $grupoId));
    }

    function buscarPorId($id) {
        $this->setObra($this->obraDao->buscarPorIdDao($id));
        $this->bdToForm();
        return $this->getObra();
    }

    function buscarPorCodigo($codigo) {
        $this->setObra($this->obraDao->buscarPorCodigoDao($codigo));
        $this->bdToForm();
        return $this->getObra();
    }

    function buscarPorCodigoAtivo($codigo) {
        $this->setObra($this->obraDao->buscarPorCodigoAtivoDao($codigo));
        $this->bdToForm();
        return $this->getObra();
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
        $this->log->registarLog($opcao, "{$ação} - Obra", $this->obra->toString());
        return $resultado;
    }

    private function inserir() {
        if ($this->salvarItem("inserir", $this->obra)) {
            return $this->obraDao->inserirObraDao($this->obra->getId(), $this->obra->getResponsavel(), $this->obra->getBemPrincipal(), $this->obra->getLocal());
        } else {
            return FALSE;
        }
    }

    private function alterar() {

        if ($this->salvarItem("alterar", $this->obra)) {
            return $this->obraDao->alterarObraDao($this->obra->getId(), $this->obra->getResponsavel(), $this->obra->getBemPrincipal(), $this->obra->getLocal());
        }
        return FALSE;
    }

    private function excluir() {
        return $this->salvarItem("excluir", $this->obra);
    }

    function formToBd() {
        $data = new DataSistema();
        $this->decode();
        $this->obra->setDataAtualizacao($data->BRtoISO($this->obra->getDataAtualizacao()));
        unset($data);
    }

    function bdToForm() {
        if ($this->obra) {
            $data = new DataSistema();
            $this->encode();
            $this->obra->setDataAtualizacao($data->ISOtoBR($this->obra->getDataAtualizacao()));
            unset($data);
        }
    }

    function listaBdToForm($lista) {
        foreach ($lista as $obra) {
            $this->setObra($obra);
            $this->bdToForm();
        }
        return $lista;
    }

    private function decode() {
        $this->obra->setNome($this->utf8Decode($this->obra->getNome()));
        $this->obra->setDescricao($this->utf8Decode($this->obra->getDescricao()));
        $this->obra->setLocal($this->utf8Decode($this->obra->getLocal()));
    }

    private function encode() {
        $this->obra->setNome($this->utf8Encode($this->obra->getNome()));
        $this->obra->setDescricao($this->utf8Encode($this->obra->getDescricao()));
        $this->obra->setLocal($this->utf8Encode($this->obra->getLocal()));
    }

    private function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    private function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    function setAtributos($atributos) {
        $this->setAtributosItem($this->obra, $atributos);
        $this->obra->setResponsavel($atributos->responsavel);
        $this->obra->setLocal($atributos->local);
        $this->obra->setBemPrincipal($atributos->bemPrincipal);
    }

    function getObra() {
        return $this->obra;
    }

    function setObra($obra) {
        $this->obra = $obra;
    }

}
