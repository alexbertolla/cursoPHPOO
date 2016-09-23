<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use controle\compras\InterfaceItemPedido,
    controle\cadastros\ManterObra;

/**
 * Description of PedirObra
 *
 * @author alex.bertolla
 */
class PedirObra implements InterfaceItemPedido {

    private $manterObra;

    public function __construct() {
        $this->manterObra = new ManterObra();
    }

    public function __destruct() {
        unset($this->manterObra);
    }

    public function buscarItemPorId($id) {
        return $this->manterObra->buscarPorId($id);
    }

}
