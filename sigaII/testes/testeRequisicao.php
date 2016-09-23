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
            var url = '../servlets/almoxarifado/ServletRequisicaoMaterial.php';
            var matriculaRequisitante = '327087';
            var paId = '222';
            var ano = '2016';
            var lotacaoId = '40';
            var listaItemRequisicao = [];

            var requisicaoGlobal;

            var gerarListaItens = function () {
                var addItem = function (requisicaoId, itemEstoqueId, itemId, quantidade, valorUnitario) {
                    listaItemRequisicao.push({requisicaoId: requisicaoId, itemEstoqueId: itemEstoqueId, itemId: itemId, quantidade: quantidade,
                        valorUnitario: valorUnitario, valorTotal: valorUnitario * quantidade});
                };

                addItem(null, 1, 185, 3, 35.6);
                addItem(null, 6, 190, 7, 50.00);
                addItem(null, 9, 193, 2, 78.50);
                addItem(null, 10, 194, 1, 5.69);
                addItem(null, 3, 189, 10, 15.64);
            };

            var listarPorRequisitante = function (matriculaRequisitante) {
                console.log("############# LISTAR REQUISIÇÃO POR REQUISITANTE ##############");
                var parametrosListaPorRequisitante = {opcao: 'listarPorRequisitante', matriculaRequisitante: matriculaRequisitante};
                requisicaoAjax(url, parametrosListaPorRequisitante, function (retornoLista) {
                    console.log(retornoLista.estado);
                    console.log(retornoLista.mensagem);
                    $(retornoLista.dados).each(function () {
                        var requisicao = $(this)[0];
                        console.log(requisicao);
                    });
                });
            };

            var buscarRequisicaoPorId = function () {
                console.log("############# BUSCAR REQUISIÇÃO POR ID ##############");
                var parametros = {
                    opcao: 'buscarPorId', id: 1
                };
                requisicaoAjax(url, parametros, function (retornoBuscarPorId) {
                    console.log(retornoBuscarPorId);
                    console.log(retornoBuscarPorId.estado);
                    console.log(retornoBuscarPorId.mensagem);
                    console.log(retornoBuscarPorId.dados);
                    requisicaoGlobal = retornoBuscarPorId.dados;
                });
            };

            var novaRequisicao = function () {
                console.log("############# INSERIR NOVA REQUISIÇÃO ##############");
                gerarListaItens();

                var parametros = {
                    opcao: 'inserir', matriculaRequisitante: matriculaRequisitante,
                    paId: paId, ano: ano, lotacaoId: lotacaoId, listaItemRequisicao: listaItemRequisicao
                };

                requisicaoAjax(url, parametros, function (retornoInserir) {
                    console.log(retornoInserir.estado);
                    console.log(retornoInserir.mensagem);
                    console.log(retornoInserir.dados);
                    requisicaoGlobal = retornoInserir.dados;
                });

            };


            var alterarRequisicao = function () {
                console.log("############# ALTERAR REQUISIÇÃO ##############");
                var id = 1;
                var paId = '221';
                var lotacaoId = '13';

                gerarListaItens();

                var parametros = {
                    opcao: 'alterar', id: id, matriculaRequisitante: matriculaRequisitante,
                    paId: paId, ano: ano, lotacaoId: lotacaoId, listaItemRequisicao:listaItemRequisicao
                };

                console.log(parametros);

                requisicaoAjax(url, parametros, function (retornoAlterar) {
                    console.log(retornoAlterar.estado);
                    console.log(retornoAlterar.mensagem);
                    console.log(retornoAlterar.dados);
                });
            };


            var enviarRequisicao = function (requisicao) {
                console.log("############# ENVIAR REQUISIÇÃO ##############");
                parametros = {opcao: 'enviarRequisicao', id: requisicao.id};
                requisicaoAjax(url, parametros, function (retornoEnvio) {
                    console.log(retornoEnvio.estado);
                    console.log(retornoEnvio.mensagem);
                    console.log(retornoEnvio.dados);
                });
            };

            var receberRequisicao = function (requisicao) {
                console.log("############# RECEBER REQUISIÇÃO ##############");
                parametros = {opcao: 'receberRequisicao', id: requisicao.id, matriculaResponsavel: '327087'};
                requisicaoAjax(url, parametros, function (retornoRecebimento) {
                    console.log(retornoRecebimento.estado);
                    console.log(retornoRecebimento.mensagem);
                    console.log(retornoRecebimento.dados);
                });
            };

            var devolverRequisicao = function (requisicao) {
                console.log("############# DEVOLVER REQUISIÇÃO ##############");
                parametros = {opcao: 'devolverRequisicao', id: requisicao.id, matriculaResponsavel: '327087'};
                requisicaoAjax(url, parametros, function (retornoDevolver) {
                    console.log(retornoDevolver.estado);
                    console.log(retornoDevolver.mensagem);
                    console.log(retornoDevolver.dados);
                });
            };

            var atenderRequisicao = function (requisicao) {
                console.log("############# ATENDER ENTREGAR REQUISIÇÃO ##############");
                parametros = {opcao: 'atenderEntregar', id: requisicao.id, matriculaResponsavel: '327087'};
                requisicaoAjax(url, parametros, function (retornoAtendimento) {
                    console.log(retornoAtendimento.estado);
                    console.log(retornoAtendimento.mensagem);
                    console.log(retornoAtendimento.dados);
                });
            };

            var encerrarRequisicao = function (requisicao) {
                console.log("############# ENCERRAR REQUISIÇÃO ##############");
                parametros = {opcao: 'encerrar', id: requisicao.id, matriculaResponsavel: '327087'};
                requisicaoAjax(url, parametros, function (retornoEncerrar) {
                    console.log(retornoEncerrar.estado);
                    console.log(retornoEncerrar.mensagem);
                    console.log(retornoEncerrar.dados);
                });
            };


//            novaRequisicao();
            buscarRequisicaoPorId();
//            alterarRequisicao();
//            listarPorRequisitante('327087');

//            enviarRequisicao(requisicaoGlobal);
//            receberRequisicao(requisicaoGlobal);
//            devolverRequisicao(requisicaoGlobal);
//            atenderRequisicao(requisicaoGlobal);
//            encerrarRequisicao(requisicaoGlobal);
        </script>


    </head>
    <body>
    </body>
</html>
