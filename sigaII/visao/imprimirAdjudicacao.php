<?php
//use controle\compras\impressao\GerarDocumentosProcessoCompra,
//    configuracao\GeradorPDF;
//include_once '../autoload.php';
//$pdf = new GeradorPDF();
//$processoCompraId = 1;
//ob_start();
//$gerarMapa = new GerarDocumentosProcessoCompra();
//$processo = $gerarMapa->buscarProcessoCompra($processoCompraId);
//$modalidade = $processo->getModalidade();
//
//$listaFornecedoresVencedores = $gerarMapa->listarFornecedoresVencedores($processoCompraId);
//
//$listaItensPorPa = $gerarMapa->listarAgrupadoPorPA($processoCompraId);
//
//$listaItensPorND = $gerarMapa->listarAgrupadoPorNaturezaDespesa($processoCompraId);
//$listarItensPorGrupo = $gerarMapa->listarAgrupadoPorGrupo($processoCompraId);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/impressaoMapaComparativo.css">
        <title></title>
    </head>
    <body >
        <table id="tabelaCabecalho">
            <tr>
                <td id="tdLogoSistema"><img id="imgLogoSistema" src="imagens/logoSIGA.png" alt="logo"></td>
            </tr>
        </table>

        <h2 class="titulo">Adjudicação</h2>

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

        <div id="divInfoDocumento">
            <blockquote>
                ADJUDICO a(s) empresa(s) acima relacionada(s) com seu(s) respectivo(s) item(ns), vencedora(s) deste certame.
            </blockquote>
        </div>

        <table id="tabelaAssinaturaChefia">
            <tr>
                <td><span>Em, _______ de ________________________ de ___________</span></td>
            </tr>
            <tr >
                <td class="tdAssChefeGeral">
                    <p>
                        <span class="spanAssChefeGeral">___________________________________________</span><br/>
                        <span >Chefe Geral</span>
                    </p>

                </td>
            </tr>
        </table>
    </body>
</html>

<?php
//        exit();
//$html = ob_get_clean();
//$pdf->setImagemDeFundo("./imagens/logoSIGASolo.png");
//$pdf->incluirHTML($html);
//$pdf->exibirRelatorio();
?>