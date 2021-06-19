<?php

include_once(__DIR__ . "/../connections/Connection.class.php");

class Categoria_Receita
{
    function relacionarCategoriaReceita($categoria, $receitaId)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm2 = $conexao->prepare("INSERT INTO categoria_receita (fk_categoria, fk_receita) VALUES (:fk_categoria, :fk_receita)");
        $stm2->bindValue(':fk_categoria', $categoria);
        $stm2->bindValue(':fk_receita', $receitaId);

        try {
            $stm2->execute();
        } catch (PDOException $th) {
            echo $th->getMessage();
        }
    }
}
