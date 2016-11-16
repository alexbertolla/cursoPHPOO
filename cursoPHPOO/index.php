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
    </head>
    <body>
        <?php
        include_once './autoload.php';
        try {
            $conn = son\config\ConexaoBD::conectarBD();
            $fixture = new son\fixture\Fixture($conn);
            ?>
            <a href="FomrCliente.php">Novo Cliente</a>
            <table border="1" width="100%">
                <thead>
                    <tr><th>Nome</th><th>Endereço</th><th>Telefone</th><th>E-mail</th><th>Importância</th></tr>
                </thead>
                <?php
                $listaClientes = $fixture->listarClientes();
                foreach ($listaClientes as $cliente) {
                    ?>
                    <tbody>
                        <tr>
                            <td>
                                <a href="FomrCliente.php?id=<?= $cliente->id ?>"><?= $cliente->nome ?></a>
                            </td>
                            <td><?= $cliente->endereco ?></td>
                            <td><?= $cliente->telefone ?></td>
                            <td><?= $cliente->email ?></td>
                            <td><?= $cliente->grauImportancia ?></td>
                            <td><a href="FomrCliente.php?id=<?= $cliente->id ?>&excluir=excluir">Excluir</a></td>
                        </tr>
                    </tbody>
                    <?php
                }
                ?>
            </table>
            <?php
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        ?>
    </body>
</html>
