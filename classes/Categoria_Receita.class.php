<?php

include_once(__DIR__ . "/../connections/Connection.class.php");

class Categoria_Receita
{
    function relacionarCategoriaReceita($categoria, $idReceita)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("INSERT INTO categoria_receita (fk_categoria, fk_receita) VALUES (:fk_categoria, :fk_receita)");
        $stm->bindValue(':fk_categoria', $categoria);
        $stm->bindValue(':fk_receita', $idReceita);

        try {
            $stm->execute();
        } catch (PDOException $th) {
            echo $th->getMessage();
        }
    }

    function selectAllCategoriaReceitaByReceitaId($idReceita)
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("SELECT fk_categoria FROM categoria_receita WHERE fk_receita = :idReceita");
        $stm->bindValue(":idReceita", $idReceita);

        try {
            $stm->execute();
            $resultado = $stm->fetchAll();

            return $resultado;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function desvincularTodasCategoriasReceita($idReceita)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("DELETE FROM categoria_receita WHERE fk_receita = :idReceita");
        $stm->bindValue("idReceita", $idReceita);
        
        try {

            $stm->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $conn->desconectar();
    }
}
