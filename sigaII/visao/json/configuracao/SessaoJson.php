<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SessaoJson
 *
 * @author alex.bertolla
 */

namespace visao\json\configuracao;

use configuracao\Sessao,
    visao\json\UsuarioJson,
    visao\json\configuracao\SistemaJson,
    visao\json\RetornoJson;

class SessaoJson extends RetornoJson {

    function retornoJson($sessao) {
        if ($sessao instanceof Sessao) {
            $usarioJson = new UsuarioJson();
            $sistemaJson = new SistemaJson();
            return array(
                "nome" => $sessao->getNome(),
                "estado" => $sessao->getEstado(),
                "usuario" => $usarioJson->retornoJson($sessao->getUsuario()),
                "sistema" => $sistemaJson->retornoJson($sessao->getConfiguracao())
            );
        }
    }

}
