<?php

namespace visao\json\almoxarifado;

use visao\json\RetornoJson,
    modelo\almoxarifado\NotaFiscal;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotaFiscalJson
 *
 * @author alex.bertolla
 */
class NotaFiscalJson extends RetornoJson {

    function retornoJson($notaFiscal) {
        if ($notaFiscal instanceof NotaFiscal) {
            return array(
                "id" => $notaFiscal->getId(),
                "numero" => $notaFiscal->getNumero(),
                "chaveAcesso" => $notaFiscal->getChaveAcesso(),
                "entradaId" => $notaFiscal->getEntradaId(),
                "fornecedorId" => $notaFiscal->getFornecedorId()
            );
        } else {
            return NULL;
        }
    }

}
