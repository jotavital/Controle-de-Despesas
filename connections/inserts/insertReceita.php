<?php
    
    include("../loginVerify.php");
    include("../connection.php");

    $conn = (new Connection)->conectar();

    $stm = $conn->prepare("INSERT INTO receita (descricao_receita, data_receita, valor, data_inclusao, fk_usuario, fk_conta) VALUES (:descricao_receita, :data_receita, :valor, :data_inclusao, :fk_usuario, :fk_conta)");
    $stm->bindValue(':descricao_receita', $_POST['descReceitaInput']);
    $stm->bindValue(':data_receita', $_POST['dataReceita']);
    $stm->bindValue(':valor', $_POST['valorInput']);
    $stm->bindValue(':data_inclusao', date('Y' . '-' . 'm' . '-' . 'd'));
    $stm->bindValue(':fk_usuario', $_SESSION['userId']);
    $stm->bindValue(':fk_conta', $_POST['contaSelect']);

    try {
        $stm->execute();

        $receitaId = $conn->lastInsertId();

        foreach($_POST['categoriasSelect'] as $categoria){
            $stm2 = $conn->prepare("INSERT INTO categoria_receita (fk_categoria, fk_receita) VALUES (:fk_categoria, :fk_receita)");
            $stm2->bindValue(':fk_categoria', $categoria);
            $stm2->bindValue(':fk_receita', $receitaId);

            try {
                $stm2->execute();
            } catch (PDOException $th) {
                echo $th->errorInfo;
            }

        }
    } catch (PDOException $th) {
        echo $th->errorInfo;
    }

    $conn = null;
?>