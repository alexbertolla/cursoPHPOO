<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Item
 *
 * @author alex.bertolla
 */

namespace visao\json\cadastros;

use visao\json\cadastros\MaterialConsumoJson,
    visao\json\cadastros\MaterialPermanenteJson,
    visao\json\cadastros\ObraJson,
    visao\json\cadastros\ServicoJson,
    modelo\cadastros\MaterialConsumo,
    modelo\cadastros\MaterialPermanente,
    modelo\cadastros\Servico,
    modelo\cadastros\Obra;

class ItemJson {

    private $itemJson;

    private function setInstancia($item) {
        if ($item instanceof MaterialConsumo) {
            $this->itemJson = new MaterialConsumoJson ();
        } elseif ($item instanceof MaterialPermanente) {
            $this->itemJson = new MaterialPermanenteJson();
        } elseif ($item instanceof Obra) {
            $this->itemJson = new ObraJson();
        } elseif ($item instanceof Servico) {
            $this->itemJson = new ServicoJson();
        }
    }

    function retornoItemJson($item) {
        $this->setInstancia($item);
        return $this->itemJson->retornoJson($item);
    }

}
