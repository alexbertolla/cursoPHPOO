<?php

/* * 
 * ***************************************************************************
 * Classe referente ao caso de uso Manter Item, que está
 * documentado no Documento de Especificação de Arquitetura do Produto de
 * Software.
 * 
 * Perfil dos usuários que a utilizarão: Usuário SPS e Administrador do Sistema
 * 
 * Resumo:Como é uma classe abstrata, só pode ser instanciata através de suas
 * estensões, ManteMaterialConsumo, ManterMaterialPermanente, ManterServico e
 * ManterObra.
 * 
 * Faz todo o controle da classe Item e suas subclasses, e também da classe
 * ItemDao.
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

use dao\cadastros\ItemDao,
    modelo\cadastros\Item,
    controle\cadastros\ManterGrupo,
    controle\cadastros\ManterAlmoxarifadoVirtual,
    controle\configuracao\GerenciarLog;

abstract class ManterItem {

    protected $itemDao;
    protected $log;

    public function __construct() {
        $this->itemDao = new ItemDao();
        $this->log = new GerenciarLog();
    }

    public function __destruct() {
        unset($this->itemDao, $this->log);
    }

    protected function setDadosItem(Item $item) {
        $item->setGrupo($this->setGrupoItem($item->getGrupoId()));
        $item->setAlmoxarifadoVirtual($this->setAlmoxarifadoVirtualItem($item->getAlmoxarifadoVirtualId()));
    }

    private function setGrupoItem($grupoId) {
        $manterGrupo = new ManterGrupo();
        $grupo = $manterGrupo->buscarPorId($grupoId);
        unset($manterGrupo);
        return $grupo;
    }

    private function setAlmoxarifadoVirtualItem($almoxarifadoVirtualId) {
        $manterAV = new ManterAlmoxarifadoVirtual();
        $av = $manterAV->buscarPorId($almoxarifadoVirtualId);
        unset($manterAV);
        return $av;
    }

    protected function salvarItem($opcao, Item $item) {
        switch ($opcao) {
            case "inserir":
                $resultado = $this->inserirItem($item);
                break;
            case "alterar":
                $resultado = $this->alterarItem($item);
                break;
            case "excluir":
                $resultado = $this->excluirItem($item);
                break;
        }
        return $resultado;
    }

    private function inserirItem(Item $item) {
        $id = $this->itemDao->inserirItemDao($item->getCodigo(), $item->getNome(), $item->getDescricao(), $item->getSustentavel(), $item->getSituacao(), $item->getGrupoId(), $item->getAlmoxarifadoVirtualId(), $item->getNaturezaDespesaId());
        if ($id) {
            $item->setId($id);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function alterarItem(Item $item) {
        return $this->itemDao->alterarItemDao($item->getId(), $item->getCodigo(), $item->getNome(), $item->getDescricao(), $item->getSustentavel(), $item->getSituacao(), $item->getGrupoId(), $item->getAlmoxarifadoVirtualId(), $item->getNaturezaDespesaId());
    }

    private function excluirItem(Item $item) {
        return $this->itemDao->excluirItemDao($item->getId());
    }

    protected function setAtributosItem(Item $item, $atributos) {
        $item->setId($atributos->id);
        $item->setCodigo($atributos->codigo);
        $item->setNome($atributos->nome);
        $item->setDescricao($atributos->descricao);
        $item->setDataCadastro($atributos->dataCadastro);
        $item->setDataAtualizacao($atributos->dataAtualizacao);
        $item->setSustentavel(($atributos->sustentavel) ? 1 : 0);
        $item->setSituacao(($atributos->situacao) ? 1 : 0);
        $item->setGrupoId($atributos->grupoId);
        $item->setNaturezaDespesaId($atributos->naturezaDespesaId);
        $item->setAlmoxarifadoVirtualId($atributos->almoxarifadoVirtualId);
    }

}
