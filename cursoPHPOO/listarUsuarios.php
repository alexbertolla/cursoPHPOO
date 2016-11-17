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
            $usuario = new son\usuario\Usuario();
            $listaUsuarios = $usuario->listarUsuario($conn);
            ?>
            <a href="FomrUsuario.php">Novo Usuario</a>
            <table border="1" width="100%">
                <thead>
                    <tr><th>Nome</th></tr>
                </thead>
                <?php
                foreach ($listaUsuarios as $usuario) {
                    ?>
                    <tbody>
                        <tr>
                            <td>
                                <?= $usuario->getUsuario()?>
                            </td>
                            <td>
                                <a href="FomrUsuario.php?id=<?= $usuario->getId() ?>&alterar=alterar">Alterar</a>
                                <a href="FomrUsuario.php?id=<?= $usuario->getId() ?>&excluir=excluir">Excluir</a>
                            </td>
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
