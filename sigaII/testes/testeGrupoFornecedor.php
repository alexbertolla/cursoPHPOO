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
            var url = '../servlets/cadastros/ServletGrupo.php';

            var salvarGrupoFornecedor = function () {
                var grupoId = [];
                grupoId.push(32);
                grupoId.push(33);
                grupoId.push(27);
                grupoId.push(28);
                grupoId.push(29);
                grupoId.push(30);
                var parametros = {opcao: 'salvarGrupoFornecedor', grupoId: grupoId, fornecedorId: 16}
                requisicaoAjax(url, parametros, function (retornoListar) {
                    console.log(retornoListar.estado);
                    console.log(retornoListar.mensagem);
                    console.log(retornoListar.dados);
                });
            };



            salvarGrupoFornecedor();

        </script>
    </head>
    <body>
        <?php
        // put your code here
        ?>
    </body>
</html>
