<?php

use configuracao\GeradorPDF,
    controle\compras\impressao\GerarDocumentosProcessoCompra;

include_once '../autoload.php';

$pdf = new GeradorPDF();
$pdf->setImagemDeFundo("./imagens/logoSIGASolo.png");


$processoCompraId = filter_input(INPUT_GET, "processoCompraId");
$gerarMapa = new GerarDocumentosProcessoCompra();
$processo = $gerarMapa->buscarProcessoCompra($processoCompraId);
$modalidade = $processo->getModalidade();


$listaFornecedoresVencedores = $gerarMapa->listarFornecedoresVencedores($processoCompraId);


$listaItensPorPa = $gerarMapa->listarAgrupadoPorPA($processoCompraId);

$listaItensPorND = $gerarMapa->listarAgrupadoPorNaturezaDespesa($processoCompraId);
$listarItensPorGrupo = $gerarMapa->listarAgrupadoPorGrupo($processoCompraId);


ob_start();
include_once './imprimirMapaComparativo.php';
$html = ob_get_clean();
$pdf->incluirHTML($html);
$pdf->incluirHTML("<div class=\"quebraDePagina\"></div>");

ob_start();
include_once './imprimirRO.php';
$html = ob_get_clean();
$pdf->incluirHTML($html);
$pdf->incluirHTML("<div class=\"quebraDePagina\"></div>");

ob_start();
include_once './imprimirAdjudicacao.php';
$html = ob_get_clean();
$pdf->incluirHTML($html);
$pdf->incluirHTML("<div class=\"quebraDePagina\"></div>");


ob_start();
include_once './imprimirHomologacao.php';
$html = ob_get_clean();
$pdf->incluirHTML($html);
$pdf->incluirHTML("<div class=\"quebraDePagina\"></div>");

ob_start();
include_once './imprimirFormularioDispensa.php';
$html = ob_get_clean();
$pdf->incluirHTML($html);

$pdf->exibirRelatorio();
