<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <script src="../visao/js/jquery.js"></script>
        <script src="../visao/js/acaoFormularios.js"></script>
        <script>

            var url = '../servlets/compras/ServletOrdemDeCompra.php';
            var processoCompraId = 2;
            var ocsGlobal;
            var listarAgrupadasPorFornecedor = function () {
                console.log('################## listarAgrupadasPorFornecedor ##################')
                var parametros = {opcao: 'listarAgrupadasPorFornecedor', processoCompraId: processoCompraId};
                requisicaoAjax(url, parametros, function (retornoOCS) {
                    console.log(retornoOCS);
                    console.log(retornoOCS.estado);
                    console.log(retornoOCS.mensagem);
                    console.log(retornoOCS.dados);
                    ocsGlobal = retornoOCS.dados[0];
                });
            };

            var emitirOCS = function () {
                console.log('################## emitirOCS ##################')
                console.log(ocsGlobal);
                var parametros = {opcao: "efetivarEmissao", id: ocsGlobal.id, dadosBancarioId: '3', prazo: '30', listaItemOrdemCompra: null};
                requisicaoAjax(url, parametros, function (retornoEmissaoOCS) {
                    console.log(retornoEmissaoOCS.estado);
                    console.log(retornoEmissaoOCS.mensagem);
                    console.log(retornoEmissaoOCS.dados);
                });
            };

            var buscarPorId = function () {
                console.log('################## listarAgrupadasPorFornecedor ##################')
                var parametros = {opcao: 'buscarPorId', id: 1};
                requisicaoAjax(url, parametros, function (retornoOCS) {
                    listarItensProcessoCompra(retornoOCS.dados.listaItemProcessoCompra);
//                    console.log(retornoOCS);
//                    console.log(retornoOCS.estado);
//                    console.log(retornoOCS.mensagem);
//                    console.log(retornoOCS.dados);
//                    ocsGlobal = retornoOCS.dados[0];
                });
            };

            var listarItensProcessoCompra = function (listaItensProcessoCompra) {

                var itemAnterior = 0;
                var quantidadeTotal = 0;
                $(listaItensProcessoCompra).each(function () {
                    var itemProcesso = $(this)[0];


                    if (itemAnterior !== itemProcesso.itemId) {
                        console.log(itemProcesso.item.nome);
                        quantidadeTotal = 0;
//                        console.log('| QUANTIDADE TOTAL: ' + quantidadeTotal);
//                    console.log(itemProcesso.quantidade);    
                    }

                    var solicitante = buscarSolicitantePedido(itemProcesso.pedidoId);

                    quantidadeTotal += parseFloat(itemProcesso.quantidade);
                    console.log('Solicitante: ' + solicitante + '| QUANTIDADE: ' + itemProcesso.quantidade);
//                    console.log('| QUANTIDADE TOTAL: ' + quantidadeTotal);

                    itemAnterior = itemProcesso.itemId;
                });
            };

            var buscarSolicitantePedido = function (pedidoId) {
                var urlPedido = '../servlets/compras/ServletPedido.php';
                var parametros = {opcao: 'buscarPorId', id: pedidoId};
                var solicitante;
                requisicaoAjax(urlPedido, parametros, function (retorno) {
                    solicitante = retorno.dados.solicitante.nome;
                });
                return solicitante;
            };

            buscarPorId();
//            emitirOCS();
        </script>
    </head>
</html>
