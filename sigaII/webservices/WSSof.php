<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace webservices;

use SoapClient,
    sof\PA,
    ArrayObject;

/**
 * Description of WSSof
 *
 * @author alex.bertolla
 */
class WSSof {

    private $wsCliente;

    public function __construct() {
//        include_once '../autoload.php';
        $this->wsCliente = new SoapClient(NULL, array(
            "location" => "http://backup.cnpat.embrapa.br/aplicacoes/sistemas/webservices/wsSOF.php",
            "uri" => "http://backup.cnpat.embrapa.br/aplicacoes/sistemas/webservices/",
            "trace" => 1,
            "encoding" => "UTF-8"
        ));
    }

//    function buscarSaldoPa($ano, $codigoPA) {;
//        $dadosSaldoPA = $this->wsCliente->buscarValoresPA($ano, $codigoPA);
//        return $this->setInfoPA($dadosSaldoPA);
//    }

    function listarPA($ano, $parametro = '%') {
        $listaPA = $this->wsCliente->listarPA($ano, $parametro);
        return $this->setInfoListaPA($listaPA->BOGUS);
//        return $this->setInfoListaPA($lista = $this->wsCliente->listarPA()->BOGUS);
    }

    function buscarPaPorId($id) {
        $pa = $this->wsCliente->buscarPaPorId($id);
        return $this->setInfoPA($pa);
    }
    
    function buscarPaSaldoPorId($id, $ano) {
        $pa = $this->wsCliente->buscarPaSaldoPorId($id, $ano);
        return $this->setInfoPA($pa);
    }
    
    private function setInfoListaPA($listaPA) {
        $novaLista = new ArrayObject();
        foreach ($listaPA as $pa) {
            $novaLista->append($this->setInfoPA($pa));
        }
        return $novaLista;
    }

    private function setInfoPA($dadosSaldoPA) {
        $pa = new PA();
        $pa->setId($dadosSaldoPA->id);
        $pa->setCodigo($dadosSaldoPA->codigo);
        $pa->setTitulo($dadosSaldoPA->titulo);
        $pa->setResponsavel($dadosSaldoPA->responsavel);
        $pa->setSaldoCusteio($dadosSaldoPA->saldoRealCusteio);
        $pa->setSaldoInvestimento($dadosSaldoPA->saldoRealInvestimento);
        return $pa;
    }

}

//$ws = new WSSof();
//$retorno = $ws->listarPA('2015', '16');
//
//print_r($retorno);
