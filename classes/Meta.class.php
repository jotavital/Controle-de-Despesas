<?php

include_once(__DIR__ . "/../connections/Connection.class.php");
include_once(__DIR__ . "/../connections/loginVerify.php");
include_once(__DIR__ . "/Meta_Usuario.class.php");

class Meta
{

    function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    function insertMeta()
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("INSERT INTO meta(nome_meta, descricao_meta, prazo_meta, valor_total, valor_atingido, fk_categoria) VALUES (:nome_meta, :descricao_meta, :prazo_meta, :valor_total, :valor_atingido, :fk_categoria)");
        $stm->bindValue(":nome_meta", $_POST['nomeMetaInput']);
        $stm->bindValue(":descricao_meta", $_POST['descricaoMetaInput']);
        $stm->bindValue(":prazo_meta", $_POST['prazoMeta']);
        $stm->bindValue(":valor_total", $_POST['valorMetaInput']);
        $stm->bindValue(":valor_atingido", $_POST['valorAtingidoInput']);
        $stm->bindValue(":fk_categoria", $_POST['categoriaSelect']);

        try {
            $stm->execute();

            $idMeta = $conexao->lastInsertId();
            $idUsuario = $_SESSION['userId'];
        } catch (PDOException $e) {
            $_SESSION['msg'] = "Erro " . $e->getMessage();
        }

        $metaUsuarioObj = new Meta_Usuario;
        $metaUsuarioObj->relacionarMetaUsuario($idMeta, $idUsuario);

        $_SESSION['msg'] = "Meta adicionada!";

        $conexao = null;
    }

    function updateMeta()
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("UPDATE meta SET nome_meta = :nome_meta, descricao_meta = :descricao_meta, prazo_meta = :prazo_meta, valor_total = :valor_total, valor_atingido = :valor_atingido, fk_categoria = :fk_categoria WHERE id = :idMeta");
        $stm->bindValue(":nome_meta", $_POST['nomeMetaInput']);
        $stm->bindValue(":descricao_meta", $_POST['descricaoMetaInput']);
        $stm->bindValue(":prazo_meta", $_POST['prazoMeta']);
        $stm->bindValue(":valor_total", $_POST['valorMetaInput']);
        $stm->bindValue(":valor_atingido", $_POST['valorAtingidoInput']);
        $stm->bindValue(":fk_categoria", $_POST['categoriaSelect']);
        $stm->bindValue(":idMeta", $_POST['idMeta']);

        try {
            $stm->execute();

            $_SESSION['msg'] = "Meta atualizada!";
        } catch (PDOException $e) {
            $_SESSION['msg'] = "Erro " . $e->getMessage();
        }

        $conexao = null;
    }

    function selectAllFromMeta()
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("SELECT * FROM meta, meta_usuario WHERE meta_usuario.fk_usuario = :userId AND meta_usuario.fk_meta = meta.id");
        $stm->bindValue(":userId", $_SESSION['userId']);
        $stm->execute();
        $data = $stm->fetchAll();

        return $data;
    }

    function depositarMeta($valorDeposito, $idMeta)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("UPDATE meta SET valor_atingido = (valor_atingido + :valorDeposito) WHERE id = :idMeta");
        $stm->bindValue(":valorDeposito", $valorDeposito);
        $stm->bindValue(":idMeta", $idMeta);

        try {
            $stm->execute();

            header("Location: ../pages/metas.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

if (isset($_POST['insertMeta'])) {
    $metaObj = new Meta;
    $metaObj->insertMeta();
}

if (isset($_POST['depositoMeta'])) {
    $metaObj = new Meta;
    $metaObj->depositarMeta($_POST['valorInput'], $_POST['idMeta']);
}

if (isset($_POST['editMeta'])) {
    $metaObj = new Meta;
    $metaObj->updateMeta();
}
