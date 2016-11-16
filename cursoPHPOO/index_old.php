<?php

include_once './autoload.php';
try {
    $conn = son\config\ConexaoBD::conectarBD();
    $fixture = new son\fixture\Fixture($conn);

    $fixture->criarTabelaCliente();

    $listaNovosClientes = $fixture->gerarListaClientes();
    foreach ($listaNovosClientes as $cliente) {
        $fixture->persist($cliente);
    }
    $listarClientesCadastrados = $fixture->listarClientes($conn);
    foreach ($listarClientesCadastrados as $clienteCadastrado) {
        echo 'Nome: ' . $clienteCadastrado->nome . '<br/>';
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}