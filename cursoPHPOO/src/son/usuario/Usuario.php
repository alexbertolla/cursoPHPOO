<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace son\usuario;

use son\usuario\UsuarioDao;

/**
 * Description of Usuario
 *
 * @author alex
 */
class Usuario {

    private $id;
    private $usuario;
    private $senha;

    function persistirUsuario(\PDO $conn, Usuario $usuario) {
        $usuarioDao = new UsuarioDao($conn);
        return $usuarioDao->persist($usuario);
    }

    function excluirUsuario(\PDO $conn) {
        $usuarioDao = new UsuarioDao($conn);
        $usuarioDao->excuirUsuario($this->id);
    }

    function autenticarUsuario(\PDO $conn) {
        $usuarioDao = new UsuarioDao($conn);
        $usuario = $usuarioDao->buscarUsuario($this->getUsuario());
        if ($usuario && password_verify($this->senha, $usuario->senha)) {
            return TRUE;
        } else {
            throw new \Exception('Login incorreto!');
        }
    }

    function listarUsuario(\PDO $conn) {
        $usuarioDao = new UsuarioDao($conn);
        $lista = $usuarioDao->listarUsuario();
        $listaUsuario = array();
        foreach ($lista as $usuario) {
            $user = new Usuario();
            $user->setId($usuario->id);
            $user->setUsuario($usuario->usuario);
            $listaUsuario[] = $user;
        }
        return $listaUsuario;
    }

    function buscarUsuarioPorId(\PDO $conn, $id) {
        $usuarioDao = new UsuarioDao($conn);
        $usuario = $usuarioDao->buscarUsuarioPorId($id);
        $user = new Usuario();
        $user->setId($usuario->id);
        $user->setUsuario($usuario->usuario);
        $user->setSenha($usuario->senha);
        return $user;
    }

    function gerarTabelaUsuario(\PDO $conn) {
        $usuarioDao = new UsuarioDao($conn);
        return $usuarioDao->criarTabelaUsuario();
    }

    function getId() {
        return $this->id;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getSenha() {
        return $this->senha;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

}
