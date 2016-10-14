<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConexaoBD
 *
 * @author alex.bertolla
 */

namespace son\config;

class ConexaoBD {

    public static function conectarBD() {
        try {
            $config = array(
                'db' => array(
                    'host' => 'localhost',
                    'dbname' => 'cursoPHPOO',
                    'user' => 'root',
                    'password' => 'root'
                )
            );
            if (!isset($config['db'])) {
                throw new \InvalidArgumentException("Configuração do banco de dados não existe");
            }

            $host = (isset($config['db']['host'])) ? $config['db']['host'] : NULL;
            $dbname = (isset($config['db']['dbname'])) ? $config['db']['dbname'] : NULL;
            $user = (isset($config['db']['user'])) ? $config['db']['user'] : NULL;
            $password = (isset($config['db']['password'])) ? $config['db']['password'] : NULL;

            return new \PDO("mysql:host={$host};dbname={$dbname}", $user, $password);
        } catch (\PDOException $ex) {
            echo $ex->getMessage() . "\n";
            echo $ex->getTraceAsString() . "\n";
        }
    }

}
