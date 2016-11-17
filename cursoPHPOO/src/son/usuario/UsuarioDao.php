<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace son\usuario;

use son\usuario\Usuario;

/**
 * Description of UsuarioDao
 *
 * @author alex.bertolla
 */
class UsuarioDao {

    private static $connDB;

    public function __construct(\PDO $conn) {
        self::$connDB = $conn;
    }

    public function criarTabelaUsuario() {
        self::$connDB->query('DROP TABLE IF EXISTS usuario;');

        $query = 'CREATE TABLE usuario ('
                . 'id int(11) NOT NULL AUTO_INCREMENT,'
                . 'usuario text,'
                . 'senha text'
                . ' DEFAULT NULL,PRIMARY KEY (`id`)'
                . ')';
        return self::$connDB->query($query);
    }

    public function persist(Usuario $usuario) {
        if (is_null($usuario->getId())) {
            return $this->inserirUsuario($usuario);
        } else {
            return $this->alterarUsuario($usuario);
        }
        return FALSE;
    }

    private function inserirUsuario(Usuario $usuario) {
        $query = 'INSERT INTO  usuario (usuario, senha) VALUES '
                . ' (:usuario, :senha);';
        $stmt = self::$connDB->prepare($query);
        $stmt->bindParam('usuario', $usuario->getUsuario());
        $stmt->bindParam('senha', $usuario->getSenha());
        return $stmt->execute();
    }

    private function alterarUsuario(Usuario $usuario) {
        $query = 'UPDATE  usuario SET usuario = :usuario, senha = :senha '
                . ' WHERE id = :id;';
        $stmt = self::$connDB->prepare($query);
        $stmt->bindParam('id', $usuario->getId());
        $stmt->bindParam('usuario', $usuario->getUsuario());
        $stmt->bindParam('senha', $usuario->getSenha());
        return $stmt->execute();
    }

    public function excuirUsuario($id) {
        $query = 'DELETE FROM usuario WHERE id = :id';
        $stmt = self::$connDB->prepare($query);
        $stmt->bindParam('id', $id);
        return $stmt->execute();
    }

    public function buscarUsuario($usuario) {
        $query = 'SELECT * FROM usuario '
                . 'WHERE usuario = :usuario ';
        $stmt = self::$connDB->prepare($query);
        $stmt->bindParam('usuario', $usuario);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function listarUsuario() {
        $query = 'SELECT * FROM usuario '
                . ' ORDER BY usuario ASC ';
        $stmt = self::$connDB->prepare($query);
        $stmt->execute();
        return $stmt->fetchALL(\PDO::FETCH_OBJ);
    }

    public function buscarUsuarioPorId($id) {
        $query = 'SELECT * FROM usuario '
                . ' WHERE id = :id ';
        $stmt = self::$connDB->prepare($query);
        $stmt->bindParam('id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

}
