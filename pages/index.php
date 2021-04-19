<?php
    session_start();
    $title = "Home";
    include("../include/header.php");
    setTitulo($title);
    include("../include/navBar_unlogged.php");
?>

<body>
    <h1>conteudo</h1>

    <?php
        include("../include/footer.php");
    ?>
</body>
</html>