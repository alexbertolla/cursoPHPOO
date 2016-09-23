<?php

use controle\compras\impressao\GerarRegistroOrcamentario,
    configuracao\DataSistema;

$dataSistema = new DataSistema();

$gerarRO = new GerarRegistroOrcamentario();
$processo = $gerarRO->buscarProcessoCompra($processoCompraId);
$modalidade = $processo->getModalidade();

$listaFornecedores = $gerarRO->listarFornecedoresVencedores($processoCompraId);
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
        <link rel="stylesheet" href="css/imprimirRO.css">
        <title>Registro Orçamentário</title>
    </head>
    <body>

        <?php
        $contador = 1;
        foreach ($listaFornecedores as $fornecedor) {
            $valorTotal = 0;
            $listaItem = $gerarRO->listarItemVencedorPorFornecedor($processoCompraId, $fornecedor->getId());
            foreach ($listaItem as $item) {
                $valorTotal+=$item->getValorTotal();
                $pa = $gerarRO->listarPAPorPedido($item->getPedidoId());
                $naturezaDespesa = $gerarRO->buscarNaturezaDespesa($item->getNaturezaDespesaId());
            }
            ?>
            <table id="tabelaCabecalho">
                <tr>
                    <td id="tdLogoSistema"><img id="imgLogoSistema" src="imagens/logoSIGA.png" alt="logo"></td>
                </tr>
            </table>

            <h2 class="titulo">Registro Orçamentário</h2>



            <div id="divInfoDocumento">
                <blockquote id="blockquoteRO">
                    O presente Registro Orçamentário visa formalizar o Processo Administrativo de Aquisição e/ou Contratação em referência, na forma
                    do que se dispõe o Inciso III, Parágrafo 2º do Artigo 7 e Artigo 14, da Lei 8.666/93, de 21/06/1993.
                    O SPS deverá preencher os campos a seguir, e submete-lo ao SOF para fins de indicação de disponibilidade orçamentária e emissão de
                    pré emepenho, conforme o caso. O SOF deverá encaminhar este RO ao SPS no prazo de 2 (dois) dias úteis afim de que o mesmo possa 
                    informar ao solicitante a existência ou não de recusros orçamentários e dar início ao processo de aquisição e/ou contratação;
                </blockquote>
            </div>
            <div id="divInfoEmpenho">
                <table id="tabelaEmpenho">
                    <tbody>
                        <tr><td>N. Processo: <span><?= $processo->getNumero() ?></span></td></tr>
                        <tr><td>Modalidade: <span><?= $modalidade->getNome() ?></span><span><?= $processo->getNumeroModalidade() ?></span></td></tr>
                        <tr><td id="tdDocumento">CNPJ/CPF: <span><?= $fornecedor->getDocumento() ?></span></td></tr>
                        <tr><td>Favorecido: <span><?= $fornecedor->getNome() ?></span></td></tr>
                        <tr>
                            <td colspan="2">
                                <table id="tabelaItemEmpenho">
                                    <tbody>
                                        <tr><td>Subprojeto</td><td>Responsável</td><td>Valor</td></tr>
                                        <tr><td><?= $pa->getCodigo() ?></td><td><?= $pa->getResponsavel() ?></td><td><?= $valorTotal ?></td></tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <p></p>
                <table>
                    <tbody>
                        <tr>
                            <td>
                                Forteleza - CE <?= date("d") ?> de <?= $dataSistema->mesPorExtenso(date("m")) ?> de <?= date("Y") ?>
                            </td>
                            <td>Ass:______________________________________</td>
                        </tr>
                    </tbody>
                </table>
                <p></p>

                <table id="tabelaSof">
                    <tr>
                        <td>Recebido em ___/___/______</td><td>Ass:______________________________________</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            (  ) Sim, há disponibilidade orçamentária
                        </td>
                    </tr>
                </table>
            </div>
            <?php
            if ($contador < count($listaFornecedores)) {
                ?>
                <div class="quebraDePagina"></div>

                <?php
            }
            $contador++;
        }
        ?>
    </body>
</html>