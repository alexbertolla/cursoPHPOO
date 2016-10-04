<?php

use son\cliente\types\ClientePF;
use son\cliente\types\ClienteEspecifico;

include_once './autoload.php';


include_once './arrayClientes.php';

//exit();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <script src="js/bootstrap.js"></script>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    </head>
    <body>
        <?php
        include_once './arrayClientes.php';

        $ordem = 'C';
        if (!isset($_GET['ordem']) || $_GET['ordem'] == 'C') {
            sort($listaCliente);
            $ordem = 'D';
        } else {
            rsort($listaCliente);
        }
        ?>
        <table border ='1' class="table table-hover table-bordered sortable">
            <tr>
                <td><a href="index.php?ordem=<?php echo $ordem ?>">Nome</a></td>
                <td>Tipo</td><td>Grau de importância</td>
            </tr>

            <?php
            foreach ($listaCliente as $cliente) {
                if ($cliente instanceof ClienteEspecifico) {
                    $enderecoCobranca = $cliente->getEnderecoCobranca();
                    $cliente = $cliente->getCliente();
                } else {
                    $enderecoCobranca = $cliente->getEndereco();
                }
                $tipo = ($cliente instanceof ClientePF) ? 'Pessoa Física' : 'Pessoa Jurídica';
                ?>
                <tr>
                    <td>
                        <a href="index.php?tipo=<?php echo $tipo ?>
                           &nome=<?php echo $cliente->getNome(); ?>
                           &cpf=<?php echo $cliente->getDocumento(); ?>
                           &endereco=<?php echo $cliente->getEndereco(); ?>
                           &telefone=<?php echo $cliente->getTelefone(); ?>
                           &email=<?php echo $cliente->getEmail(); ?>
                           &enderecoCobranca=<?php echo $enderecoCobranca ?>
                           &grauImportancia=<?php echo $cliente->getGrauImportancia() ?>">
                            <?php echo $cliente->getNome(); ?>
                        </a>
                    </td>
                    <td><?= $tipo ?></td>
                    <td><?= $cliente->getGrauImportancia() ?></td>
                    <td><?= $enderecoCobranca ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
        if ($_GET['nome']) {
            echo 'Tipo Cliente: ' . $_GET['tipo'] . '<br/>';
            echo 'Nome: ' . $_GET['nome'] . '<br/>';
            echo 'CPF: ' . $_GET['cpf'] . '<br/>';
            echo 'Endereço: ' . $_GET['endereco'] . '<br/>';
            echo 'Telefone: ' . $_GET['telefone'] . '<br/>';
            echo 'email: ' . $_GET['email'] . '<br/>';
            echo 'Endereço Cobrança: ' . $_GET['enderecoCobranca'] . '<br/>';
            echo 'Grau de importância: ' . $_GET['grauImportancia'] . '<br/>';
        }
        ?>
    </body>
</html>