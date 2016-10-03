<?php

include_once './ClientePF.php';
include_once './ClientePJ.php';
include_once './ClienteEspecifico.php';

$listaCliente = [];

$cliente1 = new ClientePF("Alex", '123456', 'Rua x', '123458', 'alex@dominio.com');
$cliente1->setGrauImportancia(5);
$listaCliente[] = $cliente1;

$cliente2 = new ClientePF('Sabrina', '12345678', 'Av 1', '1234656', 'sabrina@dominio.com');
$cliente2->setGrauImportancia(5);
$listaCliente[] = $cliente2;

$cliente3 = new ClientePF('Maria', '8247224132', 'Rua z', '3216546', 'mariax@dominio.com');
$cliente3->setGrauImportancia(3);
$listaCliente[] = $cliente3;

$cliente4 = new ClientePF('Joana', '43248564', 'Rua a', '35346546', 'joanax@dominio.com');
$cliente4->setGrauImportancia(4);
$listaCliente[] = $cliente4;

$cliente5 = new ClientePF('Patricia', '14544354', 'av 2', '3565466', 'patriciax@dominio.com');
$cliente5->setGrauImportancia(2);
$listaCliente[] = $cliente5;

$cliente6 = new ClientePJ('empresa1', '45454124', 'av 10', '6356456', 'fabiox@dominio.com');
$cliente6->setGrauImportancia(5);
$listaCliente[] = $cliente6;

$cliente7 = new ClientePJ('empresa2', '245646', 'rua 15', '324655354', 'caralosx@dominio.com');
$cliente7->setGrauImportancia(4);
$listaCliente[] = $cliente7;

$cliente8 = new ClientePJ('empresa3', '546546', 'av 10', '2453321', 'pedrox@dominio.com');
$cliente8->setGrauImportancia(2);
$listaCliente[] = $cliente8;

$cliente9 = new ClientePJ('empresa4', '46543244', 'rua x', '46532126', 'wesleyx@dominio.com');
$cliente9->setGrauImportancia(3);
$listaCliente[] = $cliente9;

$cliente10 = new ClientePJ('empresa5', '543434', 'rua z', '52456465', 'fulanox@dominio.com');
$cliente10->setGrauImportancia(4);
$listaCliente[] = $cliente10;


$cliente11 = new ClientePF('pedro', '521313465', 'rua 10', '4565444654', 'pedro@dominio.com');
$cliente11->setGrauImportancia(1);
$enderecoCobranca = 'av abc 123';
$clienteEspecifico = new ClienteEspecifico($cliente11, $enderecoCobranca);
$listaCliente[] = $clienteEspecifico;
