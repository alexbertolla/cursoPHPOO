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
            var url = '../servlets/cadastros/ServletObra.php';
            var obraGlobal;

            var imprimirRetorno = function (retorno) {
                console.log(retorno);
                console.log(retorno.estado);
                console.log(retorno.mensagem);
                console.log(retorno.dados);
            };

            var listar = function () {
                var parametros = {opcao: 'listar'};
                requisicaoAjax(url, parametros, imprimirRetorno);
            };

            var buscarPorId = function (id) {
                var parametros = {opcao: 'buscarPorId', id: id};
                requisicaoAjax(url, parametros, function (retorno) {
                    obraGlobal = retorno.dados;
                    imprimirRetorno(retorno);
                });
            };

            var novaObra = function () {
                var grupoId = 285;
                var almoxarifadoId = 4;
                var naturezaDespesaId = 22;
                var nome = 'teste';
                var descricao = 'teste cadastro de obras';
                var responsavel = '342990';
                var sustentavel = 0;
                var ativo = 1;
                parametros = {opcao: 'inserir', grupoId: grupoId,
                    almoxarifadoVirtualId: almoxarifadoId,
                    naturezaDespesaId: naturezaDespesaId, nome: nome, descricao: descricao,
                    responsavel: responsavel, sustentavel: sustentavel, ativo: ativo};
                requisicaoAjax(url, parametros, imprimirRetorno);
            };

            var alterarObra = function () {
                var parametros = {opcao: 'alterar', id:obraGlobal.id, grupoId: obraGlobal.grupoId,
                    almoxarifadoVirtualId: obraGlobal.almoxarifadoVirtualId,
                    naturezaDespesaId: obraGlobal.naturezaDespesaId, nome: 'teste123',
                    descricao: obraGlobal.descricao, responsavel: obraGlobal.responsavel,
                    sustentavel: obraGlobal.sustentavel, ativo:0};
                console.log(parametros);
                requisicaoAjax(url, parametros, imprimirRetorno);
            };
            listar();
//            buscarPorId(16406);
//            alterarObra();
//            novaObra();
//            
        </script>
    </head>
</html>
