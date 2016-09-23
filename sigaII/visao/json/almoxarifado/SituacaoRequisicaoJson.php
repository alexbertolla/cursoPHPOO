<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\almoxarifado;

use visao\json\RetornoJson,
    modelo\almoxarifado\SituacaoRequisicao,
    ArrayObject;

/**
 * Description of SituacaoRequisicaoJson
 *
 * @author alex.bertolla
 */
class SituacaoRequisicaoJson extends RetornoJson {

    function retornoJson($situacaoRequisicao) {
        if ($situacaoRequisicao instanceof SituacaoRequisicao) {
            return array(
                "id" => $situacaoRequisicao->getId(),
                "codigo" => $situacaoRequisicao->getCodigo(),
                "situacao" => $situacaoRequisicao->getSituacao(),
                "mensagem" => $situacaoRequisicao->getMensagem()
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaSituacaoRequisicao) {
        if ($listaSituacaoRequisicao instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaSituacaoRequisicao as $situacaoRequisicao) {
                $novoArray->append($situacaoRequisicao);
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
