<?php

include_once(__DIR__ . "/../connections/Connection.class.php");

class Meta_Usuario
{
    function relacionarMetaUsuario($idMeta, $idUsuario)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("INSERT INTO meta_usuario (fk_usuario, fk_meta) VALUES (:fk_usuario, :fk_meta)");
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

}
