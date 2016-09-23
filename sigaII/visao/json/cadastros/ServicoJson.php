<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ServicoJson
 *
 * @author alex.bertolla
 */

namespace visao\json\cadastros;

use modelo\cadastros\Servico,
    visao\json\RetornoJson,
    visao\json\cadastros\GrupoJson,
    visao\json\cadastros\AlmoxarifadoVirtualJson,
    ArrayObject;

class ServicoJson extends RetornoJson {

    function retornoJson($servico) {
        if ($servico instanceof Servico) {
            $grupoJson = new GrupoJson();
            $avJson = new AlmoxarifadoVirtualJson();
            return array(
                "id" => $servico->getId(),
                "codigo" => $servico->getCodigo(),
                "nome" => $servico->getNome(),
                "descricao" => $servico->getDescricao(),
                "situacao" => $servico->getSituacao(),
                "dataCadastro" => $servico->getDataCadastro(),
                "dataAlteracao" => $servico->getDataAtualizacao(),
                "sustentavel" => $servico->getSustentavel(),
                "tipo" => $servico->getTipo(),
                "grupoId" => $servico->getGrupoId(),
                "grupo" => $grupoJson->retornoJson($servico->getGrupo()),
                "almoxarifadoVirtualId" => $servico->getAlmoxarifadoVirtualId(),
                "almoxarifadoVirtual" => $avJson->retornoJson($servico->getAlmoxarifadoVirtual()),
                "naturezaDespesaId"=>$servico->getNaturezaDespesaId()
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaServico) {
        if ($listaServico instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaServico as $servico) {
                $novoArray->append($this->retornoJson($servico));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
