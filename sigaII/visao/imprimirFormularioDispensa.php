

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/impressaoMapaComparativo.css">
        <title></title>
    </head>
    <body>

        <?php
        $contador = 1;
        foreach ($listaFornecedoresVencedores as $fornecedor) {
            $listaIntesVencedores = $gerarMapa->listarItemVencedorPorFornecedor($processoCompraId, $fornecedor->getId());
            $valorTotal = 0;
            $listaPa = new ArrayObject();
            foreach ($listaIntesVencedores as $itemProposta) {
                $valorTotal+=$itemProposta->getValorTotal();
                $listaPa->append($gerarMapa->buscarPAPorPedido($itemProposta->getPedidoId()));
            }
            ?>
            <table id="tabelaCabecalho">
                <tr>
                    <td id="tdLogoSistema"><img id="imgLogoSistema" src="imagens/logoSIGA.png" alt="logo"></td>
                </tr>
            </table>
            <h2 class="titulo">Formulário de Dispensa/Inexigibilidade</h2>
            <table>
                <tbody>
                    <tr><td>N. Processo: <span><?= $processo->getNumero() ?></span></td></tr>
                    <tr><td>Modalidade:<span><?= $modalidade->getNome() ?></span> <span><?= $processo->getNumeroModalidade() ?></span></td></tr>
                </tbody>
            </table>



            <table class="tabelaDispensa">
                <tr><td><span>1-Objeto</span></td></tr>
                <tr><td><span><?= nl2br($processo->getObjeto()) ?></span></td></tr>
            </table>
            <table class="tabelaDispensa">
                <tr><td><span>2-Favorecido</span></td></tr>
                <tr><td>Nome: <span><?= $fornecedor->getNome() ?></span></td></tr>
                <tr><td>CNPJ/CPF: <span><?= $fornecedor->getDocumento() ?></span></td></tr>
            </table>
            <table class="tabelaDispensa">
                <tr><td><span>3-Valor</span></td></tr>
                <tr><td>Valor Total: <span><?= $valorTotal ?></span></td></tr>
            </table>
            <table class="tabelaDispensa">
                <tr><td><span>4-Classificação Orçamentária</span></td></tr>
                <?php
                $idPaAnterior = 0;
                foreach ($listaPa as $pa) {
                    if ($pa->getId() !== $idPaAnterior) {
                        ?>
                        <tr><td>Subprojeto: <span><?= $pa->getCodigo() ?></span></td></tr>
                        <tr><td>Título: <span><?= $pa->getTitulo() ?></span></td></tr>
                        <tr><td>Valor: <span><?= $valorTotal ?></span></td></tr>
                        <?php
                    }
                    $idPaAnterior = $pa->getId();
                }
                ?>
            </table>
            <table class="tabelaDispensa">
                <tr><td><span>5-Justificativas</span></td></tr>
                <tr><td><span><?= nl2br($processo->getJustificativa()) ?></span></td></tr>
            </table>
            <?php
            if ($contador < count($listaFornecedoresVencedores)) {
                ?>
                <div class="quebraDePagina"></div>

                <?php
            }
            $contador++;
        }
        ?>

        <blockquote>
            Usando da delegação de competência que me foi outorgado pela Portaria/Embrapa nº 474/13, de 11/04/2013 e com fundamento
            no inicso II do artigo 24 da Lei 8666/93, autorizo a aquisiçãio/contratação, por Dispensa de Licitação nas consições a acima assinaladas.
        </blockquote>
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