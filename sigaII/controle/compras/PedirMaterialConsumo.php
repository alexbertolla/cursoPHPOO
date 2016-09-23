<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use controle\compras\InterfaceItemPedido,
    controle\cadastros\ManterMaterialConsumo;

/**
 * Description of PedirMaterialConsumo
 *
 * @author alex.bertolla
 */
class PedirMaterialConsumo implements InterfaceItemPedido {

    private $manterMaterialConsumo;

    public function __construct() {
        $this->manterMaterialConsumo = new ManterMaterialConsumo();
    }

    public function __destruct() {
        unset($this->manterMaterialConsumo);
    }

    public function buscarItemPorId($id) {
        return $this->manterMaterialConsumo->buscarPorId($id);
    }

}
