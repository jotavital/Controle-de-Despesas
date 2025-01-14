<?php

include_once(__DIR__ . "/../connections/Connection.class.php");
include_once(__DIR__ . "/../classes/Despesa.class.php");
include_once(__DIR__ . "/../classes/Receita.class.php");
include_once(__DIR__ . "/../classes/Conta.class.php");
include_once(__DIR__ . "/../classes/Categoria.class.php");
include_once(__DIR__ . "/../classes/Notificacao.class.php");
include_once(__DIR__ . "/../classes/Meta_Usuario.class.php");

class Usuario
{

    function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    function verificaSeExisteUsuario($userId)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("SELECT id FROM usuario WHERE id = :userId");
        $stm->bindValue(":userId", $userId);

        $stm->execute();
        $res = $stm->fetch();

        if ($res != null) {
            return true;
        } else {
            return false;
        }
    }

    function selectFromUsuario($campos = "", $condicao = "")
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        if ($campos == '') {
            $campos = '*';
        }

        if ($condicao != '') {
            $sql = "SELECT " . $campos .  " FROM usuario WHERE " . $condicao . "";
        } else {
            $sql = "SELECT " . $campos .  " FROM usuario ";
        }

        $stm = $conexao->prepare($sql);

        try {
            $stm->execute();

            $result = $stm->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

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
        session_destroy();
        header("Location: ../pages/login.php");
    }

    function updateNomeSobrenome($novoNome, $novoSobrenome)
    {
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

        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("DELETE FROM usuario WHERE usuario.id = :userId");
        $stm->bindValue(":userId", $_SESSION['userId']);

        try {
            $receita = new Receita;
            $despesa = new Despesa;
            $conta = new Conta;
            $categoria = new Categoria;
            $notificacaoObj = new Notificacao;
            $metaUsuarioObj = new Meta_Usuario;

            $receita->deletarTodasReceitasUsuario();
            $despesa->deletarTodasDespesasUsuario();
            $conta->deletarTodasContasUsuario();
            $categoria->deletarTodasCategoriasUsuario();
            $notificacaoObj->deletarTodasNotificacoesUsuario();
            $metaUsuarioObj->desvincularTodasMetasUsuario();

            $stm->execute();
            echo "Usuário deletado com sucesso!";
            session_destroy();
        } catch (PDOException $e) {
            echo "Erro ao deletar usuário: " . $e->getMessage();
        }
    }

    function verificarEmail($email)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("SELECT count(email) as existeEmail FROM usuario WHERE email = :email");
        $stm->bindValue(":email", $email);

        try {
            $stm->execute();

            $result = $stm->fetch(PDO::FETCH_ASSOC);

            if ($result['existeEmail'] == "1") {
                echo 1;
            } else {
                echo 0;
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    function trocarFotoPerfil()
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $nomeImg = $_FILES['imgInput']['name'];

        $nomeImgAntiga = $this->selectFromUsuario("imagem_perfil", "id = " . $_SESSION['userId'])[0][0];
        $directoryImgAntiga = '../uploaded/user_images/fotos_perfil/' . $_SESSION['userId'] . '/' . $nomeImgAntiga;

        try {
            $stm = $conexao->prepare("UPDATE usuario SET imagem_perfil = :imagem_perfil WHERE usuario.id = :userId");
            $stm->bindValue(":imagem_perfil", $nomeImg);
            $stm->bindValue(":userId", $_SESSION['userId']);

            if ($nomeImg != null) {
                $directory = '../uploaded/user_images/fotos_perfil/' . $_SESSION['userId'] . '/';

                if (!file_exists($directory)) {
                    mkdir($directory, 0777);
                }

                if (copy($_FILES['imgInput']['tmp_name'], $directory . $nomeImg)) {
                    $stm->execute();

                    if ($nomeImgAntiga != null) {
                        if (file_exists($directoryImgAntiga)) {
                            unlink($directoryImgAntiga);
                        }
                    }
                } else {
                    throw new PDOException;
                }
            }

            echo "Foto de perfil alterada com sucesso! ";
        } catch (PDOException $e) {
            echo "Erro ao alterar foto de perfil! " . $e->getMessage();
        }
    }

    function getProfilePicturePath(){
        $conn = new Connection;
        $conexao = $conn->conectar();

        $nomeImg = $this->selectFromUsuario("imagem_perfil", "id = " . $_SESSION['userId'])[0][0];
        $directoryImgAntiga = '../uploaded/user_images/fotos_perfil/' . $_SESSION['userId'] . '/' . $nomeImg;

        if($nomeImg != null){
            return $directoryImgAntiga;
        }else{
            return null;
        }
    }
}

if (isset($_POST['loginUser'])) {
    $usuario = new Usuario;
    $usuario->login();
}

if (isset($_POST['email'])) {
    $usuario = new Usuario;
    $usuario->verificarEmail($_POST['email']);
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

if (isset($_POST['trocarFotoPerfil'])) {
    $usuario = new Usuario;
    $usuario->trocarFotoPerfil();
}
