<?php

include_once("../connection.php");

class DeleteReceita
{

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

    function deletarReceita($idReceita)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("DELETE FROM categoria_receita WHERE fk_receita = :idReceita");
        $stm->bindValue("idReceita", $idReceita);

        try {
            $stm->execute();

            $stm2 = $conexao->prepare("DELETE FROM receita WHERE id = :idReceita");
            $stm2->bindValue("idReceita", $idReceita);

            try {
                $stm2->execute();

                header('Location: ../../pages/receitas.php');
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
        
        $conn->desconectar();
    }

    function deletarTodasReceitasConta($idConta)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();
        $stmDeleteReceita = $conexao->prepare("DELETE FROM receita WHERE fk_conta = :idConta");
        $stmDeleteReceita->bindValue("idConta", $idConta);

        try {
            $stmDeleteReceita->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
        
        $conn->desconectar();
    }
}

if(isset($_POST['deleteReceita'])){
    $deleteReceita = new DeleteReceita;
    $deleteReceita->deletarReceita($_POST['idReceita']);
}