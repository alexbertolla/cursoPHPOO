<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ObraJson
 *
 * @author alex.bertolla
 */

namespace visao\json\cadastros;

use modelo\cadastros\Obra,
    visao\json\RetornoJson,
    visao\json\cadastros\GrupoJson,
    visao\json\cadastros\AlmoxarifadoVirtualJson,
    visao\json\FuncionarioJson,
    visao\json\LotacaoJson,
    ArrayObject;

class ObraJson extends RetornoJson {

    function retornoJson($obra) {
        if ($obra instanceof Obra) {
            $grupoJson = new GrupoJson();
            $avJson = new AlmoxarifadoVirtualJson();
            $funcJson = new FuncionarioJson();
            $lotJson = new LotacaoJson();
            return array(
                "id" => $obra->getId(),
                "codigo" => $obra->getCodigo(),
                "nome" => $obra->getNome(),
                "descricao" => $obra->getDescricao(),
                "situacao" => $obra->getSituacao(),
                "dataCadastro" => $obra->getDataCadastro(),
                "dataAtualizacao" => $obra->getDataAtualizacao(),
                "sustentavel" => $obra->getSustentavel(),
                "grupoId" => $obra->getGrupoId(),
                "grupo" => $grupoJson->retornoJson($obra->getGrupo()),
                "almoxarifadoVirtualId" => $obra->getAlmoxarifadoVirtualId(),
                "almoxarifadoVirtual" => $avJson->retornoJson($obra->getAlmoxarifadoVirtual()),
                "local" => $obra->getLocal(),
                "bemPrincipal" => $obra->getBemPrincipal(),
                "bemPrincipalClass" => $lotJson->retornoJson($obra->getBemPrincipalClass()),
                "responsavel" => $obra->getResponsavel(),
                "responsavelClass" => $funcJson->retornoJson($obra->getResponsavelClass()),
                "naturezaDespesaId"=>$obra->getNaturezaDespesaId()
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaObra) {
        if ($listaObra instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaObra as $obra) {
                $novoArray->append($this->retornoJson($obra));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
