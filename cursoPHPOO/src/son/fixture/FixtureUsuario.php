<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace son\fixture;

use son\usuario\Usuario;

/**
 * Description of FixtureUsuario
 *
 * @author alex
 */
class FixtureUsuario {

    private $usuario;
    private static $conn;

    public function __construct(\PDO $conn, Usuario $usuario) {
        $this->usuario = $usuario;
        self::$conn = $conn;
    }

    public function getarEstruturaBD() {
        if (!$this->criarTabela()) {
            throw new \Exception('ERRO AO CRIAR TABELA');
        }
        
        if (!$this->criarUsuarioAdmin()) {
            throw new \Exception('ERRO AO INSERIR USUARIO admin');
        }
        
    }

    private function criarTabela() {
        echo '<br> ### GERANDO TABELA ### <br>';
        return $this->usuario->gerarTabelaUsuario(self::$conn);
    }

    private function criarUsuarioAdmin() {
        echo '<br> ### GERANDO USUARIO admin ### <br>';
        $username = 'admin';
        $senha = password_hash('admin', PASSWORD_DEFAULT);
        $this->usuario->setUsuario($username);
        $this->usuario->setSenha($senha);
        return $this->usuario->persistirUsuario(self::$conn, $this->usuario);
    }

}
