<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="../visao/js/jquery.js"></script>
        <script src="../visao/js/acaoFormularios.js"></script>
        <script>
            var url = '../servlets/webservices/ServletPA.php';

            var imprimirRetorno = function (retorno) {
                console.log(retorno);
                console.log(retorno.estado);
                console.log(retorno.mensagem);
                console.log(retorno.dados);
            };

                var ano = '2015';
                var parametros = {opcao: 'listarPA', ano: ano};
                console.log('############## Listar Saldo de todos os PAs ###################');
                console.log(parametros);
                requisicaoAjax(url, parametros, imprimirRetorno);

                parametros = {opcao: 'listarPA', ano: ano, parametro: '16004'};
                console.log(parametros);
                console.log('############## Listar Saldo dos PAs por codigo ###################');
                requisicaoAjax(url, parametros, imprimirRetorno);
                
                parametros = {opcao: 'listarPA', ano: ano, parametro: 'Despesas'};
                console.log(parametros);
                console.log('############## Listar Saldo dos PAs por titulo ###################');
                requisicaoAjax(url, parametros, imprimirRetorno);
                
                parametros = {opcao: 'listarPA', ano: ano, parametro: 'Gustavo'};
                console.log(parametros);
                console.log('############## Listar Saldo dos PAs por Responsavel ###################');
                requisicaoAjax(url, parametros, imprimirRetorno);
                
                parametros = {opcao: 'buscarPaPorId', ano: ano, id: 408};
                console.log(parametros);
                console.log('############## Buscar Saldo do PA por Id ###################');
                requisicaoAjax(url, parametros, imprimirRetorno);
        </script>
    </head>

</html>
