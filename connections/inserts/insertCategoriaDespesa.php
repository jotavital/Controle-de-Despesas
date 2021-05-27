<?php

    include("../loginVerify.php");
    include("../connection.php");

    $conn = (new Connection)->conectar();

    $stm = $conn->prepare("INSERT INTO categoria (nome_categoria, fk_tipo, fk_usuario) VALUES (:nome_categoria, :fk_tipo, :fk_usuario)");
    $stm->bindValue(":nome_categoria", $_POST['nomeCategoriaInput']);
    $stm->bindValue(":fk_tipo", 3);
    $stm->bindValue(":fk_usuario", $_SESSION['userId']);

    try {
        $stm->execute();

        $msg = "Categoria cadastrada com sucesso!";
    } catch (PDOException $e) {
        print_r($e);
        $msg = "Erro ao cadastrar categoria!";
    }

?>