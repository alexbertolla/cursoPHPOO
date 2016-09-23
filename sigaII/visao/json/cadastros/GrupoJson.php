<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GrupoJson
 *
 * @author alex.bertolla
 */

namespace visao\json\cadastros;

use modelo\cadastros\Grupo,
    modelo\cadastros\NaturezaDespesa,
    modelo\cadastros\ContaContabil,
    visao\json\cadastros\NaturezaDespesaJson,
    visao\json\cadastros\ContaContabilJson,
    visao\json\RetornoJson,
    ArrayObject;

class GrupoJson extends RetornoJson {

    function retornoJson($grupo) {
        if ($grupo instanceof Grupo) {
            $ndJson = new NaturezaDespesaJson();
            $ccJson = new ContaContabilJson();
            return array(
                "id" => $grupo->getId(),
                "codigo" => $grupo->getCodigo(),
                "nome" => $grupo->getNome(),
                "descricao" => $grupo->getDescricao(),
                "situacao" => $grupo->getSituacao(),
                "naturezaDespesaId" => $grupo->getNaturezaDespesaId(),
                "contaContabilId" => $grupo->getContaContabilId(),
                "naturezaDespesa" => $ndJson->retornoJson($grupo->getNaturezaDespesa()),
                "contaContabil" => $ccJson->retornoJson($grupo->getContaContabil()),
                "tipo" => $grupo->getTipo()
            );
        } else {
            return NULL;
        }
    }

    function retornoListaJson($listaGrupo) {
        if ($listaGrupo instanceof ArrayObject) {
            $arrayNovo = new ArrayObject();
            foreach ($listaGrupo as $grupo) {
                $arrayNovo->append($this->retornoJson($grupo));
            }
            return $arrayNovo->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
