<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RetornoJson
 *
 * @author alex.bertolla
 */

namespace visao\json;

abstract class RetornoJson {

    function formataRetornoJson($estado, $mensagem, $dados) {
        return array("estado" => $estado, "mensagem" => $mensagem, "dados" => $dados);
    }

}
