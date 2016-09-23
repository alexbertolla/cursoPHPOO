<?php

/* * 
 * ***************************************************************************
 * Classe referente ao caso de uso Manter Serviço, que está
 * documentado no Documento de Especificação de Arquitetura do Produto de
 * Software.
 * 
 * Perfil dos usuários que a utilizarão: Usuário SPS e Administrador do Sistema
 * 
 * Resumo: Estensão da classe ManterItem. Faz todo o controle da classe Servico
 * e servicoDao, além de acessar os métodos da super classe.
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

use modelo\cadastros\Servico,
    dao\cadastros\ServicoDao,
    configuracao\DataSistema;

class ManterServico extends ManterItem {

    private $servico;
    private $servicoDao;

    public function __construct() {
        parent::__construct();
        $this->servico = new Servico();
        $this->servicoDao = new ServicoDao();
    }

    public function __destruct() {
        parent::__destruct();
        unset($this->servico, $this->servicoDao);
    }

    function setDadosServico() {
        parent::setDadosItem($this->servico);
    }

    function setDadosListaServicos($listaServicos) {
        foreach ($listaServicos as $servico) {
            $this->setServico($servico);
            $this->setDadosServico();
        }
        return $listaServicos;
    }

    function listar() {
        return $this->listaBdToForm($this->servicoDao->listarDao());
    }

    function listarAtivos() {
        return $this->listaBdToForm($this->servicoDao->listarAtivosDao());
    }

    function listarAtivosPorGrupo($grupoId) {
        return $this->listaBdToForm($this->servicoDao->listarAtivosPorGrupoDao($grupoId));
    }

    function listarPorNome($nome) {
        return $this->listaBdToForm($this->servicoDao->listarPorNomeDao($nome));
    }

    function listarPorNomeAtivo($nome) {
        return $this->listaBdToForm($this->servicoDao->listarPorNomeAtivoDao($nome));
    }

    function listarPorTipo($tipoPessoa) {
        return $this->listaBdToForm($this->servicoDao->listarPorTipoDao($tipoPessoa));
    }

    function listarPorNomeDescricaoOuCodigo($pesquisa) {
        return $this->listaBdToForm($this->servicoDao->listarPorNomeDescricaoOuCodigoDao($this->utf8Decode($pesquisa)));
    }
    function listarPorNomeDescricaoOuCodigoAtivo($nome) {
        return $this->listaBdToForm($this->servicoDao->listarPorNomeDescricaoOuCodigoAitvoDao($this->utf8Decode($nome)));
    }
    function listarPorNomeDescricaoOuCodigoEGrupoAtivo($nome, $grupoId) {
        return $this->listaBdToForm($this->servicoDao->listarPorNomeDescricaoOuCodigoEGrupoAtivoDao($this->utf8Decode($nome), $grupoId));
    }

    function buscarPorCodigo($codigo) {
        $this->setServico($this->servicoDao->buscarPorCodigoDao($codigo));
        $this->bdToForm();
        return $this->getServico();
    }

    function buscarPorCodigoAtivo($codigo) {
        $this->setServico($this->servicoDao->buscarPorCodigoAtivoDao($codigo));
        $this->bdToForm();
        return $this->getServico();
    }

    function buscarPorId($id) {
        $this->setServico($this->servicoDao->buscarPorIdDao($id));
        $this->bdToForm();
        return $this->getServico();
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
        $this->log->registarLog($opcao, "{$ação} - Serviço", $this->servico->toString());

        return $resultado;
    }

    private function inserir() {
        if ($this->salvarItem("inserir", $this->servico)) {
            return $this->servicoDao->inserirServicoDao($this->servico->getId(), $this->servico->getTipo());
        } else {
            return FALSE;
        }
    }

    private function alterar() {
        if ($this->salvarItem("alterar", $this->servico)) {
            return $this->servicoDao->alterarServicoDao($this->servico->getId(), $this->servico->getTipo());
        } else {
            return FALSE;
        }
    }

    private function excluir() {
        return $this->salvarItem("excluir", $this->servico);
    }

    function formToBd() {
        $data = new DataSistema();
        $this->decode();
        $this->servico->setDataCadastro($data->BRtoISO($this->servico->getDataCadastro()));
        $this->servico->setDataAtualizacao($data->BRtoISO($this->servico->getDataAtualizacao()));
        unset($data);
    }

    function bdToForm() {
        if ($this->servico) {
            $data = new DataSistema();
            $this->encode();
            $this->servico->setDataCadastro($data->ISOtoBR($this->servico->getDataCadastro()));
            $this->servico->setDataAtualizacao($data->ISOtoBR($this->servico->getDataAtualizacao()));
            unset($data);
        }
    }

    function listaBdToForm($lista) {
        foreach ($lista as $servico) {
            $this->setServico($servico);
            $this->bdToForm();
        }
        return $lista;
    }

    private function decode() {
        $this->servico->setNome(utf8_decode($this->servico->getNome()));
        $this->servico->setDescricao(utf8_decode($this->servico->getDescricao()));
    }

    private function encode() {
        $this->servico->setNome($this->utf8Encode($this->servico->getNome()));
        $this->servico->setDescricao($this->utf8Encode($this->servico->getDescricao()));
    }

    function setAtributos($atributos) {
        $this->setAtributosItem($this->servico, $atributos);
        $this->servico->setTipo($atributos->tipo);
    }

    private function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    private function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    function getServico() {
        return $this->servico;
    }

    function setServico($servico) {
        $this->servico = $servico;
    }

}
