<?php

if (!isset($_SESSION)) {
    session_start();
}

if (!$_SESSION['userEmail']) {
    header("Location: ../pages/login.php");
}
