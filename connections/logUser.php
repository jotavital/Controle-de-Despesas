<?php
    include("connection.php");
    session_start();

    if(isset($_POST['email']) && isset($_POST['password'])){
        $stm = $conn->prepare("SELECT * FROM `usuario` WHERE email= :email AND senha = :password");
        $stm->bindValue(":email", $_POST['email']);
        $stm->bindValue(":password", md5($_POST['password']));
        
        if($stm->execute()){
            if($stm->rowCount() == 0){
                $_SESSION['msg'] = "OPS... Não te encontramos no nosso sistema";
                header("Location: ../pages/login.php");
            }else{
                $_SESSION['userEmail'] = $_POST['email'];
                $_SESSION['userId'] = $stm->fetchColumn();
                header("Location: ../pages/dashboard.php");
                exit();
            }
        }else{ 
            header("Location: ../pages/login.php");
            exit();
        }

    }else{
        header("Location: ../pages/login.php");
        exit();
    }


?>