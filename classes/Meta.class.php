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

        $stm = $conexao->prepare("INSERT INTO meta(nome_meta, descricao_meta, prazo_meta, valor_total, valor_atingido) VALUES (:nome_meta, :descricao_meta, :prazo_meta, :valor_total, :valor_atingido)");
        $stm->bindValue(":nome_meta", $_POST['nomeMetaInput']);
        $stm->bindValue(":descricao_meta", $_POST['descricaoMetaInput']);
        $stm->bindValue(":prazo_meta", $_POST['prazoMeta']);
        $stm->bindValue(":valor_total", $_POST['valorMetaInput']);
        $stm->bindValue(":valor_atingido", $_POST['valorAtingidoInput']);

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

    function selectAllFromMeta()
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $sql = $conexao->prepare("SELECT * FROM meta, meta_usuario WHERE meta_usuario.fk_usuario = :userId AND meta_usuario.fk_meta = meta.id");
        $sql->bindValue(":userId", $_SESSION['userId']);
        $sql->execute();
        $data = $sql->fetchAll();

        return $data;
    }
    
}

if (isset($_POST['insertMeta'])) {
    $metaObj = new Meta;
    $metaObj->insertMeta();
}