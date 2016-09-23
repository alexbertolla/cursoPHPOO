<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdapterFornecedor
 *
 * @author alex.bertolla
 */

namespace controle;

use controle\cadastros\ManterFornecedor,
    controle\cadastros\ManterFornecedorPessoaFisica,
    controle\cadastros\ManterFornecedorPessoaJuridica;

class AdapterFornecedor {

    private $tipoFornecedor;
    private $manterFornecedor;

    public function __construct($tipoFornecedor) {
        $this->tipoFornecedor = $tipoFornecedor;
        $this->setManterFornecedor();
    }

    private function setManterFornecedor() {
        switch ($this->tipoFornecedor) {
            case "pj":
                $this->manterFornecedor = new ManterFornecedorPessoaJuridica();
                break;
            case "pf":
                $this->manterFornecedor = new ManterFornecedorPessoaFisica();
                break;
            default :
                $this->manterFornecedor = new ManterFornecedor();
        }
    }

    function buscarPorId($id) {
        return $this->manterFornecedor->buscarPorId($id);
    }

    function listarPorProcessoCompra($processoCompraId) {
        return $this->manterFornecedor->listarPorProcessoCompra($processoCompraId);
    }

    function setDadosFornecedor($fornecedor) {
        $this->manterFornecedor->SetDadosFornecedor($fornecedor);
    }

}
