<?php

include_once './autoload.php';
use son\usuario\Usuario;

$username = $_POST['usuario'];
$senha = $_POST['senha'];
//        password_hash($_POST['senha'], PASSWORD_DEFAULT);

try {
    $conn = son\config\ConexaoBD::conectarBD();
    $usuario = new Usuario();
    $usuario->setUsuario($username);
    $usuario->setSenha($senha);
    
    if ($usuario->autenticarUsuario($conn)) {
        session_start();
        $_SESSION['LOGADO'] = TRUE;
        header('location:menu.php');
    } else {
        $_SESSION['LOGADO'] = FALSE;
        header('location:index.php');
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}


