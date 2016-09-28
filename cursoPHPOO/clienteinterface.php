<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author alex.bertolla
 */
interface ClienteInterface {

    function getNome();

    function setNome($nome);

    function getEndereco();

    function setEndereco($endereco);

    function getTelefone();

    function setTelefone($telefone);

    function getEmail();

    function setEmail($email);

    function setGrauImportancia($grauImportancia);
}
