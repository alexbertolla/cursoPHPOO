<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace configuracao;

use bibliotecas\mpdf\PDF;

/**
 * Description of GeradorPDF
 *
 * @author alex.bertolla
 */
class GeradorPDF extends PDF {

    public function __construct() {
        parent::__construct();
    }
    
    
    function incluirCSS($cssFile){
        $this->incluirArquivoCSS($cssFile);
    }

}
