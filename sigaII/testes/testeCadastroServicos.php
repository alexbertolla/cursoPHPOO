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
            var url = '../servlets/cadastros/ServletServico.php';
            var servicoGlobal;

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
                    servicoGlobal = retorno.dados;
                    imprimirRetorno(retorno);
                });
            };

            var novoServico = function () {
                var grupoId = 35;
                var almoxarifadoId = 3;
                var naturezaDespesaId = 4;
                var nome = 'teste serviço';
                var descricao = 'teste cadastro de servicos';
                var ativo = 1;
                parametros = {opcao: 'inserir', grupoId: grupoId,
                    almoxarifadoVirtualId: almoxarifadoId,
                    naturezaDespesaId: naturezaDespesaId, nome: nome, descricao: descricao,
                    ativo: ativo};
                requisicaoAjax(url, parametros, imprimirRetorno);
            };

            var alterarServico = function () {
                var parametros = {opcao: 'alterar', id: servicoGlobal.id, grupoId: servicoGlobal.grupoId,
                    almoxarifadoVirtualId: servicoGlobal.almoxarifadoVirtualId,
                    naturezaDespesaId: servicoGlobal.naturezaDespesaId, nome: 'teste novo servico',
                    descricao: servicoGlobal.descricao,
                    ativo: 0};
                console.log(parametros);
                requisicaoAjax(url, parametros, imprimirRetorno);
            };
            listar();
//            buscarPorId(16408);
//            alterarServico();
//            novoServico();
//            buscarPorId(16408);
        </script>
    </head>
</html>
