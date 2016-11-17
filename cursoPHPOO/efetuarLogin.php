<?php

include_once './autoload.php';


$usuario = $_POST['usuario'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

try {
    $conn = son\config\ConexaoBD::conectarBD();
    $fixture = new son\fixture\FixtureUsuario($conn);
    if ($fixture->autenticar($usuario, $senha)) {
        session_start();
        $_SESSION['LOGADO'] = TRUE;
        header('location:index.php');
    } else {
        $_SESSION['LOGADO'] = FALSE;
        header('location:index.php');
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}


