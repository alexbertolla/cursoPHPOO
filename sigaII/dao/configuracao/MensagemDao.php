<?php

namespace dao\configuracao;

use bibliotecas\persistencia\BD,
    ArrayObject;

class MensagemDao {

    private $sql;
    private $bd;
    private $resultado;

    public function __construct() {
        $this->bd = new BD();
    }

    public function __destruct() {
        unset($this->bd);
    }

    function alterarDao($id, $mensagem) {
        $this->sql = "UPDATE bd_siga.mensagem SET mensagem=\"{$mensagem}\" WHERE id={$id}";
        return ($this->bd->query($this->sql)) ? TRUE : FALSE;
    }

    function listarDao() {
        $this->sql = "SELECT * FROM bd_siga.mensagem ORDER BY codigo ASC";
        $this->resultado = $this->bd->query($this->sql);
        $arrMensagem = new ArrayObject();
        while ($mensagem = $this->bd->fetch_object("configuracao\Mensagem")) {
            $arrMensagem->append($mensagem);
        }
        return $arrMensagem;
    }

    function buscarPorCodigoDao($codigo) {
        $this->sql = "SELECT * FROM bd_siga.mensagem WHERE codigo=\"{$codigo}\";";
        $this->resultado = $this->bd->query($this->sql);
        return $this->bd->fetch_object("configuracao\Mensagem");
    }

}
