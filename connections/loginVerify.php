<?php

include_once(__DIR__ . "/../classes/Usuario.class.php");

if (!isset($_SESSION)) {
    session_start();
}

if (!$_SESSION['userEmail']) {
    header("Location: ../pages/login.php");
}

if (isset($_SESSION['userId'])) {
    $usuarioObj = new Usuario;

    if (!$usuarioObj->verificaSeExisteUsuario($_SESSION['userId'])) {
        session_destroy();
        header("Location: ../pages/login.php");
    }
}
