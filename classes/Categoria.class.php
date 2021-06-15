<?php

include_once(__DIR__ . "/../connections/Connection.class.php");

class Categoria
{

    function deletarTodasCategoriasUsuario()
    {
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

    function selectAllFromCategoria($condicao = '')
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $conn = new Connection;
        $conexao = $conn->conectar();

        if($condicao == ''){
            $sql = "SELECT * FROM categoria WHERE fk_usuario = :userId OR fk_usuario IS NULL";
        }else{
            $sql = "SELECT * FROM categoria WHERE fk_usuario = :userId OR fk_usuario IS NULL AND " . $condicao;
        }
        $stm = $conexao->prepare($sql);
        $stm->bindValue(":userId", $_SESSION['userId']);

        try {
            $stm->execute();
            $resultado = $stm->fetchAll();

            return $resultado;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
