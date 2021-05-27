<?php

include_once("../connection.php");
include("../loginVerify.php");

class DeleteDespesa
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
            $e->getMessage();
        }
    }

    function deletarDespesa($idDespesa)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $deleteDespesa = new DeleteDespesa;
        $deleteDespesa->desvincularTodasCategoriasDespesa($idDespesa);

        try {
            $stm = $conexao->prepare("DELETE FROM despesa WHERE id = :idDespesa");
            $stm->bindValue("idDespesa", $idDespesa);

            $stm->execute();
            header('Location: ../../pages/despesas.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function deletarTodasDespesasConta($idConta)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();
        $stmDeleteDespesa = $conexao->prepare("DELETE FROM despesa WHERE fk_conta = :idConta");
        $stmDeleteDespesa->bindValue("idConta", $idConta);

        try {
            $stmDeleteDespesa->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }

        $conn->desconectar();
    }
}

if(isset($_POST['deleteDespesa'])){
    $deleteDespesa = new DeleteDespesa;
    $deleteDespesa->deletarDespesa($_POST['idDespesa']);
}
