<?php

include_once("../connection.php");


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
            header("Location:  ../../pages/login.php");
        } catch (PDOException $e) {
            $e->errorInfo;
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
                    $_SESSION['msg'] = "OPS... Não te encontramos no nosso sistema";
                    header("Location: ../../pages/login.php");
                } else {
                    $_SESSION['userEmail'] = $_POST['email'];
                    $_SESSION['userId'] = $stm->fetchColumn();
                    header("Location: ../../pages/dashboard.php");
                    exit();
                }
            } else {
                header("Location: ../../pages/login.php");
                exit();
            }
        } else {
            header("Location: ../../pages/login.php");
            exit();
        }
    }

    function logout()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        session_destroy();
        header("Location: ../../pages/login.php");
    }
}

if (isset($_POST['loginUser'])) {
    $usuario = new Usuario;
    $usuario->login();
}

if (isset($_POST['registerUser'])) {
    $usuario = new Usuario;
    $usuario->insertUsuario();
}

if (isset($_GET['logout'])) {
    $usuario = new Usuario;
    $usuario->logout();
}
