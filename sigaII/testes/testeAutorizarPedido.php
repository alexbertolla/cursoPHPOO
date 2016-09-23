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
            var url = '../servlets/compras/ServletPedidoChefiaAutorizacao.php';

            var listarPedidoAutorizacao = function () {
                var parametros = {opcao: 'listarPedidos'}
                requisicaoAjax(url, parametros, function (retornoListar) {
                    console.log(retornoListar.estado);
                    console.log(retornoListar.mensagem);
                    console.log(retornoListar.dados);
                });
            };

            var receberPedido = function (pedidoId) {
                var parametros = {opcao: 'receberPedido', id: pedidoId};
                requisicaoAjax(url, parametros, function (retornoListar) {
                    console.log(retornoListar.estado);
                    console.log(retornoListar.mensagem);
                    console.log(retornoListar.dados);
                });
            };

            var devolverPedido = function (pedidoId) {
                var parametros = {opcao: 'devolverPedido', id: pedidoId};
                requisicaoAjax(url, parametros, function (retornoListar) {
                    console.log(retornoListar.estado);
                    console.log(retornoListar.mensagem);
                    console.log(retornoListar.dados);
                });
            };

            listarPedidoAutorizacao();
            receberPedido(8);
            devolverPedido(8);

        </script>
    </head>
    <body>
        <?php
        // put your code here
        ?>
    </body>
</html>
