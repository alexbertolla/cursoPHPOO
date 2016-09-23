<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modelo\compras;

/**
 * Description of EnumSituacaoPedido
 *
 * @author alex.bertolla
 */
class EnumSituacaoPedido {

    const EmEdicao = 0;
    const EnviadoChefia = 1;
    const RecebidoChefia = 2;
    const Autorizado = 3;
    const Devolvido = 4;
    const NaoAutorizado = 5;
    const EncaminhadoSPS = 6;
    const RecebidoSPS = 7;

}
