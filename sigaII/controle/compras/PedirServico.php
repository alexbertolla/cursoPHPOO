<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\compras;

use controle\compras\InterfaceItemPedido,
    controle\cadastros\ManterServico;

/**
 * Description of PedirServico
 *
 * @author alex.bertolla
 */
class PedirServico implements InterfaceItemPedido {

    private $manterServico;

    public function __construct() {
        $this->manterServico = new ManterServico();
    }

    public function __destruct() {
        unset($this->manterServico);
    }

    public function buscarItemPorId($id) {
        return $this->manterServico->buscarPorId($id);
    }

}
