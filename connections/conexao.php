<?php
    //arquivo de conexao com o banco
    ini_set( "display_errors", 0); //nao exibe os erros do php
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $nomedb = "controle_despesas_db";
    $porta = "3308";

    $conn = mysqli_connect($servidor, $usuario, $senha, $nomedb, $porta); //variavel de conexao do banco

    mysqli_set_charset($conn, "utf8");
?>