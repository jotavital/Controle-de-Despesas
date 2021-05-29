<?php

include("../connections/loginVerify.php");

include("../connections/connection.php");
$conn = new Connection;
$conexao = $conn->conectar();

$title = "Metas";
include("../include/header.php");
setTitulo($title);

?>

<body>
    <div id="containerDashboard">

        <?php
        include("../include/sideBar.php");
        ?>

        <main>

            <?php
            include("../include/navBar_logged.php");
            ?>

            <div id="contentDashboard">
                <div class="row col-md">

                </div>
            </div>
        </main>
    </div>

</body>

<?php
include("../include/footer.php");
?>