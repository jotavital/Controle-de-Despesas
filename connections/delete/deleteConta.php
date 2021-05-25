<?php

    include("../connection.php");
    include("../loginVerify.php");

    $stm = $conn->prepare("DELETE FROM conta WHERE id = :idConta");
    $stm->bindValue("idConta", $_POST['idConta']);

    try {
        $stm->execute();

        header('Location: ../../pages/contas.php');
    } catch (PDOException $e) {
        print_r($e);
    }

?>