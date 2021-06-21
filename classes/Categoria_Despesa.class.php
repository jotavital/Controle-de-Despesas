<?php

include_once(__DIR__ . "/../connections/Connection.class.php");

class Categoria_Despesa
{

    function desvincularTodasCategoriasDespesa($idDespesa)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        try {
            $stm = $conexao->prepare("DELETE FROM categoria_despesa WHERE fk_despesa = :idDespesa");
            $stm->bindValue("idDespesa", $idDespesa);

            $stm->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $conn->desconectar();
    }

    function relacionarCategoriaDespesa($categoria, $despesaId)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("INSERT INTO categoria_despesa (fk_categoria, fk_despesa) VALUES (:fk_categoria, :fk_despesa)");
        $stm->bindValue(':fk_categoria', $categoria);
        $stm->bindValue(':fk_despesa', $despesaId);

        try {
            $stm->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function selectAllCategoriaDespesaByDespesaId($idDespesa)
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("SELECT fk_categoria FROM categoria_despesa WHERE fk_despesa = :idDespesa");
        $stm->bindValue(":idDespesa", $idDespesa);

        try {
            $stm->execute();
            $resultado = $stm->fetchAll();

            return $resultado;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
