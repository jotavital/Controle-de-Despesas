<?php

include_once("../connections/loginVerify.php");

include_once("../connections/Connection.class.php");
$conn = new Connection;
$conexao = $conn->conectar();

$title = "Estatísticas";
include_once("../include/header.php");
setTitulo($title);

?>

<body>
    <div id="containerDashboard">

        <?php
        include_once("../include/sideBar.php");
        ?>

        <main>

            <?php
            include_once("../include/navBar_logged.php");
            ?>

            <div id="contentDashboard">
                <div class="row col-md">

                </div>
            </div>
        </main>
    </div>

</body>

<?php
include_once("../include/footer.php");
?>