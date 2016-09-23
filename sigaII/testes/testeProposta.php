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
            var url = '../servlets/compras/ServletProposta.php';
            var propostaGlobal;
            var listaItemProposta = [];
            var processoCompraGlobal;
            var valorTotalProposta = 0.00;

            var gerarListaItemProposta = function (fornecedorId, tipoFornecedor) {
                var item1 = {
                    propostaId: '', fornecedorId: fornecedorId, processoCompraId: processoCompraGlobal.id,
                    loteId: 1, pedidoId: 1, itemId: 1, quantidade: 10, valorUnitario: 60.4,
                    valorTotal: 60.4 * 10, tipoFornecedor: tipoFornecedor
                };

                var item2 = {
                    propostaId: '', fornecedorId: fornecedorId, processoCompraId: processoCompraGlobal.id,
                    loteId: 1, pedidoId: 1, itemId: 2, quantidade: 46, valorUnitario: 10,
                    valorTotal: 10 + 46, tipoFornecedor: tipoFornecedor
                };
                var item3 = {
                    propostaId: '', fornecedorId: fornecedorId, processoCompraId: processoCompraGlobal.id,
                    loteId: 1, pedidoId: 1, itemId: 3, quantidade: 7, valorUnitario: 30.5,
                    valorTotal: 30.5 + 7, tipoFornecedor: tipoFornecedor
                };

                listaItemProposta.push(item1);
                listaItemProposta.push(item2);
                listaItemProposta.push(item3);

                valorTotalProposta = item1.valorTotal + item2.valorTotal + item3.valorTotal;
            };

            var buscarProcessoPorId = function (id) {
                var urlProcessoCompra = '../servlets/compras/ServletProcessoCompra.php';
                console.log('############### BUSCAR PROCESSO DE COMPRA POR ID ################');
                var parametros = {opcao: 'buscarPorId', id: id};
                requisicaoAjax(urlProcessoCompra, parametros, function (retornoBuscarPorId) {
                    processoCompraGlobal = retornoBuscarPorId.dados;
                    imprimirRetorno(retornoBuscarPorId);
                });
            };


            var imprimirRetorno = function (retorno) {
                console.log(retorno);
                console.log(retorno.estado);
                console.log(retorno.mensagem);
                console.log(retorno.dados);
            };

            var novaProposta = function () {
                var data = '21/07/2016';
                var numero = '123/2016';
                var processoCompraId = processoCompraGlobal.id;
                var fornecedorId = 26;
                var tipoFornecedor = 'pf';

                gerarListaItemProposta(fornecedorId, tipoFornecedor);

                var parametros = {
                    opcao: 'inserir', data: data, numero: numero,
                    processoCompraId: processoCompraId, fornecedorId: fornecedorId,
                    tipoFornecedor: tipoFornecedor, listaItemProposta: listaItemProposta,
                    valor: valorTotalProposta
                };
                requisicaoAjax(url, parametros, imprimirRetorno);
            };

            buscarProcessoPorId(1);
            novaProposta();
        </script>
    </head>

</html>
