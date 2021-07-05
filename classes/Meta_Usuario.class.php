<?php

include_once(__DIR__ . "/../connections/Connection.class.php");

class Meta_Usuario
{

    function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    function relacionarMetaUsuario($idMeta, $idUsuario)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("INSERT IGNORE INTO meta_usuario (fk_usuario, fk_meta) VALUES (:fk_usuario, :fk_meta)");
        $stm->bindValue(':fk_usuario', $idUsuario);
        $stm->bindValue(':fk_meta', $idMeta);

        try {
            $stm->execute();
        } catch (PDOException $th) {
            echo $th->getMessage();
        }
    }

    function desvincularMetaUsuario($idMeta, $idUsuario)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("DELETE FROM meta_usuario WHERE fk_usuario = :fk_usuario AND fk_meta = :fk_meta");
        $stm->bindValue(':fk_usuario', $idUsuario);
        $stm->bindValue(':fk_meta', $idMeta);

        try {
            $stm->execute();
        } catch (PDOException $th) {
            echo $th->getMessage();
        }
    }

    function desvincularTodasMetasUsuario(){
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("DELETE FROM meta_usuario WHERE fk_usuario = :userId");
        $stm->bindValue(":userId", $_SESSION['userId']);

        try {
            $stm->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}

if (isset($_POST['aceitarConviteMeta'])) {
    $metaUsuarioObj = new Meta_Usuario;
    $metaUsuarioObj->relacionarMetaUsuario($_POST['idMeta'], $_SESSION['userId']);
}
