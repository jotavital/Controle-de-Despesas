<?php
    include_once('connection.php');

    $email = $_POST['email'];
    
    $sql = $conn->prepare("INSERT INTO usuario(nome, sobrenome, email, senha) VALUES (:name, :surname, :email, :password)");
    $sql->bindValue(":name", $_POST['name']);
    $sql->bindValue(":surname", $_POST['surname']);
    $sql->bindValue(":email", $_POST['email']);
    $sql->bindValue(":password", md5($_POST['password']));
    
    if($sql->execute()){
        header("Location:  ../pages/login.php");
    }else{
        print_r($sql->errorInfo());
    }

    $conn = null;
?>