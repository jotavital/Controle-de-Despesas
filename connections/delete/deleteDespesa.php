<?php

    include("../connection.php");
    include("../loginVerify.php");

    $idDespesa = $_POST['idDespesa'];

    $conn = (new Connection)->conectar();

    $stm = $conn->prepare("DELETE FROM categoria_despesa WHERE fk_despesa = :idDespesa");
    $stm->bindValue("idDespesa", $idDespesa);

    try {
        $stm->execute();

        $stm2 = $conn->prepare("DELETE FROM despesa WHERE id = :idDespesa");
        $stm2->bindValue("idDespesa", $idDespesa);
    
        try {
            $stm2->execute();
    
            header('Location: ../../pages/despesas.php');
        } catch (PDOException $e) {
            print_r($e);
        }
    } catch (PDOException $e) {
        print_r($e);
    }
?>