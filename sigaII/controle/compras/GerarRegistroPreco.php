<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use modelo\compras\impressao\RegistroOrcamentario,
        controle\compras\ManterItemProposta;

/**
 * Description of GerarRegistroPreco
 *
 * @author alex.bertolla
 */
class GerarRegistroPreco {

    private $registroOrcamentario;

    public function __construct() {
        $this->registroOrcamentario = new RegistroOrcamentario();
    }
    
    function listarItens($processoCompraId){
        $manterItemProposta = new ManterItemProposta();
        $listaItens = $manterItemProposta->listarVencedoresPorProcessoCompra($processoCompraId);
    }

}
