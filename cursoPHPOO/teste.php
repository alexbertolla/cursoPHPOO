<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
