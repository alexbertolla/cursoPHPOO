<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace son\fixture;

use son\cliente\ClienteAbstract;
use son\cliente\types\ClientePF;
use son\cliente\types\ClientePJ;

/**
 * Description of Fixture
 *
 * @author alex.bertolla
 */
class Fixture {

    private static $connDB;
    private $stmt;

    public function __construct(\PDO $conn) {
        self::$connDB = $conn;
    }

    public function criarTabelaCliente() {
        echo "## INICIO ##<br>";
        echo "removendo tabela páginas";
        self::$connDB->query('DROP TABLE IF EXISTS cliente;');

        $query = 'CREATE TABLE cliente ('
                . 'id int(11) NOT NULL AUTO_INCREMENT,'
                . 'nome text,endereco text,'
                . 'telefone text,'
                . 'email text,'
                . 'grauImportancia smallint(6)'
                . ' DEFAULT NULL,PRIMARY KEY (`id`)'
                . ')';
        self::$connDB->query($query);
        echo "-OK <br>";
    }

    public function persist(ClienteAbstract $cliente) {
        if ($cliente->getId()) {
            $this->alterar($cliente);
        } else {
            return $this->inserir($cliente);
        }
        return FALSE;
    }

    private function inserir(ClienteAbstract $cliente) {
        echo "## PERSISTINDO CLIENTE ##<br>";
        $query = 'INSERT INTO cliente (nome, endereco, telefone, email, grauImportancia) '
                . ' VALUES (:nome, :endereco, :telefone, :email, :grauImportancia)';
        $this->stmt = self::$connDB->prepare($query);
        $this->stmt->bindParam('nome', $cliente->getNome());
        $this->stmt->bindParam('endereco', $cliente->getEndereco());
        $this->stmt->bindParam('telefone', $cliente->getTelefone());
        $this->stmt->bindParam('email', $cliente->getEmail());
        $this->stmt->bindParam('grauImportancia', $cliente->getGrauImportancia());
        return $this->flush();
    }

    private function alterar(ClienteAbstract $cliente) {
        echo "## PERSISTINDO CLIENTE ##<br>";
        echo $query = 'UPDATE cliente SET nome=:nome, endereco=:endereco, telefone=:telefone, '
        . ' email=:email, grauImportancia=:grauImportancia '
        . ' WHERE id=:id';
        $this->stmt = self::$connDB->prepare($query);
        $this->stmt->bindParam('id', $cliente->getId());
        $this->stmt->bindParam('nome', $cliente->getNome());
        $this->stmt->bindParam('endereco', $cliente->getEndereco());
        $this->stmt->bindParam('telefone', $cliente->getTelefone());
        $this->stmt->bindParam('email', $cliente->getEmail());
        $this->stmt->bindParam('grauImportancia', $cliente->getGrauImportancia());
        return $this->flush();
    }

    public function excluirCliente($id) {
        $query = 'DELETE FROM cliente WHERE id=:id';
        $this->stmt = self::$connDB->prepare($query);
        $this->stmt->bindParam('id', $id);
        return $this->flush();
    }

    public function flush() {
        echo "## FLUSH CLIENTE ##<br>";
        return $this->stmt->execute();
    }

    public function listarClientes() {
        $query = 'SELECT * FROM cliente ORDER BY nome';
        $stmt = self::$connDB->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function buscarClientePorId($id) {
        $query = 'SELECT * FROM cliente WHERE id=:id';
        $stmt = self::$connDB->prepare($query);
        $stmt->bindParam('id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function gerarListaClientes() {
        echo "## CRIANDO LISTA DE CLIENTES ##<br>";
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
        $listaCliente[] = $cliente11;
        return $listaCliente;
    }

}
