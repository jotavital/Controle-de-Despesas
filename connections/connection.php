<?php
    define('HOST', 'localhost');
    define('USERNAME', 'root');
    define('PASSWORD', '');
    define('PORT', '3308');
    define('DBNAME', 'easylize_financas');

    try{
        $conn = new PDO('mysql:host=' . HOST . ':' . PORT . ';dbname=' . DBNAME, USERNAME, PASSWORD); // ou simplesmente $conn = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
    }catch (PDOException $e) {
        echo($e->getMessage());
    }
    
?>