<?php

//use controle\compras\impressao\GerarDocumentosProcessoCompra,
//    configuracao\GeradorPDF;
//include_once '../autoload.php';
//$pdf = new GeradorPDF();
//ob_start();
//$processoCompraId = 1;




?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/impressaoMapaComparativo.css">
        <title>Mapa Comparativo de Preços</title>
    </head>
    <body >
        <table id="tabelaCabecalho">
            <tr>
                <td id="tdLogoSistema"><img id="imgLogoSistema" src="imagens/logoSIGA.png" alt="logo"></td>
            </tr>
        </table>

        <h2 class="titulo">Mapa Comparativo de Preços</h2>

        <table id="tabelaMapaComparativo">
            <tbody>
                <tr><td>N. Processo: <span><?= $processo->getNumero() ?></span></td></tr>
                <tr><td>Modalidade:<span><?= $modalidade->getNome() ?></span> <span><?= $processo->getNumeroModalidade() ?></span></td></tr>
            </tbody>
        </table>


        <?php
        foreach ($processo->getListaLoteProcessoCompra() as $loteProcessoCompra) {
            foreach ($loteProcessoCompra->getListaItemProcessoCompra() as $itemProcesso) {

                $item = $itemProcesso->getItem();
                ?>
                <table class="tabelaItemProcesso">
                    <thead>
                        <tr><th class="thCodigo">Código</th><th class="thDescricao">Descrição</th><th class="thQuantidade">Quatidade</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="tdCodigo"><?= $item->getCodigo() ?></td><td class="tdDescricao"><?= $item->getDescricao() ?></td><td class="tdQuantidade"><?= $itemProcesso->getQuantidade() ?></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <table class="tabelaItemProposta">
                                    <thead><tr><th class="thDocumento">CNPJ/CPF</th><th class="thFornecedor">Fornecedor</th><th class="thValor">Valor unitário</th><th class="thValor">Valor total</th></tr></thead>
                                    <tbody>
                                        <?php
                                        $listaItemProposta = $gerarMapa->listarItensPropostasProProcessoCompra($processoCompraId, $item->getId());
                                        foreach ($listaItemProposta as $itemProposta) {
                                            $fornecedor = $itemProposta->getFornecedor();
                                            ?>
                                            <tr>
                                                <td class="tdDocumento"><?= $fornecedor->getDocumento() ?></td>
                                                <td class="tdFornecedor"><?= $fornecedor->getNome() ?></td>
                                                <td class="tdValor"><?= $itemProposta->getValorUnitario() ?></td>
                                                <td class="tdValor"><?= $itemProposta->getValorTotal() ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php
            }
        }
        ?>

        <div class="quebraDePagina"></div>


        <h3 class="titulo">Ganhadores</h3>
        <table id="tabelaMapaComparativo">
            <tbody>
                <tr><td>N. Processo: <span><?= $processo->getNumero() ?></span></td></tr>
                <tr><td>Modalidade:<span><?= $modalidade->getNome() ?></span> <span><?= $processo->getNumeroModalidade() ?></span></td></tr>
            </tbody>
        </table>
        <?php
        foreach ($listaFornecedoresVencedores as $fornecedor) {
            $valorTotal = 0;
            ?>
            <table class="tablelaVencedores">
                <thead><tr><th class="thDocumento">CNPJ/CPF</th><th class="thFornecedor">Fornecedor</th><th class="thVazio"></th></thead>
                <tbody>
                    <tr>
                        <td class="tdDocumento"><?= $fornecedor->getDocumento() ?></td>
                        <td class="tdFornecedor"><?= $fornecedor->getNome() ?></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <table class="tabelaItemProcessoVencedor">
                                <thead><tr><th class="thCodigo">Código</th><th class="thDescricao">Descrição</th><th class="thValor">Valor</th></tr>
                                <tbody>
                                    <?php
                                    $listaItemVencedor = $gerarMapa->listarItemVencedorPorFornecedor($processoCompraId, $fornecedor->getId());
                                    foreach ($listaItemVencedor as $itemProposta) {
                                        $valorTotal+=$itemProposta->getValorTotal();
                                        $item = $itemProposta->getItem();
                                        ?>
                                        <tr>
                                            <td class="tdCodigo"><?= $item->getCodigo() ?></td>
                                            <td class="tdDescricao"><?= $item->getDescricao() ?></td>
                                            <td class="tdValor"><?= $itemProposta->getValorTotal() ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot><tr><td class="tdValorTotal" colspan="2">Total</td><td class="tdSomaValorTotal"><?= $valorTotal ?></td></tr></tfoot>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php
        }
        ?>

        <h3 class="titulo"> Despesas por subprojetos </h3>

        <table id="tabelaPA">
            <thead><tr><th class="thCodigo">Código</th><th class="thTitulo">Título</th><th class="thResposanvel">Responsável</th><th class="thValor">Valor</th></tr></thead>
            <tbody>
                <?php
                $totalGeral = 0;
                foreach ($listaItensPorPa as $itemProposta) {
                    $pa = $gerarMapa->buscarPAPorPedido($itemProposta->getPedidoId());
                    $totalGeral+=$itemProposta->getValorTotal();
                    ?>
                    <tr>
                        <td class="tdCodigo"><?= $pa->getCodigo() ?></td><td class="tdTitulo"><?= $pa->getTitulo() ?></td><td class="tdResponsavel"><?= $pa->getResponsavel() ?></td><td class="tdValor"><?= $itemProposta->getValorTotal() ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
            <tfoot class="tfoot"><tr><td colspan="3" class="tdValorTotal">Total geral</td><td class="tdSomaValorTotal"><?= $totalGeral ?></td></tr></tfoot>
        </table>

        <h3 class="titulo"> Despesas por Natureza </h3>

        <table id="tabelaND">
            <thead><tr><th class="thCodigo">Código</th><th class="thNome">Nome</th><th class="thValor">Valor</th></tr></thead>
            <tbody>
                <?php
                $totalGeral = 0;
                foreach ($listaItensPorND as $itemProposta) {
                    $nd = $gerarMapa->buscarNaturezaDespesa($itemProposta->getNaturezaDespesaId());
                    $totalGeral+=$itemProposta->getValorTotal();
                    ?>
                    <tr>
                        <td class="tdCodigo"><?= $nd->getCodigo() ?></td><td class="tdNome"><?= $nd->getNome() ?></td><td class="tdValor"><?= $itemProposta->getValorTotal() ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
            <tfoot><tr><td colspan="2" class="tdValorTotal">Total geral</td><td class="tdSomaValorTotal"><?= $totalGeral ?></td></tr></tfoot>
        </table>

        <h3 class="titulo"> Despesas por Grupo </h3>

        <table id="tabelaGrupo">
            <thead><tr><th class="thCodigo">Código</th><th class="thNome">Nome</th><th class="thValor">Valor</th></tr></thead>

            <tbody>
                <?php
                $totalGeral = 0;
                foreach ($listarItensPorGrupo as $itemProposta) {
                    $grupo = $gerarMapa->buscarGrupo($itemProposta->getGrupoId());
                    $totalGeral+=$itemProposta->getValorTotal();
                    ?>
                    <tr>
                        <td class="tdCodigo"><?= $grupo->getCodigo() ?></td><td><?= $grupo->getNome() ?></td><td class="tdValor"><?= $itemProposta->getValorTotal() ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
            <tfoot><tr><td colspan="2" class="tdValorTotal">Total geral</td><td class="tdSomaValorTotal"><?= $totalGeral ?></td></tr></tfoot>
        </table>

        <table id="tabelaAssinatura">
            <tr>
                <td id="tdAssSolicitante"><span >Resp. Emissão</span><br/><span id="spanDataPedido"><?= date("d/m/Y") ?></span></td>
                <td id="tdVazio"></td>
                <td id="tdAssChefia"><span >Chefia</span><br/><span>____/____/______</span></td>
            </tr>
        </table>

    </body>
</html>

<?php
//$html = ob_get_clean();
//$pdf->setImagemDeFundo("./imagens/logoSIGASolo.png");
//$pdf->incluirHTML($html);
//$pdf->exibirRelatorio();
?>