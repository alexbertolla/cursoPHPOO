<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace visao\json\configuracao;

use configuracao\DadosUnidade,
    configuracao\EnderecoUnidade,
    visao\json\RetornoJson;

/**
 * Description of DadosUnidadeJson
 *
 * @author alex.bertolla
 */
class DadosUnidadeJson extends RetornoJson {

    function retornoJson(DadosUnidade $dadosUnidade) {
        return array(
            "nome" => $dadosUnidade->getNome(),
            "sigla" => $dadosUnidade->getSigla(),
            "cnpj" => $dadosUnidade->getCnpj(),
            "inscricaoEstadual" => $dadosUnidade->getInscricaoEstadual(),
            "inscricaoMunicipal" => $dadosUnidade->getInscricaoMunicipal(),
            "codigoSiged" => $dadosUnidade->getCodigoSiged(),
            "codigoUasg" => $dadosUnidade->getCodigoUasg(),
            "telefone" => $dadosUnidade->getTelefone(),
            "chefeGeral" => $dadosUnidade->getChefeGeral(),
            "chefeAdministrativo" => $dadosUnidade->getChefeAdministrativo(),
            "endereco" => $this->retornoEnderecoUnidadeJson($dadosUnidade->getEndereco())
        );
    }

    private function retornoEnderecoUnidadeJson(EnderecoUnidade $enderecoUnidade) {
        return array(
            "logradouro" => $enderecoUnidade->getLogradouro(),
            "numero" => $enderecoUnidade->getNumero(),
            "complemento" => $enderecoUnidade->getComplemento(),
            "bairro" => $enderecoUnidade->getBairro(),
            "cidade" => $enderecoUnidade->getCidade(),
            "estado" => $enderecoUnidade->getEstado(),
            "cep" => $enderecoUnidade->getCep()
        );
    }

}
