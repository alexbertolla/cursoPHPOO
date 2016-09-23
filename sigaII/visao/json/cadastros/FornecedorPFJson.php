<?php

namespace visao\json\cadastros;

use modelo\cadastros\FornecedorPessoaFisica,
    visao\json\cadastros\EmailFornecedorJson,
    visao\json\cadastros\TelefoneJson,
    visao\json\cadastros\DadosBancarioJson,
    visao\json\RetornoJson,
    ArrayObject;

class FornecedorPFJson extends RetornoJson {

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
        return ($fornecedor instanceof FornecedorPessoaFisica) ?
                array(
            "id" => $fornecedor->getId(),
            "nome" => $fornecedor->getNome(),
            "site" => $fornecedor->getSite(),
            "documento" => $fornecedor->getCpf(),
            "pis" => $fornecedor->getPis(),
            "rg" => $fornecedor->getRg(),
            "orgaoExpeditor" => $fornecedor->getOrgaoExpeditor(),
            "dataExpedicao" => $fornecedor->getDataExpedicao(),
            "situacao" => $fornecedor->getSituacao(),
            "tipo" => $fornecedor->getTipo(),
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
