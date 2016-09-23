<?php

namespace controle\cadastros;

use modelo\cadastros\MaterialConsumo,
    dao\cadastros\MaterialConsumoDao,
    controle\cadastros\ManterItem,
    modelo\cadastros\CentroDeCusto,
    controle\cadastros\ManterCentroCusto,
    controle\cadastros\ManterApresentacaoComercial,
    controle\cadastros\ManterOrgaoControlador,
    controle\cadastros\ManterItemControlado,
    configuracao\DataSistema;

class ManterMaterialConsumo extends ManterItem {

    private $materialConsumo;
    private $materialConsumoDao;

    public function __construct() {
        parent::__construct();
        $this->materialConsumo = new MaterialConsumo();
        $this->materialConsumoDao = new MaterialConsumoDao();
    }

    public function __destruct() {
        parent::__destruct();
        unset($this->materialConsumo, $this->materialConsumoDao);
    }

    private function setCentroDeCustos() {
        $manterCC = new ManterCentroCusto();
        $materialConsumoId = $this->materialConsumo->getId();
        $this->materialConsumo->setCentroDeCusto($listaCentroDeCusto = $manterCC->listarPorMaterialConsumoId($materialConsumoId));
        unset($manterCC);
    }

    private function setApresentacaoComercial() {
        if ($this->materialConsumo->getApresentacaoComercialId()) {
            $manterAC = new ManterApresentacaoComercial();
            $this->materialConsumo->setApresentacaoComercial($manterAC->buscarPorId($this->materialConsumo->getApresentacaoComercialId()));
            unset($manterAC);
        }
    }

    private function setOrgaoControlador() {
        $manterOC = new ManterOrgaoControlador();
        $this->materialConsumo->setOrgaoControlador($manterOC->buscarPorId($this->materialConsumo->getOrgaoControladorId()));
        unset($manterOC);
    }

    private function setItemControlado() {
        $manterIC = new ManterItemControlado();
        $this->materialConsumo->setItemControlado($manterIC->buscarPorId($this->materialConsumo->getItemControladoId()));
        unset($manterIC);
    }

    function setDadosMaterialConsumo() {
        parent::setDadosItem($this->materialConsumo);
        $this->setApresentacaoComercial();
        $this->setCentroDeCustos();
        if ($this->materialConsumo->getControlado()) {
            $this->setOrgaoControlador();
            $this->setItemControlado();
        }
    }

    function setDadosListaMaterialConsumo($lista) {
        if (count($lista) > 0) {
            foreach ($lista as $materialConsumo) {
                $this->setMaterialConsumo($materialConsumo);
                $this->setDadosMaterialConsumo();
            }
        }
        return $lista;
    }

    function listar() {
        return $this->listaBdToForm($this->materialConsumoDao->listarDao());
    }

    function listarAtivos() {
        return $this->listaBdToForm($this->materialConsumoDao->listarAtivosDao());
    }

    function listarPorGrupoAtivo($grupoId) {
        return $this->listaBdToForm($this->materialConsumoDao->listarPorGrupoAtivoDao($grupoId));
    }

    function listarPorNome($nome) {
        return $this->listaBdToForm($this->materialConsumoDao->listarPorNomeDao($nome));
    }

    function buscarPorCodigo($codigo) {
        $this->setMaterialConsumo($this->materialConsumoDao->buscarPorCodigoDao($codigo));
        $this->bdToForm();
        return $this->getMaterialConsumo();
    }

    function buscarPorId($id) {
        $this->setMaterialConsumo($this->materialConsumoDao->buscarPorIdDao($id));
        $this->bdToForm();
        return $this->getMaterialConsumo();
    }

    function listarPorNomeDescricaoOuCodigo($nome) {
        return $this->listaBdToForm($this->materialConsumoDao->listarPorNomeDescricaoOuCodigoDao($this->utf8Decode($nome)));
    }

    function listarPorNomeDescricaoOuCodigoAtivo($nome) {
        return $this->listaBdToForm($this->materialConsumoDao->listarPorNomeDescricaoOuCodigoAtivoDao($this->utf8Decode($nome)));
    }

    function listarPorNomeDescricaoOuCodigoEGrupoAtivo($nome, $grupoId) {
        return $this->listaBdToForm($this->materialConsumoDao->listarPorNomeDescricaoOuCodigoEGrupoAtivoDao($this->utf8Decode($nome), $grupoId));
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
        $this->log->registarLog($opcao, "{$ação} - Material Consumo", $this->materialConsumo->toString());
        return $resultado;
    }

    private function inserir() {
        $salvarItem = $this->salvarItem("inserir", $this->materialConsumo);
        $salvarMC = $this->materialConsumoDao->inserirMaterialConsumoDao($this->materialConsumo->getId(), $this->materialConsumo->getControlado(), $this->materialConsumo->getMarca(), $this->materialConsumo->getModelo(), $this->materialConsumo->getPartNumber(), $this->materialConsumo->getCodigoSinap(), $this->materialConsumo->getOrgaoControladorId(), $this->materialConsumo->getItemControladoId(), $this->materialConsumo->getApresentacaoComercialId());
//        $this->inserirCentroDeCusto();
        return ($salvarItem || $salvarMC) ? TRUE : FALSE;
    }

    private function alterar() {
        if ($this->salvarItem("alterar", $this->materialConsumo)) {
            $this->inserirCentroDeCusto();
            return $this->materialConsumoDao->alterarMaterialConsumoDao($this->materialConsumo->getId(), $this->materialConsumo->getControlado(), $this->materialConsumo->getMarca(), $this->materialConsumo->getModelo(), $this->materialConsumo->getPartNumber(), $this->materialConsumo->getCodigoSinap(), $this->materialConsumo->getOrgaoControladorId(), $this->materialConsumo->getItemControladoId(), $this->materialConsumo->getApresentacaoComercialId());
        }
        return FALSE;
    }

    private function excluir() {
        if ($this->excluirCentroDeCusto()) {
            return $this->salvarItem("excluir", $this->materialConsumo);
        } else {
            return FALSE;
        }
    }

    private function inserirCentroDeCusto() {
        if (count($this->materialConsumo->getCentroDeCusto()) > 0) {
            $this->materialConsumoDao->excluirCentroDeCusto($this->materialConsumo->getId());
            foreach ($this->materialConsumo->getCentroDeCusto() as $centroCusto) {
                $this->materialConsumoDao->inserirCentroDeCusto($this->materialConsumo->getId(), $centroCusto->getId());
            }
        }
    }

    private function excluirCentroDeCusto() {
        return $this->materialConsumoDao->excluirCentroDeCusto($this->materialConsumo->getId());
    }

    function formToBd() {
        $data = new DataSistema();
        $this->materialConsumo->setDataAtualizacao($data->BRtoISO($this->materialConsumo->getDataAtualizacao()));
        $this->materialConsumo->setDataCadastro($data->BRtoISO($this->materialConsumo->getDataCadastro()));
        $this->decode();
    }

    function bdToForm() {
        if ($this->materialConsumo) {
            $data = new DataSistema();
            $this->materialConsumo->setDataAtualizacao($data->ISOtoBR($this->materialConsumo->getDataAtualizacao()));
            $this->materialConsumo->setDataCadastro($data->ISOtoBR($this->materialConsumo->getDataCadastro()));
            $this->encode();
        }
    }

    function listaBdToForm($lista) {
        if (count($lista) > 0) {
            foreach ($lista as $materialConsumo) {
                $this->setMaterialConsumo($materialConsumo);
                $this->bdToForm();
            }
        }
        return $lista;
    }

    private function decode() {
        $this->materialConsumo->setNome($this->utf8Decode($this->materialConsumo->getNome()));
        $this->materialConsumo->setDescricao($this->utf8Decode($this->materialConsumo->getDescricao()));
        $this->materialConsumo->setMarca($this->utf8Decode($this->materialConsumo->getMarca()));
        $this->materialConsumo->setModelo($this->utf8Decode($this->materialConsumo->getModelo()));
    }

    private function encode() {
        $this->materialConsumo->setNome($this->utf8Encode($this->materialConsumo->getNome()));
        $this->materialConsumo->setDescricao($this->utf8Encode($this->materialConsumo->getDescricao()));
        $this->materialConsumo->setMarca($this->utf8Encode($this->materialConsumo->getMarca()));
        $this->materialConsumo->setModelo($this->utf8Encode($this->materialConsumo->getModelo()));
    }

    private function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    private function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    function setAtributos($atributos) {
        $this->setAtributosItem($this->materialConsumo, $atributos);


        $this->materialConsumo->setMarca($atributos->marca);
        $this->materialConsumo->setModelo($atributos->modelo);
        $this->materialConsumo->setPartNumber($atributos->partNumber);
        $this->materialConsumo->setCodigoSinap($atributos->codigoSinap);

        if ($atributos->apresentacaoComercialId) {
            $this->materialConsumo->setApresentacaoComercialId($atributos->apresentacaoComercialId);
        } else {
            $this->materialConsumo->setApresentacaoComercialId("NULL");
        }

        if ($atributos->controlado) {
            $this->materialConsumo->setControlado(1);
            $this->materialConsumo->setOrgaoControladorId($atributos->orgaoControladorId);
            $this->materialConsumo->setItemControladoId($atributos->itemControladoId);
        } else {
            $this->materialConsumo->setControlado(0);
            $this->materialConsumo->setOrgaoControladorId("NULL");
            $this->materialConsumo->setItemControladoId("NULL");
        }
        if (count($atributos->centroDeCustosId) > 0) {
            foreach ($atributos->centroDeCustosId as $centroDeCustosId) {
                $centroDeCusto = new CentroDeCusto();
                $centroDeCusto->setId($centroDeCustosId);
                $this->materialConsumo->adicionarCentroDeCusto($centroDeCusto);
            }
        }
    }

    function getMaterialConsumo() {
        return $this->materialConsumo;
    }

    function setMaterialConsumo($materialConsumo) {
        $this->materialConsumo = $materialConsumo;
    }

}
