<?php

    include("../loginVerify.php");
    include("../connection.php");

    $sql = $conn->prepare("INSERT INTO despesa (descricao_despesa, imagem, data_despesa, data_vencimento, valor, data_inclusao, fk_conta, fk_usuario) VALUES (:descricao_despesa, :imagem, :data_despesa, :data_vencimento, :valor, :data_inclusao, :fk_conta, :fk_usuario)");
    $nomeImg = $_FILES['imgInput']['name'];
    $sql->bindValue(':descricao_despesa', $_POST['descDespesaInput']);
    $sql->bindValue(':imagem', $nomeImg);
    $sql->bindValue(':data_despesa', $_POST['dataDespesa']);
    $sql->bindValue(':data_vencimento', $_POST['dataVencimentoDespesa']);
    $sql->bindValue(':valor', $_POST['valorInput']);
    $sql->bindValue(':data_inclusao', date('Y' . '-' . 'm' . '-' . 'd'));
    $sql->bindValue(':fk_conta', $_POST['contaSelect']);
    $sql->bindValue(':fk_usuario', $_SESSION['userId']);

    if($sql->execute()){
        $_SESSION['msg'] = "Conta adicionada!";

        //armazena imagem da despesa na pasta
        $lastId = $conn->lastInsertId();
        $directory = '../../uploaded/user_images/despesas_images/' . $_SESSION['userId'];
        mkdir($directory);
        $directory = $directory . '/' . $conn->lastInsertId() . '/';
        mkdir($directory);

        if(copy($_FILES['imgInput']['tmp_name'], $directory . $nomeImg)){
            $_SESSION['msg'] = "Foto adicionada com sucesso! ";
        }else{
            $_SESSION['msg'] = "Erro ao adicionar foto! ";
        }
        
    }else{
        $_SESSION['msg'] = "Erro " . $sql->errorInfo();
    }

    $conn = null;

?>
