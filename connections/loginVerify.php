<?php
    session_start();

    if(!$_SESSION['userEmail']){
        header("Location: ../pages/login.php");
        exit();
    }else{

    }
?>