<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace son\fixture;

use Usuario;

/**
 * Description of FixtureUsuario
 *
 * @author alex
 */
class FixtureUsuario {

    private static $connDB;

    public function __construct(\PDO $conn) {
        self::$connDB = $conn;
    }

    public function criarTabelaUsuario() {
        self::$connDB->query('DROP TABLE IF EXISTS usuario;');

        $query = 'CREATE TABLE usuario ('
                . 'id int(11) NOT NULL AUTO_INCREMENT,'
                . 'usuario text'
                . 'senha text,'
                . ' DEFAULT NULL,PRIMARY KEY (`id`)'
                . ')';
        self::$connDB->query($query);
    }

    public function pesist(\Usuario $usuario) {
        if ($usuario->getId()) {
            return $this->inserirUsuario($usuario);
        } else {
            return $this->alterarUsuario($usuario);
        }
        return FALSE;
    }

    private function inserirUsuario(\Usuario $usuario) {

        $query = 'INSERT INTO  usuario (usuario, senha) VALUES '
                . ' (:usuairo, :senha);';
        $stmt = self::$connDB->prepare($query);
        $stmt->bindParam('usuario', $usuario->getUsuairo());
        $stmt->bindParam('senha', $usuario->getSenha());
        return $stmt->execute();
    }

    private function alterarUsuario(\Usuario $usuario) {
        $query = 'UPDATE  usuario SET usuario = :usuario, senha = :senha '
                . ' WHERE id = :id;';
        $stmt = self::$connDB->prepare($query);
        $stmt->bindParam('id', $usuario->getId());
        $stmt->bindParam('usuario', $usuario->getUsuairo());
        $stmt->bindParam('senha', $usuario->getSenha());
        return $stmt->execute();
    }

    public function excuirUsuario($id) {
        $query = 'DELETE FROM usuario WHERE id = :id';
        $stmt = self::$connDB->prepare($query);
        $stmt->bindParam('id', $usuario->getId());
        return $stmt->execute();
    }

    public function autenticar($usuario, $senha) {
        $query = 'SELECT * FROM usuario '
                . 'WHERE usuario = :usuario '
                . ' AND '
                . ' senha = :senha';
        $stmt = self::$connDB->prepare($query);
        $stmt->bindParam('usuario', $usuario);
        $stmt->bindParam('senha', $senha);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

}
