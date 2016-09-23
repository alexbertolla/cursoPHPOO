<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MapaComparativoPreco
 *
 * @author alex.bertolla
 */

namespace modelo\compras\impressao;

use ArrayObject,
    modelo\compras\ProcessoCompra,
    modelo\compras\ItemProposta;

class MapaComparativoPreco {

    private $processoCompra;
    private $listaItemProposta;

    public function __construct() {
        $this->processoCompra = new ProcessoCompra();
        $this->listaItemProposta = new ArrayObject();
    }

    function adicionarItemPropostaNoMapa(ItemProposta $itemProposta) {
        $this->listaItemProposta->append($itemProposta);
    }

    function getProcessoCompra() {
        return $this->processoCompra;
    }

    function setProcessoCompra($processoCompra) {
        $this->processoCompra = $processoCompra;
    }

    function getListaItemProposta() {
        return $this->listaItemProposta;
    }

    function setListaItemProposta($listaItensPropostas) {
        $this->listaItemProposta = $listaItensPropostas;
    }

}
