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
            var url = '../servlets/cadastros/ServletMaterialConsumo.php';
            var materialConsumoGlobal;

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
                    materialConsumoGlobal = retorno.dados;
                    imprimirRetorno(retorno);
                });
            };

            var novoMaterialConsumo = function () {
                var parametros = {
                    opcao: 'inserir',
                    grupoId: 222,
                    almoxarifadoVirtualId: 1,
                    naturezaDespesaId: 8,
                    nome: 'teste',
                    descricao: 'teste cadastro material de consumo',
                    sustentavel: 0,
                    ativo: 1,
                    controlado: 0,
                    itemControladoId: null,
                    marca: 'marca',
                    modelo: 'modelo',
                    orgaoControladorId: null,
                    partNumber: '123456',
                    apresentacaoComercialId: null
                };
                requisicaoAjax(url, parametros, imprimirRetorno);
            };

            var alterarMaterialConsumo = function () {
                var parametros = {
                    opcao: 'alterar',
                    id: materialConsumoGlobal.id,
                    grupoId: materialConsumoGlobal.grupoId,
                    almoxarifadoVirtualId: materialConsumoGlobal.almoxarifadoVirtualId,
                    naturezaDespesaId: materialConsumoGlobal.naturezaDespesaId,
                    nome: 'teste material consumo',
                    descricao: materialConsumoGlobal.descricao,
                    sustentavel: materialConsumoGlobal.sustentavel,
                    ativo: materialConsumoGlobal.ativo,
                    controlado: materialConsumoGlobal.controlado,
                    itemControladoId: materialConsumoGlobal.itemControladoId,
                    marca: materialConsumoGlobal.marca,
                    modelo: materialConsumoGlobal.modelo,
                    orgaoControladorId: materialConsumoGlobal.orgaoControladorId,
                    partNumber: materialConsumoGlobal.partNumber,
                    apresentacaoComercialId: 2
                };
                requisicaoAjax(url, parametros, imprimirRetorno);
            };

            var excluir = function () {
                var parametros = {opcao: 'excluir', id: materialConsumoGlobal.id};
                requisicaoAjax(url, parametros, imprimirRetorno);
            };
//            listar();
//            buscarPorId(16409);
//            alterarMaterialConsumo();
//            excluir();
//            buscarPorId(16409);
//            novoMaterialConsumo();
//            
        </script>
    </head>
</html>
