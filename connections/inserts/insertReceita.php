<?php
    
    include("../loginVerify.php");
    include("../connection.php");

    $sql = $conn->prepare("INSERT INTO receita (descricao_receita, data_receita, valor, data_inclusao, fk_usuario, fk_conta) VALUES (:descricao_receita, :data_receita, :valor, :data_inclusao, :fk_usuario, :fk_conta)");
    $sql->bindValue(':descricao_receita', $_POST['descReceitaInput']);
    $sql->bindValue(':data_receita', $_POST['dataReceita']);
    $sql->bindValue(':valor', $_POST['valorInput']);
    $sql->bindValue(':data_inclusao', date('Y' . '-' . 'm' . '-' . 'd'));
    $sql->bindValue(':fk_usuario', $_SESSION['userId']);
    $sql->bindValue(':fk_conta', $_POST['contaSelect']);

    try {
        $sql->execute();

        $receitaId = $conn->lastInsertId();

        foreach($_POST['categoriasSelect'] as $categoria){
            $sql2 = $conn->prepare("INSERT INTO categoria_receita (fk_categoria, fk_receita) VALUES (:fk_categoria, :fk_receita)");
            $sql2->bindValue(':fk_categoria', $categoria);
            $sql2->bindValue(':fk_receita', $receitaId);

            try {
                $sql2->execute();
            } catch (PDOException $th) {
                echo $th->errorInfo;
            }

        }
    } catch (PDOException $th) {
        echo $th->errorInfo;
    }

    $conn = null;
?>