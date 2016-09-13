<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <script src="js/bootstrap.js"></script>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    </head>
    <body>
        <?php include_once './arrayClientes.php'; ?>
        <table border ='1' class="table table-hover table-bordered sortable">
            <tr>
                <td>Nome</td>
            </tr>

            <?php
            foreach ($listaCliente as $cliente) {
                ?>
                <tr>
                    <td>
                        <a href="listaClientes.php?nome=<?php echo $cliente->nome; ?>&cpf=<?php echo $cliente->cpf; ?>&endereco=<?php echo $cliente->endereco; ?>&telefone=<?php echo $cliente->telefone; ?>&email=<?php echo $cliente->email; ?>">
                            <?php echo $cliente->nome; ?>
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
        if ($_GET) {
            echo 'Nome: ' . $_GET['nome'] . '<br/>';
            echo 'CPF: ' . $_GET['cpf'] . '<br/>';
            echo 'Endereço: ' . $_GET['endereco'] . '<br/>';
            echo 'Telefone: ' . $_GET['telefone'] . '<br/>';
            echo 'email: ' . $_GET['email'] . '<br/>';
        }
        ?>
    </body>
</html>
