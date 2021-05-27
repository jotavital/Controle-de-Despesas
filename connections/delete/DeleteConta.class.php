<?php

include_once("../connection.php");
include("../delete/DeleteReceita.class.php");
include("../delete/DeleteDespesa.class.php");

class DeleteConta
{

    private $idConta;

    function __construct()
    {
        $idConta = $_POST['idConta'];
    }

    function deletarConta($idConta)
    {

        $conn = new Connection;
        $conexao = $conn->conectar();

        $deleteReceita = new DeleteReceita;
        $deleteReceita->deletarTodasReceitasConta($idConta);

        $deleteDespesa = new DeleteDespesa;
        $deleteDespesa->deletarTodasDespesasConta($idConta);

        $stm = $conexao->prepare("DELETE FROM conta WHERE id = :idConta");
        $stm->bindValue("idConta", $idConta);

        try {
            $stm->execute();
            header('Location: ../../pages/contas.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}

if (isset($_POST['deleteConta'])) {
    $deleteConta = new DeleteConta;
    $deleteConta->deletarConta($_POST['idConta']);
}
