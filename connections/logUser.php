<?php
    include("connection.php");
    session_start();

    if(isset($_POST['email']) && isset($_POST['password'])){
        $sql = $conn->prepare("SELECT * FROM `usuario` WHERE email= :email AND senha = :password");
        $sql->bindValue(":email", $_POST['email']);
        $sql->bindValue(":password", md5($_POST['password']));
        
        if($sql->execute()){
            if($sql->rowCount() == 0){
                $_SESSION['msg'] = "OPS... Não te encontramos no nosso sistema";
                header("Location: ../pages/login.php");
            }else{
                $_SESSION['userEmail'] = $_POST['email'];
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