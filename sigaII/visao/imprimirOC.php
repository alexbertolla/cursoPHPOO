<?php
include_once '../autoload.php';

use controle\compras\ManterOrdemDeCompra,
    controle\compras\ManterProcessoCompra,
    controle\configuracao\ManterDadosUnidade,
    configuracao\GeradorPDF;

$id = filter_input(INPUT_GET, "id");

$manterOC = new ManterOrdemDeCompra();
$ordemDeCompra = $manterOC->buscarPorId($id);
$manterOC->setDadosBancario();

$manterProcessoCompra = new ManterProcessoCompra();
$processo = $manterProcessoCompra->buscarPorId($ordemDeCompra->getProcessoCompraId());
$modalidade = $processo->getModalidade();
$fornecedor = $ordemDeCompra->getFornecedor();
$endereco = $fornecedor->getEndereco();
$dadosBancario = $ordemDeCompra->getDadosBancario();
$banco = $dadosBancario->getBanco();
$listaEmpenho = $ordemDeCompra->getListaEmpenho();
$listaItens = $ordemDeCompra->getListaItemOrdemDeCompra();

$manterDadosUnidade = new ManterDadosUnidade();
$unidade = $manterDadosUnidade->buscarDadosUnidade();
$enderecoUnidade = $unidade->getEndereco();

$gerarPDF = new GeradorPDF();
ob_start();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/imprimirOC.css">
        <title></title>
    </head>
    <body>
        <table id="tabelaCabecalho">
            <tr>
                <td id="tdLogoSistema"><img id="imgLogoSistema" src="imagens/logoSIGA.png" alt="logo"></td>
            </tr>
        </table>

        <h2 class="titulo">Ordem de Compra / Serviço</h2>

        <table id="tabelaInfoContrado">
            <thead><tr><th colspan="2">1- Informações do Contrato</th></tr></thead>
            <tbody>
                <tr>
                    <td id="tdNumeroProcesso">
                        N. OCS: <span><?= $ordemDeCompra->getNumero() ?></span>
                        Sequência:<span><?= $ordemDeCompra->getSequencia() ?></span>
                    </td>
                    <td id="tdDataEmissaoProcesso">
                        Data Emissão:<span><?= $ordemDeCompra->getDataEmissao() ?></span>
                    </td>
                </tr>
            </tbody>
        </table>

        <p></p>

        <table>
            <thead><tr><th colspan="2">2- Informações do Contratado</th></tr></thead>
            <tbody>
                <tr>
                    <td>
                        CNPJ/CPF: <span><?= $fornecedor->getDocumento() ?></span><br/>
                        Fornecedor: <span><?= $fornecedor->getNome() ?></span></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table>
                            <tr>
                                <td>Endereço: <span><?= $endereco->getLogradouro() ?>, <?= $endereco->getNumero() ?></span></td>
                            </tr>
                            <tr>
                                <td>Complemento: <span><?= $endereco->getComplemento ?></span></td>
                            </tr>
                            <tr>
                                <td>Bairro: <span><?= $endereco->getBairro ?></span></td>
                            </tr>
                            <tr>
                                <td>Cidade:<?= $endereco->getCidade() ?> - <?= $endereco->getEstado() ?></td>
                            </tr>
                            <tr>
                                <td>CEP: <span><?= $endereco->getCep() ?></span></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table>
                            <tr>
                                <td>Banco: <span><?= $banco->getCodigo() ?> - <?= $banco->getNome() ?></span></td>
                                <td>Agência: <span><?= $dadosBancario->getAgencia() ?></span></td>
                                <td> Conta: <span><?= $dadosBancario->getConta() ?></span></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

        <p></p>

        <table>
            <thead><tr><th colspan="2">3 - Documento de Origem</th></tr></thead>
            <tbody>
                <tr><td>N. Processo: <span><?= $processo->getNumero() ?></span></td></tr>
                <tr><td>Modalidade:<span><?= $modalidade->getNome() ?></span> <span><?= $processo->getNumeroModalidade() ?></span></td></tr>
            </tbody>
        </table>

        <p></p>

        <table id="tabelaInfoEmpenho">
            <thead><tr><th colspan="7">4 - Compromissamento Orçamentário</th></tr></thead>
            <tbody>
                <tr class="trCabechalho"><td id="tdNumeroEmpenho">Nº Empenho</td><td id="tdDataEmpenho">Data</td>
                    <td id="tdUGEmpenho">Unid/Orc</td><td id="tdFoneteEmpenho">Fonte</td>
                    <td id="tdPAEmepnho">PA</td><td id="tdValorEmpenho">Valor(R$)</td><td id="tdNDEmpenho">Natureza Despesa</td></tr>
                <?php
                foreach ($listaEmpenho as $empenho) {
                    ?>
                    <tr>
                        <td>____________</td><td>____/_____/_______</td><td><?= $empenho->getunidadeOrcamentaria() ?></td>
                        <td>___________</td><td><?= $empenho->getPA()->getCodigo() ?> - <?= $empenho->getPA()->getResponsavel() ?></td>
                        <td><?= $empenho->getValor() ?></td><td><?= $empenho->getNaturezaDespesa()->getNome() ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>

        <p></p>

        <table>
            <thead><tr><th colspan="7">5 - Identificação e Condições de Fornecimento</th></tr></thead>
        </table>

        <blockquote class="blockquote">
            Sobre valores de bens e/ou serviços constantes do anexo I da Instrução Normativa SRF N. 306, de 12/03/2003, EMBRAPA  retera na fontem
            O (%) correspondente ao IRPJ, SDLL, COFINS e PIS/PASEP. O percentual a ser aplicado aos tributos deverá ser destacado no documento fical,
            pelo seu emitente. Se optante simples nacional emitir e enviar declaração original anexa a nota fical com mesma data da NF. a não apresentação da declaração, acrretará
            nas deduções dos tributos como empresa normal.
            Convênio ICMS 47/98, programado até 31/12/2014, pelo convêncio ICMS 101/12, que isenta a EMBRAPA de ICMS. Os dados bancários informados na NF. para fins de pagamento,
            deverão ser em nome do favorecido, sob pena de cancelamento da ordem bancária.
            Inciso II Art. 24 da Lei 8666/93

        </blockquote>

        <table id="tabelaInfoItens">
            <tbody>
                <tr><td>Item</td><td>Código</td><td>Descrição</td><td>UN.</td><td>Quantidade</td><td>Valor Unitário(R$)</td> <td>Valor Total(R$)</td></tr>
                <?php
                foreach ($listaItens as $itemOrdemCompra) {
                    $item = $itemOrdemCompra->getItem();
                    ?>
                    <tr><td>Item</td><td><?= $item->getCodigo() ?></td><td><?= $item->getDescricao() ?></td>
                        <td>UN.</td>
                        <td><?= $itemOrdemCompra->getQuantidade() ?></td><td><?= $itemOrdemCompra->getValorUnitario() ?></td><td><?= $itemOrdemCompra->getValorTotal() ?></td></tr>
                    <?php
                }
                ?>
            </tbody>
        </table>

        <p></p>

        <table>
            <thead><tr><th colspan="2">6 - Condições Gerais</th></tr></thead>
            <tbody>
                <tr><td colspan="2">Dados para faturamento</td></tr>
                <tr>
                    <td>Nome: <span><?= $unidade->getNome() ?> - <?= $unidade->getSigla() ?></span></td>
                    <td>CNPJ: <span><?= $unidade->getCnpj() ?></span></td>
                </tr>
                <tr><td>Dados para entrega</td></tr>
                <tr>
                    <td>
                        Local: <span><?= $enderecoUnidade->getLogradouro() ?>, <?= $enderecoUnidade->getNumero() ?> - <?= $enderecoUnidade->getBairro() ?></span> - 
                        <span><?= $enderecoUnidade->getCidade() ?> - <?= $enderecoUnidade->getEstado() ?> - CEP: <?= $enderecoUnidade->getCep() ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        Prazo de entrega: <span> Até <?= $ordemDeCompra->getPrazo() ?> dias</span>
                    </td>
                </tr>
            </tbody>
        </table>

        <blockquote>
            <p>
                -Multa<br/>
                0,33% ao dia sobre o valor total da OCS ou parte não cumprida.
                O descumprimento total ou parcial da obrigação assumida pelo fornecedor, poderá ensejar a aplicação das penalidades previstas nos artigos 86 a 88,
                da Lei 8.666/93, bem como a multa recisoria de 10% (dez por cento) sobre o valor global atualizado no contrato.
                <br/>
                - Anotações obrigatórias na Nota Fiscal/Fatura<br/>
                Devera constar da conta corrente, nome e código do banco e da agência.
                <br/>
                -Encargos<br/>
                Impostos, taxas, fretes e demais encargos estão inclusos no valor total desta OCS.
            </p>
        </blockquote>


        <p></p>

        <table>
            <thead><tr><th>7 - Condições Adicionais</th></tr></thead>
        </table>
        <blockquote>
            <p>
                Esta OCS é emitida de acordo com as normas vigentes na Empresa, nesta data.
                De acordo com a Lei Municiapl N. 7.640, de 20/12/1994, a EMBRAPA retera, na forma de contribuinte
            </p>
            <p>
                Substituto, o imposto sobre serviços-ISS dos prestadores de serviços no município de Fortaleza.
                A EMBRAPAé isenta do pagamento do diferencial de alíquota de ICMS, nas aquisições interestaduais de bes do ativo
                imobilizado e de uso ou consumo, de acordo com convênio ICMS 47/98.
            </p>
        </blockquote>


        <p></p>

        <table>
            <thead><tr><th>8 - Condições Contratuais</th></tr></thead>
        </table>
        <blockquote>Pagamento condicionado a apresentação da CND-INSS, CRF-FGTS e consulta ao CADIN</blockquote>

        <p></p>
        <table id="tabelaInfoEmissor">
            <tr>
                <td class="tdCabeclaho">Identificação do Emissor</td><td class="tdCabeclaho">Endereço para contado</td>
            </tr>
            <tr>
                <td>
                    <table id="tabelaAssinatura">
                        <tr>
                            <td class="tdAssinatura">___________________________________________<br/>
                                Superviros SPM
                            </td>
                        </tr>
                        <tr>
                            <td class="tdAssinatura">___________________________________________<br/>
                                Chefe Adj. Administração
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="tdContato">
                    <table>
                        <tr>
                            <td>
                                Endereço para Contao<br/>
                                <span><?= $enderecoUnidade->getLogradouro() ?>, <?= $enderecoUnidade->getNumero() ?> - <?= $enderecoUnidade->getBairro() ?></span><br/>
                                <span><?= $enderecoUnidade->getCidade() ?> - <?= $enderecoUnidade->getEstado() ?></span><br/>
                                <span><?= $enderecoUnidade->getCep() ?></span><br/>
                                <span><?= $unidade->getTelefone() ?></span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>
                                Autorizamos o fornecimento do material / serviço / equipamento
                                especificado nesta OCS no valor:<br/>
                                Total de RS:<?= $ordemDeCompra->getValor() ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span>Fortaleza - CE</span>
                                <span>Data: _____/______/______</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="tdAssinatura">
                                <span>___________________________________________</span><br/>
                                <span>Chefe Geral</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <td>
                                Recebemos a 1 via desta OCS em _____/______/______,<br/>
                                Manifestando-nos de acordo com as condições nela constantes<br/>
                                <span><?= $fornecedor->getNome() ?></span><br/>


                            </td>
                        </tr>
                        <tr>
                            <td class="tdAssinatura">
                                <p>Nome:___________________________________________</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="tdAssinatura">
                                <p>Ass:___________________________________________</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
<?php
$html = ob_get_clean();
$gerarPDF->setImagemDeFundo("./imagens/logoSIGASolo.png");
$gerarPDF->incluirHTML($html);
$gerarPDF->exibirRelatorio();
?>