<?php

namespace visao\json\cadastros;

use modelo\cadastros\Banco,
    visao\json\RetornoJson,
    ArrayObject;

class BancoJson extends RetornoJson {

    function retornoJson($banco) {
        return ($banco instanceof Banco) ?
                array("id" => $banco->getId(), "codigo" => $banco->getCodigo(), "nome" => $banco->getNome(), "situacao" => $banco->getSituacao()) :
                NULL;
    }

    function retornoListaJsnon($listaBancos) {
        if ($listaBancos instanceof ArrayObject) {
            $arrBanco = new ArrayObject();
            foreach ($listaBancos as $banco) {
                $arrBanco->append($this->retornoJson($banco));
            }
            return $arrBanco->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
