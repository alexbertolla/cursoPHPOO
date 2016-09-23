<?php

/* * 
 * ***************************************************************************
 * Classe referente ao caso de uso Manter Material Permanente, que está
 * documentado no Documento de Especificação de Arquitetura do Produto de
 * Software.
 * 
 * Perfil dos usuários que a utilizarão: Usuário SPS e Administrador do Sistema
 * 
 * Resumo: Estensão da classe ManterItem. Faz todo o controle da classe
 * MaterialPermanente e MaterialPermanenteDao, além de acessar os métodos da super classe.
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

use modelo\cadastros\MaterialPermanente,
    dao\cadastros\MaterialPermanenteDao,
    controle\cadastros\ManterItem,
    configuracao\DataSistema;

class ManterMaterialPermanente extends ManterItem {

    private $materialPermanente;
    private $materialPermanenteDao;

    public function __construct() {
        parent::__construct();
        $this->materialPermanente = new MaterialPermanente();
        $this->materialPermanenteDao = new MaterialPermanenteDao();
    }

    public function __destruct() {
        parent::__destruct();
        unset($this->materialPermanente, $this->materialPermanenteDao);
    }

    function setDadosMaterialPermanente() {
        parent::setDadosItem($this->getMaterialPermanente());
    }

    function setDadosListaMaterialPermanente($lista) {
        foreach ($lista as $materialPermanente) {
            $this->setMaterialPermanente($materialPermanente);
            $this->setDadosMaterialPermanente();
        }
        return $lista;
    }

    function listar() {
        return $this->listaBdToForm($this->materialPermanenteDao->listarDao());
    }

    function listarAtivos() {
        return $this->listaBdToForm($this->materialPermanenteDao->listarAtivosDao());
    }

    function listarPorGrupoAtivo($grupoId) {
        return $this->listaBdToForm($this->materialPermanenteDao->listarPorGrupoAtivoDao($grupoId));
    }

    function listarPorNome($nome) {
        return $this->listaBdToForm($this->materialPermanenteDao->listarPorNomeDao($nome));
    }

    function listarPorNomeAtivo($nome) {
        return $this->listaBdToForm($this->materialPermanenteDao->listarPorNomeAtivoDao($nome));
    }

    function listarPorNomeDescricaoOuCodigo($nome) {
        return $this->listaBdToForm($this->materialPermanenteDao->listarPorNomeDescricaoOuCodigoDao($this->utf8Decode($nome)));
    }

    function listarPorNomeDescricaoOuCodigoAtivo($nome) {
        return $this->listaBdToForm($this->materialPermanenteDao->listarPorNomeDescricaoOuCodigoAtivoDao($this->utf8Decode($nome)));
    }

    function listarPorNomeDescricaoOuCodigoEGrupoAtivo($nome, $grupoId) {
        return $this->listaBdToForm($this->materialPermanenteDao->listarPorNomeDescricaoOuCodigoEGrupoAtivoDao($this->utf8Decode($nome), $grupoId));
    }

    function buscarPorCodigo($codigo) {
        $this->setMaterialPermanente($this->materialPermanenteDao->buscarPorCodigoDao($codigo));
        $this->bdToForm();
        return $this->getMaterialPermanente();
    }

    function buscarPorId($id) {
        $this->setMaterialPermanente($this->materialPermanenteDao->buscarPorIdDao($id));
        $this->bdToForm();
        return $this->getMaterialPermanente();
    }

    function salvar($opcao) {
        $this->formToBd();
        switch ($opcao) {
            case "inserir":
                $resultado = $this->inserirMaterialPermanente();
                break;
            case "alterar":
                $resultado = $this->alterarMaterialPermanente();
                break;
            case "excluir":
                $resultado = $this->excluirMaterialPermanente();
                break;
        }

        $ação = ($resultado) ? "manutenção cadastral realizada com sucesso" : "erro ao realizar manutenção cadastral";
        $this->log->registarLog($opcao, "{$ação} - Material Permanente", $this->materialPermanente->toString());
        return $resultado;
    }

    private function inserirMaterialPermanente() {
        if ($this->salvarItem("inserir", $this->materialPermanente)) {
            return $this->materialPermanenteDao->inserirMaterialPermanenteDao($this->materialPermanente->getId(), $this->materialPermanente->getMarca(), $this->materialPermanente->getModelo(), $this->materialPermanente->getPartNumber());
        } else {
            return FALSE;
        }
    }

    private function alterarMaterialPermanente() {
        if ($this->salvarItem("alterar", $this->materialPermanente)) {
            return $this->materialPermanenteDao->alterarMaterialPermanenteDao($this->materialPermanente->getId(), $this->materialPermanente->getMarca(), $this->materialPermanente->getModelo(), $this->materialPermanente->getPartNumber());
        } else {
            return FALSE;
        }
    }

    private function excluirMaterialPermanente() {
        return $this->salvarItem("excluir", $this->materialPermanente);
    }

    function formToBd() {
        $data = new DataSistema();
        $this->decode();
        $this->materialPermanente->setDataCadastro($data->BRtoISO($this->materialPermanente->getDataCadastro()));
        $this->materialPermanente->setDataAtualizacao($data->BRtoISO($this->materialPermanente->getDataAtualizacao()));
        unset($data);
    }

    function bdToForm() {
        if ($this->materialPermanente) {
            $data = new DataSistema();
            $this->encode();
            $this->materialPermanente->setDataCadastro($data->ISOtoBR($this->materialPermanente->getDataCadastro()));
            $this->materialPermanente->setDataAtualizacao($data->ISOtoBR($this->materialPermanente->getDataAtualizacao()));
            unset($data);
        }
    }

    function listaBdToForm($lista) {
        foreach ($lista as $materialPermanente) {
            $this->setMaterialPermanente($materialPermanente);
            $this->bdToForm();
        }
        return $lista;
    }

    private function decode() {
        $this->materialPermanente->setNome($this->utf8Decode($this->materialPermanente->getNome()));
        $this->materialPermanente->setDescricao($this->utf8Decode($this->materialPermanente->getDescricao()));
        $this->materialPermanente->setMarca($this->utf8Decode($this->materialPermanente->getMarca()));
        $this->materialPermanente->setModelo($this->utf8Decode($this->materialPermanente->getModelo()));
    }

    private function encode() {
        $this->materialPermanente->setNome($this->utf8Encode($this->materialPermanente->getNome()));
        $this->materialPermanente->setDescricao($this->utf8Encode($this->materialPermanente->getDescricao()));
        $this->materialPermanente->setMarca($this->utf8Encode($this->materialPermanente->getMarca()));
        $this->materialPermanente->setModelo($this->utf8Encode($this->materialPermanente->getModelo()));
    }

    private function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    private function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    function setAtributos($atributos) {
        $this->setAtributosItem($this->materialPermanente, $atributos);
        $this->materialPermanente->setMarca($atributos->marca);
        $this->materialPermanente->setModelo($atributos->modelo);
        $this->materialPermanente->setPartNumber($atributos->partNumber);
    }

    function getMaterialPermanente() {
        return $this->materialPermanente;
    }

    function setMaterialPermanente($materialPermanente) {
        $this->materialPermanente = $materialPermanente;
    }

}
