<?php

/* * 
 * ***************************************************************************
 * Classe referente ao caso de uso Manter Grupo, que está
 * documentado no Documento de Especificação de Arquitetura do Produto de
 * Software.
 * 
 * Perfil dos usuários que a utilizarão: Usuário SPS e Administrador do Sistema
 * 
 * Resumo: Faz o controle da classe modelo Grupo e da classe de acesso
 * ao banco de dados GrupoDao.
 * Controla também o relacionamento da classe Grupo com outras Classes.
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

use modelo\cadastros\Grupo,
    dao\cadastros\GrupoDao,
    controle\cadastros\ManterNaturezaDespesa,
    controle\cadastros\ManterContaContabil,
    controle\configuracao\GerenciarLog;

class ManterGrupo {

    private $grupo;
    private $grupoDao;
    private $log;

    public function __construct() {
        $this->grupo = new Grupo();
        $this->grupoDao = new GrupoDao();
        $this->log = new GerenciarLog();
    }

    public function __destruct() {
        unset($this->grupo, $this->grupoDao, $this->log);
    }

    function setDadosGrupo() {
        $this->setGrupoNaturezaDesepesa();
        $this->setGrupoContaContabil();
    }

    function setDadosListaGrupos($listaGrupo) {
        foreach ($listaGrupo as $grupo) {
            $this->setGrupo($grupo);
            $this->setDadosGrupo();
        }
        return $listaGrupo;
    }

    private function setGrupoNaturezaDesepesa() {
        $manterND = new ManterNaturezaDespesa();
        $this->grupo->setNaturezaDespesa($manterND->buscarPorId($this->grupo->getNaturezaDespesaId()));
        unset($manterND);
    }

    private function setGrupoContaContabil() {
        $manterCC = new ManterContaContabil();
        $this->grupo->setContaContabil($manterCC->buscarPorId($this->grupo->getContaContabilId()));
        unset($manterCC);
    }

    function listar() {
        return $this->listaBdToForm($this->grupoDao->listarDao());
    }

    function listarAtivos() {
        return $this->listaBdToForm($this->grupoDao->listarAtivosDao());
    }

    function listarPorNome($nome) {
        $nome = $this->utf8Decode($nome);
        return $this->listaBdToForm($this->grupoDao->listarPorNomeDao($nome));
    }

    function listarPorAtivoNome($nome) {
        $nome = $this->utf8Decode($nome);
        return $this->listaBdToForm($this->grupoDao->listarPorNomeAtivoDao($nome));
    }

    function listarAtivosPorNaturezaDespesaId($naturezaDespesaId) {
        return $this->listaBdToForm($this->grupoDao->listarAtivosPorNaturezaDespesaIdDao($naturezaDespesaId));
    }

    function listarAtivosPorTipoNaturezaDespesa($tipo) {
        return $this->listaBdToForm($this->grupoDao->listarAtivosPorTipoNaturezaDespesaDao($tipo));
    }

    function listarAtivosPorFornecedorId($fornecedorId) {
        return $this->listaBdToForm($this->grupoDao->listarAtivosPorFornecedorIdDao($fornecedorId));
    }

    function listarPorNomeOuCodigo($pesquisa) {
        return $this->listaBdToForm($this->grupoDao->listarPorNomeOuCodigoDao($this->utf8Decode($pesquisa)));
    }

    function buscarPorId($id) {
        $this->setGrupo($this->grupoDao->buscarPorIdDao($id));
        $this->bdToForm();
        return $this->grupo;
    }

    function buscarPorCodigo($codigo) {
        $this->setGrupo($this->grupoDao->buscarPorCodigoDao($codigo));
        $this->bdToForm();
        return $this->getGrupo();
    }

    function buscarPorCodigoAtivo($codigo) {
        $this->setGrupo($this->grupoDao->buscarPorCodigoAtivoDao($codigo));
        $this->bdToForm();
        return $this->getGrupo();
    }

    function listarGruposEstoque() {
        return $this->listaBdToForm($this->grupoDao->listarGruposEstoqueDao());
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
        $this->log->registarLog($opcao, "{$ação} - Grupos", $this->grupo->toString());
        return $resultado;
    }

    private function inserir() {

        $id = $this->grupoDao->inserirDao($this->grupo->getCodigo(), $this->grupo->getNome(), $this->grupo->getDescricao(), $this->grupo->getSituacao(), $this->grupo->getNaturezaDespesaId(), $this->grupo->getContaContabilId(), $this->grupo->getTipo());
        if ($id) {
            $this->grupo->setId($id);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function alterar() {
        return $this->grupoDao->alterarDao($this->grupo->getId(), $this->grupo->getCodigo(), $this->grupo->getNome(), $this->grupo->getDescricao(), $this->grupo->getSituacao(), $this->grupo->getNaturezaDespesaId(), $this->grupo->getContaContabilId(), $this->grupo->getTipo());
    }

    private function excluir() {
        return $this->grupoDao->excluirDao($this->grupo->getId());
    }

    function salvarGrupoFornecedor($listaGrupoId, $fornecedorId) {
        if ($this->grupoDao->excluirGurpoPorFornecedorDao($fornecedorId)) {
            foreach ($listaGrupoId as $grupoId) {
                $this->grupoDao->inserirGurpoPorFornecedorDao($grupoId, $fornecedorId);
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function atualizarGrupoFornecedor($grupoId, $fornecedorId) {
        return $this->grupoDao->inserirGurpoPorFornecedorDao($grupoId, $fornecedorId);
    }

    function formToBd() {
        $this->decode();
        $this->addSlashes();
    }

    function bdToForm() {
        if (!is_null($this->grupo)) {
            $this->encode();
            $this->stripSlashes();
        }
    }

    function listaBdToForm($lista) {
        foreach ($lista as $grupo) {
            $this->setGrupo($grupo);
            $this->bdToForm();
        }
        return $lista;
    }

    private function addSlashes() {
        $this->grupo->setNome(addslashes($this->grupo->getNome()));
        $this->grupo->setDescricao(addslashes($this->grupo->getDescricao()));
    }

    private function stripSlashes() {
        $this->grupo->setNome(stripslashes($this->grupo->getNome()));
        $this->grupo->setDescricao(stripslashes($this->grupo->getDescricao()));
    }

    private function decode() {
        $this->grupo->setNome($this->utf8Decode($this->grupo->getNome()));
        $this->grupo->setDescricao($this->utf8Decode($this->grupo->getDescricao()));
    }

    private function encode() {
        $this->grupo->setNome($this->utf8Encode($this->grupo->getNome()));
        $this->grupo->setDescricao($this->utf8Encode($this->grupo->getDescricao()));
    }

    private function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    private function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    function setAtributos($atributos) {
        $this->grupo->setId($atributos->id);
        $this->grupo->setCodigo($atributos->codigo);
        $this->grupo->setContaContabilId($atributos->contaContabilId);
        $this->grupo->setDescricao($atributos->descricao);
        $this->grupo->setNaturezaDespesaId($atributos->naturezaDespesaId);
        $this->grupo->setNome($atributos->nome);
        $this->grupo->setSituacao(($atributos->situacao) ? 1 : 0);
        $this->grupo->setTipo($atributos->tipo);
    }

    function getGrupo() {
        return $this->grupo;
    }

    function setGrupo($grupo) {
        $this->grupo = $grupo;
    }

}
