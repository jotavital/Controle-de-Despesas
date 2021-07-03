<?php

include_once(__DIR__ . "/../connections/Connection.class.php");
include_once(__DIR__ . "/../connections/loginVerify.php");

class Notificacao
{

    function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    function pegarTodasNotificacoesUsuario($userId)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("SELECT * FROM notificacao WHERE fk_usuario_destino = :fk_usuario_destino AND lixo = 0");
        $stm->bindValue(":fk_usuario_destino", $userId);

        try {
            $stm->execute();
            $res = $stm->fetchAll();

            return $res;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function notificacaoConviteMeta($fk_usuario)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("INSERT INTO notificacao (fk_usuario) VALUES :fk_usuario");
        $stm->bindValue(":fk_usuario", $fk_usuario);

        try {
            $stm->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function marcarNotificacaoLida($idNotificacao)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("UPDATE notificacao SET foi_lida = 1 WHERE id = :idNotificacao");
        $stm->bindValue(":idNotificacao", $idNotificacao);

        try {
            $stm->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function excluirNotificacao($idNotificacao)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("UPDATE notificacao SET lixo = 1 WHERE id = :idNotificacao");
        $stm->bindValue(":idNotificacao", $idNotificacao);

        try {
            $stm->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

if (isset($_POST['notificacaoLida'])) {
    $notificacaoObj = new Notificacao;
    $notificacaoObj->marcarNotificacaoLida($_POST['idNotificacao']);
}

if (isset($_POST['notificacaoExcluida'])) {
    $notificacaoObj = new Notificacao;
    $notificacaoObj->excluirNotificacao($_POST['idNotificacao']);
}
