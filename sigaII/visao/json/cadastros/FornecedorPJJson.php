<?php

namespace visao\json\cadastros;

use modelo\cadastros\FornecedorPessoaJuridica,
    visao\json\cadastros\FornecedorPJJson,
    visao\json\cadastros\EmailFornecedorJson,
    visao\json\cadastros\TelefoneJson,
    visao\json\cadastros\DadosBancarioJson,
    visao\json\RetornoJson,
    ArrayObject;

class FornecedorPJJson extends RetornoJson {

    private $enderecoJSON;
    private $telefoneJSON;
    private $emailJSON;
    private $dadosBancariosJSON;

    public function __construct() {
        $this->enderecoJSON = new EnderecoJson();
        $this->telefoneJSON = new TelefoneJson();
        $this->emailJSON = new EmailFornecedorJson();
        $this->dadosBancariosJSON = new DadosBancarioJson();
    }

    function retornoJson($fornecedor) {
        return ($fornecedor instanceof FornecedorPessoaJuridica) ?
                array(
            "id" => $fornecedor->getId(),
            "documento" => $fornecedor->getCnpj(),
            "nome" => $fornecedor->getNome(),
            "nomeFantasia" => $fornecedor->getNomeFantasia(),
            "site" => $fornecedor->getSite(),
            "situacao" => $fornecedor->getSituacao(),
            "tipo" => $fornecedor->getTipo(),
            "microEmpresa" => $fornecedor->getMicroEmpresa(),
            "endereco" => $this->enderecoJSON->retornoJson($fornecedor->getEndereco()),
            "telefone" => $this->telefoneJSON->retornoListaJson($fornecedor->getTelefone()),
            "email" => $this->emailJSON->retornoListaJson($fornecedor->getEmail()),
            "dadosBancarios" => $this->dadosBancariosJSON->retornoListaJson($fornecedor->getDadosBancarios())
                ) :
                NULL;
    }

    function retornoListaJson($listaFornecedor) {
        if ($listaFornecedor instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaFornecedor as $fornecedor) {
                $novoArray->append($this->retornoJson($fornecedor));
            }
            return $novoArray->getArrayCopy();
        }
    }

    public function __destruct() {
        unset($this->dadosBancariosJSON, $this->emailJSON, $this->enderecoJSON, $this->telefoneJSON);
    }

}
