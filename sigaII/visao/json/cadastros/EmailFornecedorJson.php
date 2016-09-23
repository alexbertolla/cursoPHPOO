<?php

namespace visao\json\cadastros;

use modelo\cadastros\EmailFornecedor,
    visao\json\RetornoJson,
    ArrayObject;

class EmailFornecedorJson extends RetornoJson {

    function retornoJson($email) {
        return ($email instanceof EmailFornecedor) ?
                array("id" => $email->getId(), "email" => $email->getEmail(), "fornecedorId" => $email->getFornecedorId()) :
                NULL;
    }

    function retornoListaJson($listaEmails) {
        if ($listaEmails instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaEmails as $email) {
                $novoArray->append($this->retornoJson($email));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
