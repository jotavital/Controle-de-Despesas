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

            <div id="contentDashboard" class="col-12">

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

                <div id="userInfo" class="col-md">
                    <div class="row">
                        <h3 class="mb-4 d-flex justify-content-center">Seu Perfil</h3>
                    </div>
                    <div class="row mb-3">
                        <div class="mb-3 divProfilePicture d-flex justify-content-center">
                            <img id="profilePicture" src="../image/assets/no_profile_picture.png" alt="foto de perfil">
                        </div>
                        <div class="row">
                            <div class="d-flex justify-content-center align-items-center">
                                <h5><?php echo ($resultado['nome'] . " " . $resultado['sobrenome']); ?></h5>
                                <i class="fas fa-edit"></i>
                            </div>
                        </div>
                    </div>

                    <div class="row col-12 camposInfo d-flex justify-content-center">
                        <div class="col-md-4 d-flex align-items-center">
                            <label>Email:</label>
                            <input class="form-control" type="text" value=<?php echo ($resultado['email']); ?> readonly>
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                            <label>Senha:</label>
                            <input class="form-control" type="password" value=<?php echo ($resultado['email']); ?> readonly>
                            <i class="fas fa-edit"></i>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

<?php
include("../include/footer.php");
?>