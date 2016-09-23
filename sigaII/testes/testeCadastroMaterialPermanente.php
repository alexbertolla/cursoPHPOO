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
            var url = '../servlets/cadastros/ServletMaterialPermanente.php';
            var materialPermanenteGlobal;

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
                    materialPermanenteGlobal = retorno.dados;
                    imprimirRetorno(retorno);
                });
            };

            var novoMaterialPermanente = function () {
                var parametros = {
                    opcao: 'inserir',
                    grupoId: 1,
                    almoxarifadoVirtualId: 2,
                    naturezaDespesaId: 23,
                    nome: 'teste',
                    descricao: 'teste cadastro material permanente',
                    sustentavel: 0,
                    situacao: 1,


                    marca: 'marca',
                    modelo: 'modelo',

                    partNumber: '123456',

                };
                requisicaoAjax(url, parametros, imprimirRetorno);
            };

            var alterarMaterialPermanente = function () {
                var parametros = {
                    opcao: 'alterar',
                    id: materialPermanenteGlobal.id,
                    grupoId: materialPermanenteGlobal.grupoId,
                    almoxarifadoVirtualId: materialPermanenteGlobal.almoxarifadoVirtualId,
                    naturezaDespesaId: materialPermanenteGlobal.naturezaDespesaId,
                    nome: 'teste cadastro material Permanente',
                    descricao: materialPermanenteGlobal.descricao,
                    sustentavel: materialPermanenteGlobal.sustentavel,
                    situacao: materialPermanenteGlobal.situacao,
                    
                    
                    marca: materialPermanenteGlobal.marca,
                    modelo: materialPermanenteGlobal.modelo,
                    
                    partNumber: materialPermanenteGlobal.partNumber,
                    
                };
                requisicaoAjax(url, parametros, imprimirRetorno);
            };

            var excluir = function () {
                var parametros = {opcao: 'excluir', id: materialPermanenteGlobal.id};
                requisicaoAjax(url, parametros, imprimirRetorno);
            };
//            listar();
//            buscarPorId(16410);
//            alterarMaterialPermanente();
//            excluir();
//            buscarPorId(16410);
//            novoMaterialPermanente();
//            
        </script>
    </head>
</html>
