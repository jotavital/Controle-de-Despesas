<?php

    include("../loginVerify.php");
    include("../connection.php");
    
    $stm = $conn->prepare("INSERT INTO conta(nome_conta, saldo_atual, fk_usuario, fk_categoria) VALUES (:nome, :saldo, :userId, :categoria)");
    $stm->bindValue(":nome", $_POST['nomeConta']);
    $stm->bindValue(":saldo", $_POST['saldoConta']);
    $stm->bindValue(":userId", $_SESSION['userId']);
    $stm->bindValue(":categoria", $_POST['categoriaSelect']);
    
    if($stm->execute()){
        $_SESSION['msg'] = "Conta adicionada!";
    }else{
        $_SESSION['msg'] = "Erro " . $stm->errorInfo();
    }

    $conn = null;

?>