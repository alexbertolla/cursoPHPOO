<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\cadastros;

use visao\json\cadastros\FornecedorPFJson,
    visao\json\cadastros\FornecedorPJJson;

/**
 * Description of FornecedorJson
 *
 * @author alex.bertolla
 */
class FornecedorJson {

    private $fornecedorJson;

    public function __construct($tipoFornecedor) {
        $this->fornecedorJson = ($tipoFornecedor === "pj") ? new FornecedorPJJson() : new FornecedorPFJson();
    }

    function retornoJson($fornecedor) {
        return $this->fornecedorJson->retornoJson($fornecedor);
    }

}
