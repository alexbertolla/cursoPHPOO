<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\compras;

/**
 * Description of EnumItemPedido
 *
 * @author alex.bertolla
 */
class EnumSituacaoItemPedido {

    const EmEdicao = 0;
    const AgAutorizacao = 1;
    const NaoAutorizado = 2;
    const AgProcesso = 3;
    const IncProcesso = 4;
    const OCSEmitida = 5;

}
