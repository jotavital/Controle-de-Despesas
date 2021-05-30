<?php

include("../loginVerify.php");
include("../connection.php");
include("../crud/Receita.class.php");
include("../crud/Despesa.class.php");

class Conta
{

    private $idConta;

    function __construct()
    {
        $idConta = $_POST['idConta'];
    }

    public function insertConta()
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
        $stm->bindValue("idConta", $idConta);

        try {
            $stm->execute();
            header('Location: ../../pages/contas.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

if (isset($_POST['deleteConta'])) {
    $conta = new Conta;
    $conta->deletarConta($_POST['idConta']);
}

if(isset($_POST['insertConta'])){
    $conta = new Conta;
    $conta->insertConta();
}