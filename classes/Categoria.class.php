<?php

include_once(__DIR__ . "/../connections/Connection.class.php");

class Categoria
{

    function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    function insertCategoriaMeta($nomeCategoria)
    {

        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("INSERT INTO categoria (nome_categoria, fk_tipo, fk_usuario) VALUES (:nome_categoria, 2, :fk_usuario)");
        $stm->bindValue(":nome_categoria", $nomeCategoria);
        $stm->bindValue(":fk_usuario", $_SESSION['userId']);

        try {
            $stm->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function deletarTodasCategoriasUsuario()
    {

        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("DELETE FROM categoria WHERE fk_usuario = :userId");
        $stm->bindValue(":userId", $_SESSION['userId']);

        try {
            $stm->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function selectAllFromCategoria($condicao = '')
    {

        $conn = new Connection;
        $conexao = $conn->conectar();

        if ($condicao == '') {
            $sql = "SELECT * FROM categoria WHERE fk_usuario = :userId OR fk_usuario IS NULL";
        } else {
            $sql = "SELECT * FROM categoria WHERE fk_usuario = :userId AND " . $condicao . " OR fk_usuario IS NULL AND " . $condicao;
        }
        $stm = $conexao->prepare($sql);
        $stm->bindValue(":userId", $_SESSION['userId']);

        try {
            $stm->execute();
            $resultado = $stm->fetchAll();

            return $resultado;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

if (isset($_POST['insertCategoriaMeta'])) {
    $categoriaObj = new Categoria;
    $categoriaObj->insertCategoriaMeta($_POST['nomeCategoriaInput']);
}