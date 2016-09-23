<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DadosBancarioJson
 *
 * @author alex.bertolla
 */

namespace visao\json\cadastros;

use modelo\cadastros\DadosBancario,
    visao\json\cadastros\BancoJson,
    visao\json\RetornoJson,
    ArrayObject;

class DadosBancarioJson extends RetornoJson {

    function retornoJson($dadosBancario) {
        $bancoJson = new BancoJson();
        return ($dadosBancario instanceof DadosBancario) ?
                array("id" => $dadosBancario->getId(),
            "bancoId" => $dadosBancario->getBancoId(),
            "fornecedorId" => $dadosBancario->getFornecedorId(),
            "agencia" => $dadosBancario->getAgencia(),
            "conta" => $dadosBancario->getConta(),
            "situacao" => $dadosBancario->getSituacao(),
            "Banco" => $bancoJson->retornoJson($dadosBancario->getBanco())
                ) : NULL;
    }

    function retornoListaJson($listaDadosBancario) {
        if ($listaDadosBancario instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaDadosBancario as $dadosBancario) {
                $novoArray->append($this->retornoJson($dadosBancario));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
