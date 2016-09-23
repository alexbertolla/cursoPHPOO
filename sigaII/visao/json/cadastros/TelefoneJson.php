<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Telefonejson
 *
 * @author alex.bertolla
 */

namespace visao\json\cadastros;

use modelo\cadastros\Telefone,
    visao\json\RetornoJson,
    ArrayObject;

class TelefoneJson extends RetornoJson {

    function retornoJson($telefone) {
        return ($telefone instanceof Telefone) ?
                array(
            "id" => $telefone->getId(),
            "ddi" => $telefone->getDdi(),
            "ddd" => $telefone->getDdd(),
            "numero" => $telefone->getNumero(),
            "fornecedorId" => $telefone->getFornecedorId()
                ) : NULL;
    }

    function retornoListaJson($listaTelefones) {
        if ($listaTelefones instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaTelefones as $telefone) {
                $novoArray->append($this->retornoJson($telefone));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
