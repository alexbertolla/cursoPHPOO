<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="../visao/js/jquery.js"></script>
        <script src="../visao/js/acaoFormularios.js"></script>
        <script>
            var arrayItemEntrada = [];

            var formatarNotaFiscal = function () {
                var notaFiscal = {numero: '123456789', chaveAcesso: 'abc123ags456', fornecedorId: '1'};
                return notaFiscal;
            };


            var formatarArrayItemEntrada = function (item, quantidade, valorUnitario, fornecedorId) {
                var itemEntrada = {
                    entradaId: null, fornecedorId: fornecedorId, itemId: item.id,
                    grupoId: item.grupoId, quantidade: quantidade, valorUnitario: valorUnitario,
                    valorTotal: valorUnitario * quantidade, item: item
                };
                arrayItemEntrada.push(itemEntrada);
            };

            var item1 = {id: 185, grupoId: 230};
            var item2 = {id: 186, grupoId: 230};
            var item3 = {id: 189, grupoId: 230};
            var item4 = {id: 187, grupoId: 230};
            var item5 = {id: 188, grupoId: 230};
            var item6 = {id: 190, grupoId: 230};
            var item7 = {id: 191, grupoId: 230};
            var item8 = {id: 192, grupoId: 230};
            var item9 = {id: 193, grupoId: 230};
            var item10 = {id: 194, grupoId: 230};

            formatarArrayItemEntrada(item1, 23, 35.60, 16);
            formatarArrayItemEntrada(item2, 35, 30.00, 16);
            formatarArrayItemEntrada(item3, 75, 15.64, 16);
            formatarArrayItemEntrada(item4, 40, 75.36, 16);
            formatarArrayItemEntrada(item5, 13, 65.00, 16);
            formatarArrayItemEntrada(item6, 22, 50.0, 16);
            formatarArrayItemEntrada(item7, 58, 7.00, 16);
            formatarArrayItemEntrada(item8, 9, 3.00, 16);
            formatarArrayItemEntrada(item9, 63, 78.50, 16);
            formatarArrayItemEntrada(item10, 53, 5.69, 16);
//            console.log(arrayItemEntrada);


            var parametros = {opcao: 'salvar', ano: '2016', fornecedorId: '16', ordemCompraId: '',
                tipoFornecedor: 'pf', naturezaOperacaoId: '1', notaFiscal: formatarNotaFiscal(), listaItemEntrada: arrayItemEntrada};

            console.log(parametros);
            
            requisicaoAjax('../servlets/almoxarifado/ServletEntradaMaterial.php', parametros, function (retorno) {
                console.log(retorno);
                    console.log(retorno.estado);
                    console.log(retorno.mensagem);
                    console.log(retorno.dados);
                });

        </script>
    </head>
    <body>
        <?php
        // put your code here
        ?>
    </body>
</html>
