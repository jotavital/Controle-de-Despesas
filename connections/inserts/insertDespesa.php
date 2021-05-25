<?php

    include("../loginVerify.php");
    include("../connection.php");

    $stm = $conn->prepare("INSERT INTO despesa (descricao_despesa, imagem, data_despesa, data_vencimento, valor, data_inclusao, fk_conta, fk_usuario) VALUES (:descricao_despesa, :imagem, :data_despesa, :data_vencimento, :valor, :data_inclusao, :fk_conta, :fk_usuario)");
    $nomeImg = $_FILES['imgInput']['name'];
    $stm->bindValue(':descricao_despesa', $_POST['descDespesaInput']);
    $stm->bindValue(':imagem', $nomeImg);
    $stm->bindValue(':data_despesa', $_POST['dataDespesa']);
    $stm->bindValue(':data_vencimento', $_POST['dataVencimentoDespesa']);
    $stm->bindValue(':valor', $_POST['valorInput']);
    $stm->bindValue(':data_inclusao', date('Y' . '-' . 'm' . '-' . 'd'));
    $stm->bindValue(':fk_conta', $_POST['contaSelect']);
    $stm->bindValue(':fk_usuario', $_SESSION['userId']);

    if($stm->execute()){
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

        //relacionando categorias com despesa
        $despesaId = $conn->lastInsertId();

        foreach($_POST['categoriasSelect'] as $categoria){
            $stm2 = $conn->prepare("INSERT INTO categoria_despesa (fk_categoria, fk_despesa) VALUES (:fk_categoria, :fk_despesa)");
            $stm2->bindValue(':fk_categoria', $categoria);
            $stm2->bindValue(':fk_despesa', $despesaId);
            $stm2->execute();
            
        }

    } else {
        $_SESSION['msg'] = "Erro ao criar despesa";
    }

    $conn = null;

?>
