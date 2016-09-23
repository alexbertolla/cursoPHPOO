<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\compras;

use visao\json\RetornoJson,
    modelo\compras\ItemProposta,
    modelo\cadastros\MaterialConsumo,
    modelo\cadastros\MaterialPermanente,
    modelo\cadastros\Obra,
    modelo\cadastros\Servico,
    visao\json\cadastros\MaterialConsumoJson,
    visao\json\cadastros\MaterialPermanenteJson,
    visao\json\cadastros\ObraJson,
    visao\json\cadastros\ServicoJson,
    visao\json\cadastros\FornecedorPFJson,
    visao\json\cadastros\FornecedorPJJson,
    ArrayObject;

/**
 * Description of ItemPropostaJson
 *
 * @author alex.bertolla
 */
class ItemPropostaJson extends RetornoJson {

    private function setTipoItem($item) {
        if ($item instanceof MaterialConsumo) {
            return new MaterialConsumoJson();
        } elseif ($item instanceof MaterialPermanente) {
            return new MaterialPermanenteJson();
        } elseif ($item instanceof Obra) {
            return new ObraJson();
        } else {
            return new ServicoJson();
        }
    }

    private function setTipoFornecedor($tipoFornecedor) {
        return ($tipoFornecedor === "pj") ? new FornecedorPJJson() : new FornecedorPFJson();
    }

    function retornoJson($itemProposta) {
        if ($itemProposta && ($itemProposta instanceof ItemProposta)) {
            $itemJson = $this->setTipoItem($itemProposta->getItem());
            $fornecedorJson = $this->setTipoFornecedor($itemProposta->getTipoFornecedor());
            return array(
                "propostaId" => $itemProposta->getPropostaId(),
                "fornecedorId" => $itemProposta->getFornecedorId(),
                "tipoFornecedor" => $itemProposta->getTipoFornecedor(),
                "fornecedor" => $fornecedorJson->retornoJson($itemProposta->getFornecedor()),
                "processoCompraId" => $itemProposta->getProcessoCompraId(),
                "modalidadeId" => $itemProposta->getModalidadeId(),
                "pedidoId" => $itemProposta->getPedidoId(),
                "grupoId" => $itemProposta->getGrupoId(),
                "naturezaDespesaId" => $itemProposta->getNaturezaDespesaId(),
                "itemId" => $itemProposta->getItemId(),
                "item" => $itemJson->retornoJson($itemProposta->getItem()),
                "quantidade" => $itemProposta->getQuantidade(),
                "valorUnitario" => $itemProposta->getValorUnitario(),
                "valorTotal" => $itemProposta->getValorTotal()
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaItemProposta) {
        if ($listaItemProposta instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaItemProposta as $itemProposta) {
                $novoArray->append($this->retornoJson($itemProposta));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
