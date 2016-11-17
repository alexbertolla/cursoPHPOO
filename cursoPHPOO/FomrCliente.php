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
        $id = $_GET['id'];
        $nome = $endereco = $telefone = $email = $importancia = '';
        try {
            $conn = son\config\ConexaoBD::conectarBD();
            $fixture = new son\fixture\Fixture($conn);

            if ($id && $_GET['excluir']) {
                $fixture->excluirCliente($id);
                header('location:listarCliente.php');
            }

            if ($id && !isset($_POST['post'])) {
                $cliente = $fixture->buscarClientePorId($id);
                $nome = $cliente->nome;
                $endereco = $cliente->endereco;
                $telefone = $cliente->telefone;
                $email = $cliente->email;
                $importancia = $cliente->grauImportancia;
            }

            if ($_POST['post']) {
                $nome = $_POST['nome'];
                $endereco = $_POST['endereco'];
                $telefone = $_POST['telefone'];
                $email = $_POST['email'];
                $importancia = $_POST['importancia'];
                $cliente = new son\cliente\types\ClientePF($id, $nome, $documento, $endereco, $telefone, $email, $importancia);
                $fixture->persist($cliente);
                header('location:listarCliente.php');
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        ?>
        <form method="POST" action="">
            <input type="hidden" name="post" value="1"/>
            <table border="1">
                <tbody>
                    <tr><td>Nome: <input type="text" name="nome" value="<?= $nome ?>"/></td></tr>
                    <tr><td>Endereço: <input type="text" name="endereco" value="<?= $endereco ?>"/></td></tr>
                    <tr><td>Telefone: <input type="text" name="telefone" value="<?= $telefone ?>"/></td></tr>
                    <tr><td>E-mail: <input type="text" name="email" value="<?= $email ?>"/></td></tr>
                    <tr><td>Importância: <input type="text" name="importancia" value="<?= $importancia ?>"/></td></tr>
                    <tr>
                        <td>
                            <button type="submit">Salvar</button>
                            <button type="reset">Cancelar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </body>
</html>
