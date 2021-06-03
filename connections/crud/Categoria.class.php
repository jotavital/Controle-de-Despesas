<?php

include_once(__DIR__ . "/../Connection.class.php");

class Categoria{

    function deletarTodasCategoriasUsuario(){
        if (!isset($_SESSION)) {
            session_start();
        }

        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("DELETE FROM categoria WHERE fk_usuario = :userId");
        $stm->bindValue(":userId", $_SESSION['userId']);

        try {
            $stm->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}
