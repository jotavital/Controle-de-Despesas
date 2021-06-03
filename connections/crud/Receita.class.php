<?php

include_once(__DIR__ . "/../Connection.class.php");
include_once(__DIR__ . "/../loginVerify.php");
include_once(__DIR__ . "/../crud/Conta.class.php");

if (!isset($_SESSION)) {
    session_start();
}

class Receita
{

    function insertReceita()
    {

        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("INSERT INTO receita (descricao_receita, data_receita, valor, data_inclusao, fk_usuario, fk_conta) VALUES (:descricao_receita, :data_receita, :valor, :data_inclusao, :fk_usuario, :fk_conta)");
        $stm->bindValue(':descricao_receita', $_POST['descReceitaInput']);
        $stm->bindValue(':data_receita', $_POST['dataReceita']);
        $stm->bindValue(':valor', $_POST['valorInput']);
        $stm->bindValue(':data_inclusao', date('Y' . '-' . 'm' . '-' . 'd'));
        $stm->bindValue(':fk_usuario', $_SESSION['userId']);
        $stm->bindValue(':fk_conta', $_POST['contaSelect']);

        try {
            $stm->execute();

            $receitaId = $conexao->lastInsertId();

            foreach ($_POST['categoriasSelect'] as $categoria) {
                $stm2 = $conexao->prepare("INSERT INTO categoria_receita (fk_categoria, fk_receita) VALUES (:fk_categoria, :fk_receita)");
                $stm2->bindValue(':fk_categoria', $categoria);
                $stm2->bindValue(':fk_receita', $receitaId);

                try {
                    $stm2->execute();
                } catch (PDOException $th) {
                    echo $th->errorInfo;
                }
            }

            $conta = new Conta;
            $conta->somarValorReceita($_POST['contaSelect'], $_POST['valorInput']);
        } catch (PDOException $th) {
            echo $th->errorInfo;
        }

        $conn->desconectar();
    }

    function insertCategoriaReceita()
    {
        
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("INSERT INTO categoria (nome_categoria, fk_tipo, fk_usuario) VALUES (:nome_categoria, :fk_tipo, :fk_usuario)");
        $stm->bindValue(":nome_categoria", $_POST['nomeCategoriaInput']);
        $stm->bindValue(":fk_tipo", 4);
        $stm->bindValue(":fk_usuario", $_SESSION['userId']);

        try {
            $stm->execute();

            $_SESSION['msg'] = "Categoria cadastrada com sucesso!";
        } catch (PDOException $e) {
            $_SESSION['msg'] = "Erro ao cadastrar categoria!";
            echo $e->getMessage();
        }

        $conn->desconectar();
    }

    function desvincularTodasCategoriasReceita($idReceita)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("DELETE FROM categoria_receita WHERE fk_receita = :idReceita");
        $stm->bindValue("idReceita", $idReceita);

        try {
            $stm->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $conn->desconectar();
    }

    function deletarReceita($idReceita)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();
        $deleteReceita = new Receita;

        $deleteReceita->desvincularTodasCategoriasReceita($idReceita);

        $stm2 = $conexao->prepare("DELETE FROM receita WHERE id = :idReceita");
        $stm2->bindValue("idReceita", $idReceita);

        try {
            $stm2->execute();

            $conta = new Conta;
            $conta->subtrairValorReceita($_POST['idConta'], $_POST['valorReceita']);

            header('Location: ../../pages/receitas.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $conn->desconectar();
    }

    function deletarTodasReceitasConta($idConta)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();
        $deleteReceita = new Receita;

        $stmSelectReceitasConta = $conexao->prepare("SELECT id as receita_id FROM receita where fk_conta = :idConta");
        $stmSelectReceitasConta->bindValue("idConta", $idConta);

        try {
            $stmSelectReceitasConta->execute();

            $resultReceitasConta = $stmSelectReceitasConta->fetchAll();

            foreach ($resultReceitasConta as $receita) {
                $deleteReceita->desvincularTodasCategoriasReceita($receita['receita_id']);
            }

            $stmReceita = $conexao->prepare("DELETE FROM receita WHERE fk_conta = :idConta");
            $stmReceita->bindValue("idConta", $idConta);

            try {
                $stmReceita->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }



        $conn->desconectar();
    }

    function selectValorTotalReceitasByMonth($mes){
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("SELECT SUM(valor) FROM receita WHERE month(receita.data_receita) = :mes AND receita.fk_usuario = :userId");
        $stm->bindValue(":mes", $mes);
        $stm->bindValue(":userId", $_SESSION['userId']);

        try {
            $stm->execute();
            $result = $stm->fetch();

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
        
        $conn->desconectar();
    }

    function deletarTodasReceitasUsuario(){
        $conta = new Conta;
        $receita = new Receita;

        $todasContasUsuario = $conta->selectTodasContasUsuario();

        foreach ($todasContasUsuario as $idContaUsuario) {
            $receita->deletarTodasReceitasConta($idContaUsuario['id']);
        }
    }
}

if (isset($_POST['deleteReceita'])) {
    $receita = new Receita;
    $receita->deletarReceita($_POST['idReceita']);
}

if (isset($_POST['insertReceita'])) {
    $receita = new Receita;
    $receita->insertReceita();
}

if (isset($_POST['insertCategoriaReceita'])) {
    $receita = new Receita;
    $receita->insertCategoriaReceita();
}
