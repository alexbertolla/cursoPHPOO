<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\almoxarifado;

use visao\json\RetornoJson,
    modelo\almoxarifado\RequisicaoMaterial,
    visao\json\FuncionarioJson,
    visao\json\LotacaoJson,
    visao\json\PAJson,
    visao\json\almoxarifado\ItemRequisicaoJson,
    visao\json\almoxarifado\SituacaoRequisicaoJson,
    ArrayObject;

/**
 * Description of RequisicaoMaterialJson
 *
 * @author alex.bertolla
 */
class RequisicaoMaterialJson extends RetornoJson {

    function retornoJson($requisicaoMaterial) {
        if ($requisicaoMaterial instanceof RequisicaoMaterial) {
            $funcionarioJson = new FuncionarioJson();
            $lotacaoJson = new LotacaoJson();
            $paJson = new PAJson();
            $itemRequisicaoJson = new ItemRequisicaoJson();
            $situacaoRequisicaoJson = new SituacaoRequisicaoJson();
            return array(
                "id" => $requisicaoMaterial->getId(),
                "numero" => $requisicaoMaterial->getNumero(),
                "matriculaRequisitante" => $requisicaoMaterial->getMatriculaRequisitante(),
                "requisitante" => $funcionarioJson->retornoJson($requisicaoMaterial->getRequisitante()),
                "matriculaResponsavel" => $requisicaoMaterial->getMatriculaResponsavel(),
                "responsavel" => $funcionarioJson->retornoJson($requisicaoMaterial->getResponsavel()),
                "dataRequisicao" => $requisicaoMaterial->getDataRequisicao(),
                "dataAtendimento" => $requisicaoMaterial->getDataAtendimento(),
                "paId" => $requisicaoMaterial->getPaId(),
                "pa" => $paJson->retornoJson($requisicaoMaterial->getPa()),
                "lotacaoId" => $requisicaoMaterial->getLotacaoId(),
                "lotacao" => $lotacaoJson->retornoJson($requisicaoMaterial->getLotacao()),
                "situacaoId" => $requisicaoMaterial->getSituacaoId(),
                "situacao" => $situacaoRequisicaoJson->retornoJson($requisicaoMaterial->getSituacao()),
                "valor" => $requisicaoMaterial->getValor(),
                "ano" => $requisicaoMaterial->getAno(),
                "enviada" => $requisicaoMaterial->getEnviada(),
                "atendida" => $requisicaoMaterial->getAtendida(),
                "listaItemRequisicao" => $itemRequisicaoJson->retornoListaJson($requisicaoMaterial->getListaItemRequisicao())
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaRequisicaoMaterial) {
        if ($listaRequisicaoMaterial instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaRequisicaoMaterial as $requisicaoMaterial) {
                $novoArray->append($this->retornoJson($requisicaoMaterial));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
