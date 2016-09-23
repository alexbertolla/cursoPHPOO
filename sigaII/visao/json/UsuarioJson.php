<?php

namespace visao\json;

use configuracao\Usuario,
    ArrayObject;

class UsuarioJson extends RetornoJson {

    function retornoJson($usuario) {

        return ($usuario instanceof Usuario) ? array(
            "matricula" => $usuario->getMatricula(),
            "nomeUsuario" => $usuario->getNomeUsuario(),
            "nome" => $usuario->getNome(),
            "email" => $usuario->getEmail(),
            "idPerfil" => $usuario->getIdPerfil(),
            "nomePerfil" => $usuario->getNomePerfil()
                ) : NULL;
    }

}
