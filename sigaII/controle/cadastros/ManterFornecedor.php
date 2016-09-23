<?php

namespace controle\cadastros;

use modelo\cadastros\Fornecedor,
    dao\cadastros\FornecedorDao,
    ArrayObject,
    controle\cadastros\ManterTelefone,
    controle\cadastros\ManterEndereco,
    controle\cadastros\ManterEmailFornecedor,
    controle\cadastros\ManterDadosBancarios,
    controle\cadastros\ManterGrupo,
    controle\configuracao\GerenciarLog;

class ManterFornecedor {

    protected $fornecedorDao;
    protected $log;

    public function __construct() {
        $this->fornecedorDao = new FornecedorDao();
        $this->log = new GerenciarLog();
    }

    public function __destruct() {
        unset($this->fornecedorDao, $this->log);
    }

    function SetDadosFornecedor($fornecedor) {
        if ($fornecedor instanceof Fornecedor) {
            $fornecedor->setTelefone($this->setTelefone($fornecedor));
            $fornecedor->setEndereco($this->setEndereco($fornecedor));
            $fornecedor->setEmail($this->setEmail($fornecedor));
            $fornecedor->setDadosBancarios($this->setDadosBancarios($fornecedor));
        }
    }

    private function setTelefone(Fornecedor $fornecedor) {
        $mantrerTelefone = new ManterTelefone();
        return $mantrerTelefone->listarPorFornecedorId($fornecedor->getId());
    }

    private function setEndereco(Fornecedor $fornecedor) {
        $manterEndereco = new ManterEndereco();
        return $manterEndereco->buscarPorFornecedorId($fornecedor->getId());
    }

    private function setEmail(Fornecedor $fornecedor) {
        $manterEmail = new ManterEmailFornecedor();
        return $manterEmail->listarPorFornecedorId($fornecedor->getId());
    }

    private function setDadosBancarios(Fornecedor $fornecedor) {
        $manterDadosBancarios = new ManterDadosBancarios();
        return $manterDadosBancarios->listarPorFornecedorId($fornecedor->getId());
    }

    protected function salvarFornecedor($opcao, Fornecedor $fornecedor) {
        switch ($opcao) {
            case "inserir":
                $resultado = $this->inserirFornecedor($fornecedor);
                break;
            case "alterar":
                $resultado = $this->alterarFornecedor($fornecedor);
                break;
            case "excluir":
                $resultado = $this->excluirFornecedor($fornecedor);
                break;
        }
        return $resultado;
    }

    private function inserirFornecedor(Fornecedor $fornecedor) {
        $id = $this->fornecedorDao->inserirFornecedorDao($fornecedor->getNome(), $fornecedor->getSite(), $fornecedor->getSituacao(), $fornecedor->getTipo());
        if ($id) {
            $fornecedor->setId($id);
            return TRUE;
        }
    }

    private function alterarFornecedor(Fornecedor $fornecedor) {
        return $this->fornecedorDao->alterarFornecedorDao($fornecedor->getId(), $fornecedor->getNome(), $fornecedor->getSite(), $fornecedor->getSituacao());
    }

    private function excluirFornecedor(Fornecedor $fornecedor) {
        return $this->fornecedorDao->excluirFornecedorDao($fornecedor->getId());
    }

    function listarPorProcessoCompra($processoCompraId) {

        return $this->fornecedorDao->listarPorProcessoCompraDao($processoCompraId);
    }

    protected function padronizarDocumento($documento) {
        return preg_replace('/[^0-9]/', '', $documento);
    }

    function atualizarGrupoFornecedor($grupoId, $fornecedorId) {
        $manterGrupo = new ManterGrupo();
        $atualizarGrupo = $manterGrupo->atualizarGrupoFornecedor($grupoId, $fornecedorId);
        unset($manterGrupo);
        return $atualizarGrupo;
    }

}
