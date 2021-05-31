<?php

include_once("../Connection.class.php");
include_once("../loginVerify.php");
include_once("../crud/Conta.class.php");

class Despesa
{


    function insertCategoriaDespesa()
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("INSERT INTO categoria (nome_categoria, fk_tipo, fk_usuario) VALUES (:nome_categoria, :fk_tipo, :fk_usuario)");
        $stm->bindValue(":nome_categoria", $_POST['nomeCategoriaInput']);
        $stm->bindValue(":fk_tipo", 3);
        $stm->bindValue(":fk_usuario", $_SESSION['userId']);

        try {
            $stm->execute();

            $msg = "Categoria cadastrada com sucesso!";
        } catch (PDOException $e) {
            echo $e->getMessage();
            $msg = "Erro ao cadastrar categoria!";
        }

        $conn->desconectar();
    }

    function insertDespesa()
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("INSERT INTO despesa (descricao_despesa, imagem, data_despesa, data_vencimento, valor, data_inclusao, fk_conta, fk_usuario) VALUES (:descricao_despesa, :imagem, :data_despesa, :data_vencimento, :valor, :data_inclusao, :fk_conta, :fk_usuario)");
        $nomeImg = $_FILES['imgInput']['name'];
        $stm->bindValue(':descricao_despesa', $_POST['descDespesaInput']);
        $stm->bindValue(':imagem', $nomeImg);
        $stm->bindValue(':data_despesa', $_POST['dataDespesa']);
        $stm->bindValue(':data_vencimento', $_POST['dataVencimentoDespesa']);
        $stm->bindValue(':valor', $_POST['valorInput']);
        $stm->bindValue(':data_inclusao', date('Y' . '-' . 'm' . '-' . 'd'));
        $stm->bindValue(':fk_conta', $_POST['contaSelect']);
        $stm->bindValue(':fk_usuario', $_SESSION['userId']);

        try {
            $stm->execute();
            $_SESSION['msg'] = "Despesa adicionada!";

            //armazena imagem da despesa na pasta
            if ($nomeImg != null) {
                $directory = '../../uploaded/user_images/despesas_images/' . $_SESSION['userId'];
                mkdir($directory);
                $directory = $directory . '/' . $conexao->lastInsertId() . '/';
                mkdir($directory);

                if (copy($_FILES['imgInput']['tmp_name'], $directory . $nomeImg)) {
                    $_SESSION['msg'] = "Foto adicionada com sucesso! ";
                } else {
                    $_SESSION['msg'] = "Erro ao adicionar foto! ";
                }
            }

            //relacionando categorias com despesa
            $despesaId = $conexao->lastInsertId();

            foreach ($_POST['categoriasSelect'] as $categoria) {
                $stm2 = $conexao->prepare("INSERT INTO categoria_despesa (fk_categoria, fk_despesa) VALUES (:fk_categoria, :fk_despesa)");
                $stm2->bindValue(':fk_categoria', $categoria);
                $stm2->bindValue(':fk_despesa', $despesaId);
                $stm2->execute();
            }

            $conta = new Conta;
            $conta->subtrairValorDespesa($_POST['contaSelect'], $_POST['valorInput']);
        } catch (PDOException $e) {
            $_SESSION['msg'] = "Erro ao criar despesa! " . $e->getMessage();
        }

        $conexao = null;
    }

    function desvincularTodasCategoriasDespesa($idDespesa)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        try {
            $stm = $conexao->prepare("DELETE FROM categoria_despesa WHERE fk_despesa = :idDespesa");
            $stm->bindValue("idDespesa", $idDespesa);

            $stm->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }

        $conn->desconectar();
    }

    function deletarDespesa($idDespesa)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $deleteDespesa = new Despesa;
        $deleteDespesa->desvincularTodasCategoriasDespesa($idDespesa);

        $stm = $conexao->prepare("DELETE FROM despesa WHERE id = :idDespesa");
        $stm->bindValue("idDespesa", $idDespesa);

        try {

            $stm->execute();

            $conta = new Conta;
            $conta->somarValorDespesa($_POST['idConta'], $_POST['valorDespesa']);

            header('Location: ../../pages/despesas.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $conn->desconectar();
    }

    function deletarTodasDespesasConta($idConta)
    {
        echo "<h1>Entrou no deletar</h1>";
        $conn = new Connection;
        $conexao = $conn->conectar();
        $deleteDespesa = new Despesa;

        $stmSelectDespesasConta = $conexao->prepare("SELECT id as despesa_id FROM despesa where fk_conta = :idConta");
        $stmSelectDespesasConta->bindValue("idConta", $idConta);

        try {
            $stmSelectDespesasConta->execute();

            $resultDespesasConta = $stmSelectDespesasConta->fetchAll();

            foreach ($resultDespesasConta as $despesa) {
                $deleteDespesa->desvincularTodasCategoriasDespesa($despesa['despesa_id']);
            }

            $stmDespesa = $conexao->prepare("DELETE FROM despesa WHERE fk_conta = :idConta");
            $stmDespesa->bindValue("idConta", $idConta);

            try {
                $stmDespesa->execute();
            } catch (PDOException $e) {
                $e->getMessage();
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }

        $conn->desconectar();
    }
}

if (isset($_POST['deleteDespesa'])) {
    $deleteDespesa = new Despesa;
    $deleteDespesa->deletarDespesa($_POST['idDespesa']);
}

if (isset($_POST['insertCategoriaDespesa'])) {
    $deleteDespesa = new Despesa;
    $deleteDespesa->insertCategoriaDespesa();
}

if (isset($_POST['insertDespesa'])) {
    $deleteDespesa = new Despesa;
    $deleteDespesa->insertDespesa();
}
