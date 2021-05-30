<?php

include_once("../connection.php");
include("../loginVerify.php");

class Despesa
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

        $deleteDespesa = new Despesa;
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
        echo "<h1>Entrou no deletar</h1>";
        $conn = new Connection;
        $conexao = $conn->conectar();
        $deleteDespesa = new Despesa;

        $stmSelectDespesasConta = $conexao->prepare("SELECT id as despesa_id FROM despesa where fk_conta = :idConta");
        $stmSelectDespesasConta->bindValue("idConta", $idConta);

        try {
            $stmSelectDespesasConta->execute();

            $resultDespesasConta = $stmSelectDespesasConta->fetchAll();

            foreach ($resultDespesasConta as $despesa) {
                $deleteDespesa->desvincularTodasCategoriasDespesa($despesa['despesa_id']);
            }

            $stmDespesa = $conexao->prepare("DELETE FROM despesa WHERE fk_conta = :idConta");
            $stmDespesa->bindValue("idConta", $idConta);

            try {
                $stmDespesa->execute();
            } catch (PDOException $e) {
                $e->getMessage();
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }

        $conn->desconectar();
    }
}

if (isset($_POST['deleteDespesa'])) {
    $deleteDespesa = new Despesa;
    $deleteDespesa->deletarDespesa($_POST['idDespesa']);
}
