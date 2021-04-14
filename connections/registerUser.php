<?php
    session_start();
    include_once('connection.php');

    $email = $_POST['email'];

    
    $sql = $conn->prepare("INSERT INTO usuarios(nome, sobrenome, nome_usuario, senha) VALUES (:name, :surname, :username, :password)");
    $sql->bindValue(":name", $_POST['name']);
    $sql->bindValue(":surname", $_POST['surname']);
    $sql->bindValue(":username", $_POST['username']);
    $sql->bindValue(":password", $_POST['password']);
    
    if($sql->execute()){
        echo("certim parsa");
    }else{
        echo("deu bosta");
        print_r($sql->errorInfo());
    }

    $conn = null;
?>