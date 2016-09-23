<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NaturezaDespesaJson
 *
 * @author alex.bertolla
 */

namespace visao\json\cadastros;

use modelo\cadastros\ContaContabil,
    visao\json\RetornoJson,
    ArrayObject;

class ContaContabilJson extends RetornoJson {

    function retornoJson($contaContabil) {
        return ($contaContabil instanceof ContaContabil) ?
                array(
            "id" => $contaContabil->getId(),
            "codigo" => $contaContabil->getCodigo(),
            "nome" => $contaContabil->getNome(),
            "situacao" => $contaContabil->getSituacao()) :
                NULL;
    }

    function retornoListaJson($listaContaContabil) {
        if ($listaContaContabil instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaContaContabil as $contaContabil) {
                $novoArray->append($this->retornoJson($contaContabil));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
