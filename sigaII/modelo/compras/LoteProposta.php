<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\compras;

use ArrayObject,
    modelo\compras\ItemProposta;

/**
 * Description of LoteProposta
 *
 * @author alex.bertolla
 */
class LoteProposta {

    private $listaItemProposta;
    private $valorTotalLote;

    public function __construct() {
        $this->listaItemProposta = new ArrayObject();
    }

    function addItemNoLote(ItemProposta $itemProposta) {
        $this->listaItemProposta->append($itemProposta);
    }

    function getListaItemProposta() {
        return $this->listaItemProposta;
    }

    function getValorTotalLote() {
        return $this->valorTotalLote;
    }

    function setListaItemProposta($listaItemProposta) {
        $this->listaItemProposta = $listaItemProposta;
    }

    function setValorTotalLote($valorTotalLote) {
        $this->valorTotalLote = $valorTotalLote;
    }

    public function __destruct() {
        unset($this->listaItemProposta);
    }

}
