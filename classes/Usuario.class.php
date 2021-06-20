<?php

include_once(__DIR__ . "/../connections/Connection.class.php");
include_once(__DIR__ . "/../classes/Despesa.class.php");
include_once(__DIR__ . "/../classes/Receita.class.php");
include_once(__DIR__ . "/../classes/Conta.class.php");
include_once(__DIR__ . "/../classes/Categoria.class.php");

class Usuario
{

    function insertUsuario()
    {
        $conn = new Connection;
        $conexao = $conn->conectar();
        $stm = $conexao->prepare("INSERT INTO usuario(nome, sobrenome, email, senha, data_cadastro) VALUES (:name, :surname, :email, :password, :data_cadastro)");
        $stm->bindValue(":name", $_POST['name']);
        $stm->bindValue(":surname", $_POST['surname']);
        $stm->bindValue(":email", $_POST['email']);
        $stm->bindValue(":password", md5($_POST['password']));
        $stm->bindValue(":data_cadastro", date('Y' . '-' . 'm' . '-' . 'd'));

        try {
            $stm->execute();
            header("Location:  ../pages/login.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $conn->desconectar();
    }

    function login()
    {

        if (!isset($_SESSION)) {
            session_start();
        }

        $conn = new Connection;
        $conexao = $conn->conectar();

        if (isset($_POST['email']) && isset($_POST['password'])) {
            $stm = $conexao->prepare("SELECT * FROM `usuario` WHERE email= :email AND senha = :password");
            $stm->bindValue(":email", $_POST['email']);
            $stm->bindValue(":password", md5($_POST['password']));

            if ($stm->execute()) {
                if ($stm->rowCount() == 0) {
                    $_SESSION['msg'] = "OPS... E-mail ou senha incorretos";
                    header("Location: ../../pages/login.php");
                } else {
                    $_SESSION['userEmail'] = $_POST['email'];
                    $_SESSION['userId'] = $stm->fetchColumn();
                    header("Location: ../pages/dashboard.php");
                    exit();
                }
            } else {
                header("Location: ../pages/login.php");
                exit();
            }
        } else {
            header("Location: ../pages/login.php");
            exit();
        }
    }

    function logout()
    {

        if (!isset($_SESSION)) {
            session_start();
        }
        session_destroy();
        header("Location: ../pages/login.php");
    }

    function updateNomeSobrenome($novoNome, $novoSobrenome)
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("UPDATE usuario SET nome = :novoNome, sobrenome = :novoSobrenome WHERE usuario.id = :userId");
        $stm->bindValue(":novoNome", $novoNome);
        $stm->bindValue(":novoSobrenome", $novoSobrenome);
        $stm->bindValue(":userId", $_SESSION['userId']);

        try {
            $stm->execute();
            header("Location: ../pages/profile.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function updateSenha($senhaAtual, $novaSenha)
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("SELECT senha FROM usuario WHERE usuario.id = :userId AND usuario.senha = md5(:senhaAtual)");
        $stm->bindValue(":userId", $_SESSION['userId']);
        $stm->bindValue(":senhaAtual", $senhaAtual);

        try {
            $stm->execute();
            $result = $stm->fetch();

            if ($result != null) {

                if ($result[0] == md5($novaSenha)) {
                    $e = new Exception("A nova senha não deve ser igual à antiga");
                    echo $e->getMessage();
                    return false;
                } else {
                    $stm2 = $conexao->prepare("UPDATE usuario SET senha = md5(:novaSenha) WHERE usuario.id = :userId");
                    $stm2->bindValue(":novaSenha", $novaSenha);
                    $stm2->bindValue(":userId", $_SESSION['userId']);

                    try {
                        $stm2->execute();
                        echo "Senha alterada com sucesso!";
                        session_destroy();
                    } catch (PDOException $e) {
                        echo "Erro ao alterar senha: " . $e->getMessage();
                    }
                }
            } else {
                $e = new Exception("A senha atual está incorreta");
                echo $e->getMessage();
                return false;
            }
        } catch (PDOException $e) {
            echo "Erro ao alterar senha: " . $e->getMessage();
        }
    }

    function deleteUsuario()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("DELETE FROM usuario WHERE usuario.id = :userId");
        $stm->bindValue(":userId", $_SESSION['userId']);

        try {
            $receita = new Receita;
            $despesa = new Despesa;
            $conta = new Conta;
            $categoria = new Categoria;

            $receita->deletarTodasReceitasUsuario();
            $despesa->deletarTodasDespesasUsuario();
            $conta->deletarTodasContasUsuario();
            $categoria->deletarTodasCategoriasUsuario();

            $stm->execute();
            echo "Usuário deletado com sucesso!";
            session_destroy();
        } catch (PDOException $e) {
            echo "Erro ao deletar usuário: " . $e->getMessage();
        }
    }
}

if (isset($_POST['loginUser'])) {
    $usuario = new Usuario;
    $usuario->login();
}

if (isset($_POST['deleteUsuario'])) {
    $usuario = new Usuario;
    $usuario->deleteUsuario();
}

if (isset($_POST['editSenha'])) {
    $usuario = new Usuario;
    $usuario->updateSenha($_POST['inputSenhaAtual'], $_POST['inputNovaSenha']);
}

if (isset($_POST['registerUser'])) {
    $usuario = new Usuario;
    $usuario->insertUsuario();
}

if (isset($_GET['logout'])) {
    $usuario = new Usuario;
    $usuario->logout();
}

if (isset($_POST['editNomeSobrenome'])) {
    $usuario = new Usuario;
    $usuario->updateNomeSobrenome($_POST['inputNovoNome'], $_POST['inputNovoSobrenome']);
}
