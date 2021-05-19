<?php
include("../connections/loginVerify.php");
$title = "Perfil";
include("../include/header.php");
include("../pages/modals/modalAddConta.php");
setTitulo($title);
?>

<body>
    <div id="containerDashboard">

        <?php
        include("../include/sideNav.php");
        ?>

        <main>

            <?php
            include("../include/navBar_logged.php");
            ?>

            <div id="contentDashboard">

                <?php
                $sql = "SELECT * FROM usuario WHERE id = :userId";
                $stm = $conn->prepare($sql);
                $stm->bindValue(':userId', $_SESSION['userId']);

                try {
                    $stm->execute();

                    $resultado = $stm->fetch();
                } catch (PDOException $e) {
                    print_r($e);
                }
                ?>

                <h3 class="mb-4 d-flex justify-content-center">Seu Perfil</h3>
                <div class="mb-3 d-flex justify-content-center">
                    <img id="profilePicture" src="../image/assets/no_profile_picture.png" alt="foto de perfil">
                </div>
                <h5 class="d-flex justify-content-center"><?php echo($resultado['nome'] . " " .$resultado['sobrenome']);?></h5>
            </div>
        </main>
    </div>
</body>

<?php
include("../include/footer.php");
?>