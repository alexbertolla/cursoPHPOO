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
            var pedidoGlobal;

            var listaItemPedido = [];
            var url = '../servlets/compras/ServletPedido.php';
            var urlItemPedido = '../servlets/compras/ServletItemPedido.php';

            var imprimirRetorno = function (retorno) {
                console.log(retorno);
                console.log(retorno.estado);
                console.log(retorno.mensagem);
                console.log(retorno.dados);
            };



            var incluirItemPedido = function (item, quantidade, pedidoId) {
                listaItemPedido.push({
                    pedidoId: pedidoId, itemId: item.id, grupoId: item.grupoId,
                    naturezaDespesaId: item.naturezaDespesaId, quantidade: quantidade,
                });
            };

            var gerarListaItemPedido = function () {
                var item1 = {id: '1', grupoId: '222', naturezaDespesaId: '8'};
                var item2 = {id: '2', grupoId: '222', naturezaDespesaId: '8'};
                var item3 = {id: '3', grupoId: '222', naturezaDespesaId: '8'};
                incluirItemPedido(item1, '10', pedidoGlobal.id);
                incluirItemPedido(item2, '46', pedidoGlobal.id);
                incluirItemPedido(item3, '7', pedidoGlobal.id);
            };

            var buscarPedidoPorId = function (id) {
                console.log('############### BUSCAR POR ID PEDIDO DE COMPRA ################');
                var parametros = {opcao: 'buscarPorId', id: id};
                requisicaoAjax(url, parametros, function (retornoBuscarPorId) {
                    pedidoGlobal = retornoBuscarPorId.dados;
                    imprimirRetorno(retornoBuscarPorId);
                });
            };

            var novoPedido = function () {
                console.log('############### NOVO PEDIDO DE COMPRA ################');
                var matriculaSolicitante = '342990';
                var paId = 222;
                var lotacaoId = 40;
                var justificativa = 'teste cadastro solicitacao de compra';
                var grupoId = 222;
                var naturezaDespesaId = 8;
                var ano = '2016';
                var tipo = 'materialConsumo';


                var parametros = {
                    opcao: 'inserir', matriculaSolicitante: matriculaSolicitante,
                    paId: paId, lotacaoId: lotacaoId, justificativa: justificativa,
                    grupoId: grupoId, naturezaDespesaId: naturezaDespesaId,
                    ano: ano, tipo: tipo
                };

                console.log(parametros);
                requisicaoAjax(url, parametros, imprimirRetorno);
            };

            var alterarPedido = function () {
                console.log('############### ALTERAR PEDIDO DE COMPRA ################');
                var parametros = {
                    opcao: 'alterar', id: pedidoGlobal.id, matriculaSolicitante: pedidoGlobal.matriculaSolicitante,
                    paId: pedidoGlobal.paId, lotacaoId: pedidoGlobal.lotacaoId, justificativa: pedidoGlobal.justificativa,
                    grupoId: pedidoGlobal.grupoId, naturezaDespesaId: pedidoGlobal.naturezaDespesaId,
                    ano: pedidoGlobal.ano, tipo: pedidoGlobal.tipo
                };

                console.log(parametros);
                requisicaoAjax(url, parametros, imprimirRetorno);
            };

            var salvarItemPedido = function () {
                console.log('############### INSERIR ITEM NO PEDIDO DE COMPRA ################');
                gerarListaItemPedido();
                var opcao = "inserir";
                var tipo = 'materialConsumo';
                var pedidoId = pedidoGlobal.id;
                var parametro = {opcao: opcao, listaItemPedido: listaItemPedido, tipo: tipo, pedidoId: pedidoId};

                requisicaoAjax(urlItemPedido, parametro, imprimirRetorno);
            };

            var encaminharParaChefia = function () {
                console.log('############### ENCAMINHAR PEDIDO DE COMPRA ################');
                var parametros = {
                    opcao: 'encaminharParaChefia', id: pedidoGlobal.id, matriulaResponsavel: pedidoGlobal.matriculaSolicitante
                };

                requisicaoAjax(url, parametros, imprimirRetorno);
            };

            var receberPedidoChefia = function () {
                console.log('############### CHEFIA - RECEBER PEDIDO DE COMPRA ################');
                var urlChefia = '../servlets/compras/ServletPedidoChefiaAutorizacao.php';
                var parametros = {
                    opcao: 'receberPedido', id: pedidoGlobal.id, matriculaResponsavel: pedidoGlobal.matriculaSolicitante
                };
                requisicaoAjax(urlChefia, parametros, imprimirRetorno);
            };

            var devolverPedidoChefia = function () {
                console.log('############### CHEFIA - DEVOLVER PEDIDO DE COMPRA ################');
                var urlChefia = '../servlets/compras/ServletPedidoChefiaAutorizacao.php';
                var parametros = {
                    opcao: 'devolverPedido', id: pedidoGlobal.id, matriculaResponsavel: pedidoGlobal.matriculaSolicitante
                };
                requisicaoAjax(urlChefia, parametros, imprimirRetorno);
            };

            var autorizarPedidoChefia = function (autorizado, justificativa) {
                console.log('############### CHEFIA - AUTORIZAR PEDIDO DE COMPRA ################');
                var urlChefia = '../servlets/compras/ServletPedidoChefiaAutorizacao.php';
                var parametros = {
                    opcao: 'autorizarPedido', id: pedidoGlobal.id,
                    matriculaResponsavel: pedidoGlobal.matriculaSolicitante,
                    justificativa: justificativa, autorizado: autorizado
                };
                requisicaoAjax(urlChefia, parametros, imprimirRetorno);
            };

            var receberPedidoSPS = function () {
                console.log('############### CHEFIA - RECEBER PEDIDO DE COMPRA ################');
                var urlChefia = '../servlets/compras/ServletPedidoSPS.php';
                var parametros = {
                    opcao: 'receberPedido', id: pedidoGlobal.id, matriculaResponsavel: pedidoGlobal.matriculaSolicitante
                };
                requisicaoAjax(urlChefia, parametros, imprimirRetorno);
            };

            var listarPorSolicitante = function (matriculaSolicitante) {
                var parametro = {opcao: "listarPorSolicitante", matriculaSolicitante: matriculaSolicitante};
                requisicaoAjax(url, parametro, function (retornoListaPedidos) {
                    console.log(retornoListaPedidos.estado);
                    console.log(retornoListaPedidos.mensagem);
                    console.log(retornoListaPedidos.dados);
                });
            };
//            listarPorSolicitante('327087');
//            novoPedido();
            buscarPedidoPorId(7);
//            alterarPedido();
//            salvarItemPedido();
//            encaminharParaChefia();
//            receberPedidoChefia();
//            devolverPedidoChefia();
//            autorizarPedidoChefia(1,'TESTE AUTORIZACAO - AUTOTIZADO');
//            autorizarPedidoChefia(0,'TESTE AUTORIZACAO - NAO AUTOTIZADO');
//            receberPedidoSPS();
        </script>

</html>
