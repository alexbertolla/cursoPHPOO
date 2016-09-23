<?php

namespace modelo\cadastros;

/* * 
 * ***************************************************************************
 * Representação lógica do almoxarifados virtuais no sistema. Não confundir com
 * o estoque físico. Os almoxarifados virtuais servem para organizar os itens
 * no sistema.
 * 
 * Atributos:
 * id: representa a chave de indexação do banco de dados e não deve ser alterado
 * pelo sistema;

 * 
 * nome: nome do almoxarifado virtual cadastrado no sistema;
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

class AlmoxarifadoVirtual {

    private $id;
    private $nome;
    private $situacao;

    function getId() {
        return $this->id;
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

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function toString() {
        $string = "(" .
                "id=>" . $this->getId() . "," .
                "nome=>" . $this->getNome() . "," .
                "situacao=>" . $this->getSituacao()
                . ")";
        return $string;
    }

    public function __construct() {
        
    }

    public function __destruct() {
        
    }

}
