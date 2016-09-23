<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ValidarCNPJ
 *
 * @author alex.bertolla
 */

namespace controle\cadastros;

class ValidarCNPJ {

    public function __construct() {
        
    }

    public function __destruct() {
        
    }

    private function eliminaMascara($cnpj) {
        return preg_replace('/[^0-9]/', '', $cnpj);
    }

    private function multiplica_cnpj($cnpj, $posicao = 5) {
        // Variável para o cálculo
        $calculo = 0;

        // Laço para percorrer os item do cnpj
        for ($i = 0; $i < strlen($cnpj); $i++) {
            // Cálculo mais posição do CNPJ * a posição
            $calculo = $calculo + ( $cnpj[$i] * $posicao );

            // Decrementa a posição a cada volta do laço
            $posicao--;

            // Se a posição for menor que 2, ela se torna 9
            if ($posicao < 2) {
                $posicao = 9;
            }
        }
        // Retorna o cálculo
        return $calculo;
    }

    function validarCNPJ($cnpj) {
        $cnpj = $this->eliminaMascara($cnpj);
        $cnpj_original = $cnpj;

        // Captura os primeiros 12 números do CNPJ
        $primeiros_numeros_cnpj = substr($cnpj, 0, 12);

        // Faz o primeiro cálculo
        $primeiro_calculo = $this->multiplica_cnpj($primeiros_numeros_cnpj);

        // Se o resto da divisão entre o primeiro cálculo e 11 for menor que 2, o primeiro
        // Dígito é zero (0), caso contrário é 11 - o resto da divisão entre o cálculo e 11
        $primeiro_digito = ( $primeiro_calculo % 11 ) < 2 ? 0 : 11 - ( $primeiro_calculo % 11 );

        // Concatena o primeiro dígito nos 12 primeiros números do CNPJ
        // Agora temos 13 números aqui
        $primeiros_numeros_cnpj .= $primeiro_digito;

        // O segundo cálculo é a mesma coisa do primeiro, porém, começa na posição 6
        $segundo_calculo = $this->multiplica_cnpj($primeiros_numeros_cnpj, 6);
        $segundo_digito = ( $segundo_calculo % 11 ) < 2 ? 0 : 11 - ( $segundo_calculo % 11 );

        // Concatena o segundo dígito ao CNPJ
        $cnpj = $primeiros_numeros_cnpj . $segundo_digito;

        // Verifica se o CNPJ gerado é idêntico ao enviado
        if ($cnpj === $cnpj_original) {
            return true;
        }
        return FALSE;
    }

}
