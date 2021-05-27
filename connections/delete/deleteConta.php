<?php

    include("../connection.php");
    include("../loginVerify.php");
    include("../delete/deleteReceita.php");

    $conn = (new Connection)->conectar();
    $idConta = $_POST['idConta'];

    $stmDeleteReceita = $conn->prepare("DELETE FROM receita WHERE fk_conta = :idConta");
    $stmDeleteReceita->bindValue("idConta", $idConta);
    $stmDeleteDespesa = $conn->prepare("DELETE FROM despesa WHERE fk_conta = :idConta");
    $stmDeleteDespesa->bindValue("idConta", $idConta);
    $stm2 = $conn->prepare("DELETE FROM conta WHERE id = :idConta");
    $stm2->bindValue("idConta", $idConta);

    try {

        $stmDeleteReceita->execute();
        echo "sucesso receitas deletadas com fk_conta = " . $idConta;

        try {
            $stm2->execute();
            echo "sucesso deletou conta com id " . $idConta;
            //header('Location: ../../pages/contas.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "erro";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        echo "erro";
    }
?>