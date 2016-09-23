<?php

namespace siga;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
define("RAIZSISTEMA", __DIR__ . "/");
#define("RAIZSERVIDOR", "/usr/local/sistemas/");

define("RAIZSERVIDOR", $_SERVER["DOCUMENT_ROOT"] . "/aplicacoes/sistemas/");

spl_autoload_register(function ($class) {
    $classe = str_replace("\\", "/", $class . ".php");
//    echo $classe;
//echo "<br>";

    if (is_readable(RAIZSISTEMA . $classe)) {
        include_once (RAIZSISTEMA . $classe);
    } elseif (is_readable(RAIZSERVIDOR . $classe)) {
        include_once (RAIZSERVIDOR . $classe);
    }
});
