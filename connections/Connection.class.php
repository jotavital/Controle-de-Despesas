<?php

define('HOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('PORT', '3308');
define('DBNAME', 'easylize_financas');

class Connection
{
    private $conexao;


    function conectar()
    {

        try {
            $conexao = new PDO('mysql:host=' . HOST . ':' . PORT . ';dbname=' . DBNAME, USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexao;
        } catch (PDOException $e) {
            echo ($e->getMessage());
            return null;
        }
    }

    function desconectar()
    {
        $conexao = null;
    }
}
