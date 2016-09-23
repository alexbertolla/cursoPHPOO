<?php

/* * 
 * ***************************************************************************
 * Representação lógica da conta conta contábil no sistema.
 * 
 * Atributos:
 * id: representa a chave de indexação do banco de dados e não deve ser alterado
 * pelo sistema;
 * 
 * codigo: representa o código cadastrado no SIAFI. Deve seguir o mesmo padrão e
 * regra do sistema;
 * 
 * nome: representa o nome cadastrado no SIAFI. Deve seguir o mesmo padrão e
 * regra do sistema;
 * 
 * situacao: Não é recomendado a exclusão do banco de dados, por isso, esse
 * atribudo indica se a natureza de despesa está ativa ou não para uso do
 * sistema.
 * 
 * Alex Bisetto Bertolla
 * alex.bertolla@embrapa.br
 * (85)3391-7163
 * Núcleo de Tecnologia da Informação
 * Embrapa Agroidústria Tropical
 * 
 * ***************************************************************************
 */

namespace modelo\cadastros;

class ContaContabil {

    private $id;
    private $codigo;
    private $nome;
    private $situacao;

    function __construct() {
        
    }

    public function __destruct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getNome() {
        return $this->nome;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function toString() {
        $string = "(" .
                "id=>" . $this->getId() . ", " .
                "codigo=>" . $this->getCodigo() . ", " .
                "nome=>" . $this->getNome() . ", " .
                "situacao=>" . $this->getSituacao()
                . ")";
        return $string;
    }

}
