<?php
    session_start();
    include_once('connection.php');

    $email = $_POST['email'];

    
    $sql = $conn->prepare("INSERT INTO usuario(nome, sobrenome, nome_usuario, email, senha) VALUES (:name, :surname, :username, :email, :password)");
    $sql->bindValue(":name", $_POST['name']);
    $sql->bindValue(":surname", $_POST['surname']);
    $sql->bindValue(":username", $_POST['username']);
    $sql->bindValue(":email", $_POST['email']);
    $sql->bindValue(":password", md5($_POST['password']));
    
    if($sql->execute()){
        echo("certim parsa");
    }else{
        echo("deu bosta");
        print_r($sql->errorInfo());
    }

    $conn = null;
?>