<?php
    include('connection.php');
    
    $stm = $conn->prepare("INSERT INTO usuario(nome, sobrenome, email, senha, data_cadastro) VALUES (:name, :surname, :email, :password, :data_cadastro)");
    $stm->bindValue(":name", $_POST['name']);
    $stm->bindValue(":surname", $_POST['surname']);
    $stm->bindValue(":email", $_POST['email']);
    $stm->bindValue(":password", md5($_POST['password']));
    $stm->bindValue(":data_cadastro", date('Y' . '-' . 'm' . '-' . 'd'));
    
    if($stm->execute()){
        header("Location:  ../pages/login.php");
    }else{
        print_r($stm->errorInfo());
    }

    $conn = null;
?>