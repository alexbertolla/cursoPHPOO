<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <script src="../visao/js/jquery.js"></script>
        <script src="../visao/js/acaoFormularios.js"></script>
        <script>
            var url = '../servlets/compras/ServletProcessoCompra.php';
            var processoCompraGlobal;
            var listaItemPedido = [];

            var gerarListaItemPedido = function () {
                listaItemPedido.push({pedidoId: 1, itemId: 1, situacaoId: 4, quantidade: 10});
                listaItemPedido.push({pedidoId: 1, itemId: 2, situacaoId: 4, quantidade: 46});
                listaItemPedido.push({pedidoId: 1, itemId: 3, situacaoId: 4, quantidade: 7});

            };

            var imprimirRetorno = function (retorno) {
                console.log(retorno);
                console.log(retorno.estado);
                console.log(retorno.mensagem);
                console.log(retorno.dados);
            };

            var buscarPorId = function (id) {
                console.log('############### BUSCAR PROCESSO DE COMPRA POR ID ################');
                var parametros = {opcao: 'buscarPorId', id: id};
                requisicaoAjax(url, parametros, function (retornoBuscarPorId) {
                    processoCompraGlobal = retornoBuscarPorId.dados;
                    imprimirRetorno(retornoBuscarPorId);
                });
            };

            var novoProcessoDeCompra = function () {
                console.log('############### NOVO PROCESSO DE COMPRA ################');
                var numero = '123456789', modalidadeId = '9',
                        numeroModalidade = '0001/20016',
                        responsavel = '342990', objeto = 'TESTE',
                        justificativa = 'TESTE PROCESSO DE COMPRAS';

                var parametros = {
                    opcao: 'inserir', numero: numero, modalidadeId: modalidadeId,
                    numeroModalidade: numeroModalidade, responsavel: responsavel,
                    objeto: objeto, justificativa: justificativa};
                requisicaoAjax(url, parametros, imprimirRetorno);
            };

            var salvarListaItemProcessoCompra = function () {
                console.log('############### SALVAR ITENS PROCESSO DE COMPRA ################');
                var urlItemProcessoCompra = '../servlets/compras/ServletItemProcessoCompra.php';
                gerarListaItemPedido();
                console.log(listaItemPedido);
                $(listaItemPedido).each(function () {
                    var itemPedido = $(this)[0];
                    var parametros = {
                        opcao: 'inserir', loteId: 1, processoCompraId: 1,
                        pedidoId: itemPedido.pedidoId, grupoId: itemPedido.grupoId,
                        itemId: itemPedido.itemId
                    };
                    requisicaoAjax(urlItemProcessoCompra, parametros, imprimirRetorno);
                });

            };

            var encaminhamentoProcessoCompra = function (encaminhamento) {
                console.log('############### [' + encaminhamento + '] PROCESSO DE COMPRA ################');
                var parametros = {
                    opcao: encaminhamento, id: processoCompraGlobal.id, bloqueado: 1};
                requisicaoAjax(url, parametros, imprimirRetorno);
            };

//            novoProcessoDeCompra();
            buscarPorId(1);
//            salvarListaItemProcessoCompra();
//            encaminhamentoProcessoCompra('bloquear');

            //            encaminhamentoProcessoCompra('encerrar');
            encaminhamentoProcessoCompra('consolidar');

        </script>
    </head>
</html>
