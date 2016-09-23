<?php

namespace visao\json;

use ArrayObject,
    visao\json\UsuarioJson,
    configuracao\GerenciarLogin,
    visao\json\RetornoJson;

class LoginJson extends RetornoJson {

    function retornoJson(GerenciarLogin $dadosLogin) {
        $usuarioJson = new UsuarioJson();
        return $usuarioJson->retornoJson($dadosLogin->getUsuarioLogado());
    }

}
