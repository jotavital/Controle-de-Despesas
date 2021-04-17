<?php
    session_start();
    include_once('connection.php');
    $senha = $_POST['password'];

    $sql = $conn->prepare("SELECT * FROM `usuario` WHERE email = :email and senha = :password");
    $sql->bindValue(":email", $_POST['email']);
    $sql->bindValue(":password", md5($_POST['password']));

    if($sql->execute()){
        $result = $sql->fetchAll();

        if($sql->rowCount() == 0){
            $_SESSION['msg'] = "OOPS... Não te achamos no sistema";
            header("Location:  ../pages/login.php");
        }else{
            header("Location: ../pages/dashboard.php");
        }
    }else{
        print_r($sql->errorInfo());
    }

    $conn = null;
?>