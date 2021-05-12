<?php

    include("../loginVerify.php");
    include("../connection.php");

    $sql = $conn->prepare("INSERT INTO categoria (nome_categoria, fk_tipo, fk_usuario) VALUES (:nome_categoria, :fk_tipo, :fk_usuario)");
    $sql->bindValue(":nome_categoria", $_POST['nomeCategoriaInput']);
    $sql->bindValue(":fk_tipo", 3);
    $sql->bindValue(":fk_usuario", $_SESSION['userId']);

    try {
        $sql->execute();

        $_SESSION['msg'] = "Categoria cadastrada com sucesso!";
    } catch (PDOException $e) {
        $_SESSION['msg'] = "Erro ao cadastrar categoria!";
        print_r($e);
    }

?>