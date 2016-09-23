<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controle\email;

use controle\email\EnviarEmail;
use modelo\almoxarifado\RequisicaoMaterial,
    modelo\almoxarifado\ItemRequisicao;

/**
 * Description of EmailRequisicao
 *
 * @author alex.bertolla
 */
class EmailRequisicao extends EnviarEmail {

    function __construct() {
        parent::__construct();
    }

    function emailRequisicaoEnviado(RequisicaoMaterial $requisicaoMaterial) {
        $destinatario = $requisicaoMaterial->getRequisitante()->getEmail();
        $situacao = $requisicaoMaterial->getSituacao();
        $this->setDestinatario($destinatario);
        $this->setAssunto($situacao->getSituacao());

        $mensagem = $situacao->getMensagem();
        $mensagem.= $this->montaDetalhesEmail($requisicaoMaterial);
        $this->setMensagem($mensagem);
        return $this->envairEmail();
    }

    private function montaDetalhesEmail(RequisicaoMaterial $requisicaoMaterial) {
        $detalhesRequisicao = "<pre>"
                . "Detalhes do pedido \n"
                . "Número: " . $requisicaoMaterial->getNumero() . " \n"
                . "Requisitante: " . $requisicaoMaterial->getRequisitante()->getNome() . " \n"
                . "Lotação (pedido): " . $requisicaoMaterial->getLotacao()->getNome() . " \n"
                . "Plano de Ação: " . $requisicaoMaterial->getPa()->getTitulo() . " \n"
                . "Valor da requisição: " . $requisicaoMaterial->getValor() . " \n"
                . "</pre>";
        $detalhesRequisicao.= $this->montaListaItensRequisicao($requisicaoMaterial->getListaItemRequisicao());
        return $detalhesRequisicao;
    }

    private function montaListaItensRequisicao($listaItemRequisicao) {
        $listaItens = "<pre>";
        foreach ($listaItemRequisicao as $itemRequisicao) {
            $itemRequisicao instanceof ItemRequisicao;
            $item = $itemRequisicao->getItemEstoque()->getItem();
            $listaItens .= "<p>Código Item: " . $item->getCodigo() . "\n";
            $listaItens .= "Nome Item: " . $item->getNome() . "\n";
            $listaItens .= "Quantidade Item: " . $itemRequisicao->getQuantidade() . "\n </p>";
            $listaItens .= "Preço Médio Item: " . $itemRequisicao->getValorUnitario() . "\n </p>";
        }
        $listaItens .="</pre>";
        return $listaItens;
    }

    function __destruct() {
        parent::__destruct();
    }

}
