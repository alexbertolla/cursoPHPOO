<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\almoxarifado;

/**
 * Description of EnumSituacaoRequisicao
 *
 * @author alex.bertolla
 */
class EnumSituacaoRequisicao {

    const EmEdicao = 1;
    const Enviado = 2;
    const Recebido = 3;
    const Devolvido = 4;
    const AtendiDoAgColeta = 5;
    const AtendidoAgEntrega = 6;
    const EntregueAssinado = 7;
    const Cancelado = 8;

}
