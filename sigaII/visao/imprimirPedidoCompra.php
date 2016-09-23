<?php
include_once '../autoload.php';

use controle\compras\impressao\MontarImpressaoPedidoCompra,
    modelo\compras\Pedido,
    configuracao\GeradorPDF;

ob_start();

$id = filter_input(INPUT_GET, "id");
$impressaoPedido = new MontarImpressaoPedidoCompra();
$impressaoPedido->buscarPedido($id);
$pedido = $impressaoPedido->getPedidoCompra();
$pedido instanceof Pedido;
$solicitante = $pedido->getSolicitante();
$pa = $pedido->getPa();
$listaItensPedido = $pedido->getListaItemPedido();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <!--<link rel="stylesheet" href="css/estiloFormularios.css">-->
        <link rel="stylesheet" href="css/impressaoPedidoCompra.css">
        <title></title>
    </head>
    <body >
        <table id="tabelaCabecalho">
            <tr>
                <td id="tdLogoSistema"><img id="imgLogoSistema" src="imagens/logoSIGA.png" alt="logo"></td>
            </tr>
        </table>


        <table id="tabelaInfoPedido" class="fontInfoPedido">
            <tr><td class="tdTitulo" colspan="3">Informações do Pedido</td></tr>
            <tr>
                <td><label id="labelNumeroPedido">Número do pedido: </label> <span id="spanNumeroPedido"><?= $pedido->getNumero() ?></span> </td>
                <!--<td><label id="labelDataPedido">Data de envio: </label> <?= $pedido->getDataEnvio() ?></td>-->
                <!--<td><label id="labelDataPedido">Data de impressão: </label><span id="spanDataPedido"><?= date("d/m/Y") ?></span></td>-->
            </tr>
            <tr>
                <td><label id="labelDataPedido">Solicitante: </label><span id="spanSolicitanteNome"><?= $solicitante->getNome() ?></span></td>
                <td><label id="labelDataPedido"></label><span id="spanSolicitanteLotacao"><?= $solicitante->getLotacao()->getNome() ?></span></td>
            </tr>
            <tr>
                <td class="tdTitulo" colspan="3">Plano de Ação</td>
            </tr>
            <tr>
                <td><label id="labelPaCodigo">Código: </label> <span id="spanPaCodigo"><?= $pa->getCodigo() ?></span></td>
                <td colspan="2"><label id="labelPaCodigo">Título: </label> <span id="spanPaCodigo"><?= $pa->getTitulo() ?></span></td>
            </tr>
            <tr>
                <td colspan="3"><label id="labelPaResponsavel">Responsável: </label> <span id="spanPaCodigo"><?= $pa->getResponsavel() ?></span></td>
            </tr>
            <tr>
                <td><label id="labelPaSaldoInvestimento">Saldo Investimento: </label> <span id="spanPaCodigo"><?= $pa->getSaldoInvestimento() ?></span></td>
                <td><label id="labelPaSaldoCusteio">Saldo Custeio: </label> <span id="spanPaCodigo"><?= $pa->getSaldoCusteio() ?></span></td>
            </tr>
            <tr>
                <td class="tdTitulo" colspan="3">Justificativa</td>
            </tr>
            <tr>
                <td><?= nl2br($pedido->getJustificativa()) ?></td>    
            </tr>

        </table>

        <p></p>

        <table id="tabelaItensPedido" class="labeRelatorio fontTabelaItemPedido">
            <thead>
                <tr>
                    <th id="thCodigoItem">Código</th>
                    <th id="thDescricaoItem">Descrição</th>
                    <th id="thQuantidadeItem">Quantidade</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($listaItensPedido as $itemPedido) {
                    $item = $itemPedido->getItem();
                    ?>
                    <tr>
                        <td id="tdCodigoItem"><?= $item->getCodigo() ?></td>
                        <td id="tdDescricaoItem"><?= $item->getDescricao() ?></td>
                        <td id="tdQuantidadeItem"><?= $itemPedido->getQuantidade() ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>

        <table id="tabelaAssinatura">
            <tr>
                <td id="tdAssSolicitante"><span >Solicitante</span><br/><span id="spanDataPedido"><?= date("d/m/Y") ?></span></td>
                <td id="tdVazio"></td>
                <td id="tdAssChefia"><span >Chefia</span><br/><span>____/____/______</span></td>
            </tr>
        </table>
    </body>
</html>
<?php

$html = ob_get_clean();
$pdf = new GeradorPDF();
$pdf->setImagemDeFundo("./imagens/logoSIGASolo.png");
$pdf->incluirHTML($html);
$pdf->exibirRelatorio();
?>