<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\compras;

use visao\json\RetornoJson,
    modelo\compras\ProcessoCompra,
    visao\json\cadastros\ModalidadeJson,
    visao\json\FuncionarioJson,
    visao\json\compras\LoteProcessoCompraJson,
    visao\json\compras\SituacaoProcessoCompraJson,
    ArrayObject;

/**
 * Description of ProcessoCompraJson
 *
 * @author alex.bertolla
 */
class ProcessoCompraJson extends RetornoJson {

    function retornoJson($processoCompra) {
        if ($processoCompra instanceof ProcessoCompra) {
            $modalidadeJson = new ModalidadeJson();
            $responsavelJson = new FuncionarioJson();
            $listaLoteProcessoCompra = new LoteProcessoCompraJson();
            $situacaoJson = new SituacaoProcessoCompraJson();
            return array(
                "id" => $processoCompra->getId(),
                "numero" => $processoCompra->getNumero(),
                "modalidadeId" => $processoCompra->getModalidadeId(),
                "numeroModalidade" => $processoCompra->getNumeroModalidade(),
                "modalidade" => $modalidadeJson->retornoJson($processoCompra->getModalidade()),
                "objeto" => $processoCompra->getObjeto(),
                "justificativa" => $processoCompra->getJustificativa(),
                "dataAbertura" => $processoCompra->getDataAbertura(),
                "dataEncerramento" => $processoCompra->getDataEncerramento(),
                "responsavel" => $processoCompra->getResponsavel(),
                "responsavelClass" => $responsavelJson->retornoJson($processoCompra->getResponsavelClass()),
                "consolidado" => $processoCompra->getConsolidado(),
                "bloqueado" => $processoCompra->getBloqueado(),
                "encerrado" => $processoCompra->getEncerrado(),
                "listaLoteProcessoCompra" => $listaLoteProcessoCompra->retornoListaJson($processoCompra->getListaLoteProcessoCompra()),
                "situacaoId" => $processoCompra->getSituacaoId(),
                "situacao" => $situacaoJson->retornoJson($processoCompra->getSituacao())
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaProcessoCompra) {
        if ($listaProcessoCompra instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaProcessoCompra as $processoCompra) {
                $novoArray->append($this->retornoJson($processoCompra));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULLs;
        }
    }

}
