<?php

namespace modelo\compras;

class AtividadeOCS {

    private $id;
    private $atividade;
    private $data;
    private $ordemCompraId;

    function getId() {
        return $this->id;
    }

    function getAtividade() {
        return $this->atividade;
    }

    function getData() {
        return $this->data;
    }

    function getOrdemCompraId() {
        return $this->ordemCompraId;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setAtividade($atividade) {
        $this->atividade = $atividade;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setOrdemCompraId($ordemCompraId) {
        $this->ordemCompraId = $ordemCompraId;
    }

}
