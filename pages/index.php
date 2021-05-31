<?php
if (!isset($_SESSION)) {
    if (!isset($_SESSION)) {
        session_start();
    }
}
$title = "Home";
include_once("../include/header.php");
setTitulo($title);
include_once("../include/navBar_unlogged.php");
?>

<body>
    <h1 class="mainTitle">Easylize Finanças</h1>


    <?php
    include_once("../include/footer.php");
    ?>
</body>

</html>