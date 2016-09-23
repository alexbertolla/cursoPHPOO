<?php

namespace visao\json;

use sgp\Funcionario,
    visao\json\LotacaoJson,
    ArrayObject;

class FuncionarioJson extends RetornoJson{

    function retornoJson($funcionario) {
        $lotacaoJson = new LotacaoJson();
        return ($funcionario instanceof Funcionario) ?
                array(
            "matricula" => $funcionario->getMatricula(),
            "nome" => $funcionario->getNome(),
            "email" => $funcionario->getEmail(),
            "lotacao" => $lotacaoJson->retornoJson($funcionario->getLotacao())
                ) : NULL;
    }

    function retornoListaJson($listaFuncionario) {
        if ($listaFuncionario instanceof ArrayObject) {
            $novoArray = new ArrayObject();
            foreach ($listaFuncionario as $funcionario) {
                $novoArray->append($this->retornoJson($funcionario));
            }
            return $novoArray->getArrayCopy();
        } else {
            return NULL;
        }
    }

}
