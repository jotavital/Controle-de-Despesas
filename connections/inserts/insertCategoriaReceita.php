<?php

    include("../loginVerify.php");
    include("../connection.php");

    $stm = $conn->prepare("INSERT INTO categoria (nome_categoria, fk_tipo, fk_usuario) VALUES (:nome_categoria, :fk_tipo, :fk_usuario)");
    $stm->bindValue(":nome_categoria", $_POST['nomeCategoriaInput']);
    $stm->bindValue(":fk_tipo", 4);
    $stm->bindValue(":fk_usuario", $_SESSION['userId']);

    try {
        $stm->execute();

        $_SESSION['msg'] = "Categoria cadastrada com sucesso!";
    } catch (PDOException $e) {
        $_SESSION['msg'] = "Erro ao cadastrar categoria!";
        print_r($e);
    }

?>