<?php

include_once(__DIR__ . "/../loginVerify.php");
include_once(__DIR__ . "/../Connection.class.php");
include_once(__DIR__ . "/../crud/Receita.class.php");
include_once(__DIR__ . "/../crud/Despesa.class.php");

class Conta
{

    private $idConta;

    function insertConta()
    {

        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("INSERT INTO conta(nome_conta, saldo_atual, fk_usuario, fk_categoria) VALUES (:nome, :saldo, :userId, :categoria)");
        $stm->bindValue(":nome", $_POST['nomeConta']);
        $stm->bindValue(":saldo", $_POST['saldoConta']);
        $stm->bindValue(":userId", $_SESSION['userId']);
        $stm->bindValue(":categoria", $_POST['categoriaSelect']);

        if ($stm->execute()) {
            $_SESSION['msg'] = "Conta adicionada!";
        } else {
            $_SESSION['msg'] = "Erro " . $stm->errorInfo();
        }

        $conexao = null;
    }


    function deletarConta($idConta)
    {

        $conn = new Connection;
        $conexao = $conn->conectar();

        $deleteReceita = new Receita;
        $deleteReceita->deletarTodasReceitasConta($idConta);

        $deleteDespesa = new Despesa;
        $deleteDespesa->deletarTodasDespesasConta($idConta);

        $stm = $conexao->prepare("DELETE FROM conta WHERE id = :idConta");
        $stm->bindValue(":idConta", $idConta);

        try {
            $stm->execute();
            header('Location: ../../pages/contas.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function somarValorReceita($idConta, $valorReceita)
    {

        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("UPDATE conta SET saldo_atual = saldo_atual + :valorReceita WHERE id = :idConta");
        $stm->bindValue(":valorReceita", $valorReceita);
        $stm->bindValue(":idConta", $idConta);

        try {
            $stm->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    function subtrairValorReceita($idConta, $valorReceita){

        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("UPDATE conta SET saldo_atual = saldo_atual - :valorReceita WHERE id = :idConta");
        $stm->bindValue(":valorReceita", $valorReceita);
        $stm->bindValue(":idConta", $idConta);

        try {
            $stm->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    function subtrairValorDespesa($idConta, $valorDespesa){

        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("UPDATE conta SET saldo_atual = saldo_atual - :valorDespesa WHERE id = :idConta");
        $stm->bindValue(":valorDespesa", $valorDespesa);
        $stm->bindValue(":idConta", $idConta);

        try {
            $stm->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    function somarValorDespesa($idConta, $valorDespesa){

        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("UPDATE conta SET saldo_atual = saldo_atual + :valorDespesa WHERE id = :idConta");
        $stm->bindValue(":valorDespesa", $valorDespesa);
        $stm->bindValue(":idConta", $idConta);

        try {
            $stm->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
}

if (isset($_POST['deleteConta'])) {
    $conta = new Conta;
    $conta->deletarConta($_POST['idConta']);
}

if (isset($_POST['insertConta'])) {
    $conta = new Conta;
    $conta->insertConta();
}
