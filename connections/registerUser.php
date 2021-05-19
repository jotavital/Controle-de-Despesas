<?php
    include('connection.php');
    
    $sql = $conn->prepare("INSERT INTO usuario(nome, sobrenome, email, senha, data_cadastro) VALUES (:name, :surname, :email, :password, :data_cadastro)");
    $sql->bindValue(":name", $_POST['name']);
    $sql->bindValue(":surname", $_POST['surname']);
    $sql->bindValue(":email", $_POST['email']);
    $sql->bindValue(":password", md5($_POST['password']));
    $sql->bindValue(":data_cadastro", date('Y' . '-' . 'm' . '-' . 'd'));
    
    if($sql->execute()){
        header("Location:  ../pages/login.php");
    }else{
        print_r($sql->errorInfo());
    }

    $conn = null;
?>