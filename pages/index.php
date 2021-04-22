<?php
    session_start();
    $title = "Home";
    include("../include/header.php");
    setTitulo($title);
    include("../include/navBar_unlogged.php");
?>

<body>
    <h1 style="font-weight: bolder; font-style: italic; font-size: 3em; text-align: center; color: #86EB51; margin-top: 15px; text-shadow: 4px 4px 3px #3D6B24">EasyLize Finanças</h1>
    

    <?php
        include("../include/footer.php");
    ?>
</body>
</html>