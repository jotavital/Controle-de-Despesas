<?php

class Connection
{
    private $conn;

    public function conectar()
    {
        define('HOST', 'localhost');
        define('USERNAME', 'root');
        define('PASSWORD', '');
        define('PORT', '3308');
        define('DBNAME', 'easylize_financas');

        try {
            $conn = new PDO('mysql:host=' . HOST . ':' . PORT . ';dbname=' . DBNAME, USERNAME, PASSWORD); // ou simplesmente $conn = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo ($e->getMessage());
            return null;
        }
    }

    public function desconectar()
    {
        $conn = null;
    }
}
