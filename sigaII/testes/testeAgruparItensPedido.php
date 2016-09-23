<?php

include_once '../autoload.php';

$manterIPC = new controle\compras\ManterItemProcessoCompra();

$listaItemProcesso = $manterIPC->listarParaMontarOrdemDeCompraDao('00012016', '0001');

//print_r($listaItemProcesso);
$novaLista = array();
$itemProcessoAnteriro ;
$idx = 0;
$qtdTotal = 0;

echo '<pre>';
foreach ($listaItemProcesso as $itemProcesso) {
    $item = $itemProcesso->getItem();
    if ( ($itemProcesso instanceof \modelo\compras\ItemProcessoCompra) && $itemProcessoAnteriro !== $itemProcesso) {

        echo $item->getNome() . '|' . $itemProcesso->getQuantidade() . '<br>';
        $idx++;
    }
    $itemProcessoAnteriro = clone $itemProcesso;
}
echo '<pre>';
