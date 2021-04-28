<?php
    include("../connections/loginVerify.php");
    include('connection.php');

    $userId = $_SESSION['userId'];
    
    $sql = $conn->prepare("INSERT INTO conta(nome_conta, saldo_atual, fk_usuario, fk_categoria) VALUES (:nome, :saldo, :userId, 1)");
    $sql->bindValue(":nome", $_POST['nomeConta']);
    $sql->bindValue(":saldo", $_POST['saldoConta']);
    $sql->bindValue(":userId", $userId);
    
    if($sql->execute()){
        echo("certim");
    }else{
        print_r($sql->errorInfo());
    }

    $conn = null;
?>