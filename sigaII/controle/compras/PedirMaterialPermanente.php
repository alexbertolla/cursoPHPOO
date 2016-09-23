<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use controle\compras\InterfaceItemPedido,
    controle\cadastros\ManterMaterialPermanente;

/**
 * Description of PedirMaterialPermanente
 *
 * @author alex.bertolla
 */
class PedirMaterialPermanente implements InterfaceItemPedido {

    private $manterMaterialPermanente;

    public function __construct() {
        $this->manterMaterialPermanente = new ManterMaterialPermanente();
    }

    public function __destruct() {
        unset($this->manterMaterialPermanente);
    }

    public function buscarItemPorId($id) {
        return $this->manterMaterialPermanente->buscarPorId($id);
    }

}
