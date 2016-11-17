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
        $nome = $senha = '';
        try {
            $conn = son\config\ConexaoBD::conectarBD();
            $usuario = new son\usuario\Usuario();

            if ($id && $_GET['excluir']) {
                $usuario->setId($id);
                $usuario->excluirUsuario($conn);
                header('location:listarUsuarios.php');
            }

            if ($id && !isset($_POST['post'])) {
                $usuario = $usuario->buscarUsuarioPorId($conn, $id);
            }

            if ($_POST['post']) {
                $usuario->setId($id);
                $usuario->setUsuario($_POST['nome']);
                $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
                $usuario->setSenha($senha);

                $usuario->persistirUsuario($conn, $usuario);
                header('location:listarUsuarios.php');
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        ?>
        <form method="POST" action="">
            <input type="hidden" name="post" value="1"/>
            <table border="1">
                <tbody>
                    <tr><td>Nome: <input type="text" name="nome" value="<?= $usuario->getUsuario() ?>"/></td></tr>
                    <tr><td>Senha: <input type="password" name="senha" value="<?= $usuario->getSenha() ?>"/></td></tr>
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
