<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EnderecoJson
 *
 * @author alex.bertolla
 */

namespace visao\json\cadastros;

use modelo\cadastros\Endereco,
    visao\json\RetornoJson,
    ArrayObject;

class EnderecoJson extends RetornoJson {

    function retornoJson($endereco) {

        return ($endereco instanceof Endereco) ? array(
            "id" => $endereco->getId(),
            "logradouro" => $endereco->getLogradouro(),
            "numero" => $endereco->getNumero(),
            "complemento" => $endereco->getComplemento(),
            "bairro" => $endereco->getBairro(),
            "cidade" => $endereco->getCidade(),
            "estado" => $endereco->getEstado(),
            "cep" => $endereco->getCep(),
            "pais" => $endereco->getPais(),
            "fornecedorId" => $endereco->getFornecedorId()
                ) : NULL;
    }

}
