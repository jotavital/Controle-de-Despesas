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
}
