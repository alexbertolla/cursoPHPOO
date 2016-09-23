<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WSsgp
 *
 * @author alex.bertolla
 */

namespace webservices;

use SoapClient,
    sgp\Funcionario,
    sgp\Lotacao,
    ArrayObject;

class WSsgp {

    private $wsCliente;

    public function __construct() {
        $host = $_SERVER["HTTP_HOST"];
        $this->wsCliente = new SoapClient(null, array(
            "location" => "http://intranet.cnpat.embrapa.br/aplicacoes/sistemas/sgp/wsFuncionario.php",
            "uri" => "http://intranet.cnpat.embrapa.br/aplicacoes/sistemas/sgp/",
            "trace" => 1,
//            "encoding" => "ISO-8859-2"
            "encoding" => "UTF8"
        ));
    }

    public function __destruct() {
        unset($this->wsCliente);
    }

    private function setDadosFuncionario($dadosFuncionario) {
        $funcionario = new Funcionario();
        $funcionario->setEmail($dadosFuncionario->email);
        $funcionario->setLotacao($this->buscarLotacaoPorId($dadosFuncionario->lotacao_id));
        $funcionario->setMatricula($dadosFuncionario->matrica);
        $funcionario->setNome($dadosFuncionario->nomefunc);
        return $funcionario;
    }

    private function setDadosLotacao($dadosLotacao) {
        $lotacao = new Lotacao();
        $lotacao->setId($dadosLotacao->lot_id);
        $lotacao->setNome($dadosLotacao->lot_nome);
        $lotacao->setSigla($dadosLotacao->lot_sigla);
        return $lotacao;
    }

    function listarFuncionarioEfetivo() {
        $listaDadosFuncionarios = $this->wsCliente->listarFuncionarioEfetivo();
        $arrFuncionario = new ArrayObject();
        foreach ($listaDadosFuncionarios as $dadosFuncionario) {
            $arrFuncionario->append($this->setDadosFuncionario($dadosFuncionario));
        }
        return $arrFuncionario;
    }

    function buscarFuncionarioEfetivoPorMatricula($matricula) {
        $dadosFuncionario = $this->wsCliente->buscarFuncionarioEfetivoPorMatricula($matricula);
        return $this->setDadosFuncionario($dadosFuncionario);
    }

    function listarFuncionarioEfetivoPorNome($nome) {
        $listaDadosFuncionarios = $this->wsCliente->listarFuncionarioEfetivoPorNome($nome);
        $arrFuncionario = new ArrayObject();
        foreach ($listaDadosFuncionarios as $dadosFuncionario) {
            $arrFuncionario->append($this->setDadosFuncionario($dadosFuncionario));
        }
        return $arrFuncionario;
    }

    function listarLotacoes() {
        $listaDadosLotacao = $this->wsCliente->listarLotacoes();
        $arrLotacao = new ArrayObject();
        foreach ($listaDadosLotacao as $dadosLotacao) {
            $arrLotacao->append($this->setDadosLotacao($dadosLotacao));
        }
        return $arrLotacao;
    }

    function buscarLotacaoPorId($id) {
        $dadosLotacao = $this->wsCliente->buscarLotacaoPorId($id);
        return $this->setDadosLotacao($dadosLotacao);
    }

}
