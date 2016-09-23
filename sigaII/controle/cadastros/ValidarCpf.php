<?php

namespace controle\cadastros;

class ValidarCpf {

    public function __construct() {
        
    }

    public function __destruct() {
        
    }

    // Verifica se nenhuma das sequências invalidas abaixo 
    // foi digitada. Caso afirmativo, retorna falso
    private function verificaSequincial($cpf) {
        if ($cpf == '00000000000' ||
                $cpf == '11111111111' ||
                $cpf == '22222222222' ||
                $cpf == '33333333333' ||
                $cpf == '44444444444' ||
                $cpf == '55555555555' ||
                $cpf == '66666666666' ||
                $cpf == '77777777777' ||
                $cpf == '88888888888' ||
                $cpf == '99999999999') {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    // Elimina possivel mascara
    private function eliminaMascara($cpf) {
        return preg_replace('/[^0-9]/', '', $cpf);
    }

    private function verificarDigiRtos($cpf) {
        for ($t = 9; $t < 11; $t++) {

            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return FALSE;
            }
        }

        return TRUE;
    }

    function validarCPF($cpf) {
        // Verifica se um número foi informado
        if (empty($cpf)) {
            return FALSE;
        }

        if (!$this->verificaSequincial($cpf)) {
            return FALSE;
        }

        $cpf = $this->eliminaMascara($cpf);


        // Verifica se o numero de digitos informados é igual a 11 
        if (strlen($cpf) != 11) {
            return false;
        } else {
            return $this->verificarDigiRtos($cpf);
        }
    }

}
