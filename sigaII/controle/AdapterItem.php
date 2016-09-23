<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle;

use controle\cadastros\ManterMaterialConsumo,
    controle\cadastros\ManterMaterialPermanente,
    controle\cadastros\ManterObra,
    controle\cadastros\ManterServico;

/**
 * Description of AdapterItem
 *
 * @author alex.bertolla
 */
class AdapterItem {

    private $tipoItem;
    private $manterItem;

    public function __construct($tipoItem) {
        $this->tipoItem = $tipoItem;
        $this->setManterItem();
    }

    private function setManterItem() {
        switch ($this->tipoItem) {
            case "materialConsumo":
                $this->manterItem = new ManterMaterialConsumo();
                break;
            case "materialPermanente":
                $this->manterItem = new ManterMaterialPermanente();
                break;
            case "obra":
                $this->manterItem = new ManterObra();
                break;
            case "servico":
                $this->manterItem = new ManterServico();
                break;
        }
    }

    function bucarPorId($id) {
        return $this->manterItem->buscarPorId($id);
    }

}
