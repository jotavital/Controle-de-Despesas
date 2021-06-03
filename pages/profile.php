<?php

include_once(__DIR__ . "/../connections/loginVerify.php");

include_once(__DIR__ . "/../connections/Connection.class.php");
$conn = new Connection;
$conexao = $conn->conectar();

$title = "Seu Perfil";
include_once(__DIR__ . "/../include/header.php");
setTitulo($title);

include_once(__DIR__ . "/../pages/modals/modalEditNomeSobrenome.php");
include_once(__DIR__ . "/../pages/modals/modalEditSenha.php");
include_once(__DIR__ . "/../pages/modals/modalDeleteUsuario.php");
?>

<body>
    <div id="containerDashboard">

        <?php
        include_once(__DIR__ . "/../include/sideBar.php");
        ?>

        <main>

            <?php
            include_once(__DIR__ . "/../include/navBar_logged.php");
            ?>

            <div id="contentDashboard" class="col-12">

                <?php
                $sql = "SELECT * FROM usuario WHERE id = :userId";
                $stm = $conexao->prepare($sql);
                $stm->bindValue(':userId', $_SESSION['userId']);

                try {
                    $stm->execute();

                    $resultado = $stm->fetch();
                    $data_cadastro = strtotime($resultado['data_cadastro']);
                    $data_cadastro_formatada = date('d/m/Y', $data_cadastro);
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                ?>

                <div id="userInfo" class="col-md">
                    <div class="row mb-3">
                        <div class="mb-3 divProfilePicture d-flex justify-content-center">
                            <img id="profilePicture" src="../image/assets/no_profile_picture.png" alt="foto de perfil">
                        </div>
                        <div class="row">
                            <div class="d-flex justify-content-center align-items-center">
                                <h5><?php echo ($resultado['nome'] . " " . $resultado['sobrenome']); ?></h5>
                                <div class="editIcon">
                                    <?php echo '<a href="../pages/profile.php?editNomeSobrenome=true&nome=' . $resultado['nome'] . '&sobrenome=' . $resultado['sobrenome']  . '"' . 'id="btnEditNomeSobrenome"><i class="fas fa-edit"></i></a>' ?>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <p>Membro desde: <?php echo ($data_cadastro_formatada); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4 col-12 camposInfo d-flex justify-content-center">
                        <div class="col-md-4 d-flex align-items-center">
                            <label>Email:</label>
                            <input class="form-control" type="text" value=<?php echo ($resultado['email']); ?> readonly>
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                            <label>Senha:</label>
                            <input class="form-control" type="password" value=<?php echo ($resultado['email']); ?> readonly>
                            <div class="editIcon">
                                <?php echo '<a href="../pages/profile.php?editSenha=true" id="btnEditSenha"><i class="fas fa-edit"></i></a>' ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 d-flex justify-content-center align-items-center">
                        <?php echo '<a href="../pages/profile.php?excluirUsuario=true" id="btnExcluirConta">Excluir minha conta</a>' ?>
                    </div>
                    <div class="col-md d-flex justify-content-center">
                        <a class="btn btn-danger col-1.5" href="../connections/crud/Usuario.class.php?logout" role="button">Logout</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

<?php
include_once(__DIR__ . "/../include/footer.php");

if (isset($_GET['editNomeSobrenome']) && $_GET['editNomeSobrenome'] == 'true') {
    echo "  <script>
                $(document).ready(function(){
                    $('#modalEditNomeSobrenome').modal('show');
                });
            </script>";
}

if (isset($_GET['editSenha']) && $_GET['editSenha'] == 'true') {
    echo "  <script>
                $(document).ready(function(){
                    $('#modalEditSenha').modal('show');
                });
            </script>";
}

if (isset($_GET['excluirUsuario']) && $_GET['excluirUsuario'] == 'true') {
    echo "  <script>
                $(document).ready(function(){
                    $('#modalDeleteUsuario').modal('show');
                });
            </script>";
}

?>

<script>
    $(document).ready(function() {

        $('#modalEditNomeSobrenome').on('hidden.bs.modal', function() {
            window.history.pushState(null, null, window.location.pathname);
        });

        $('#modalEditSenha').on('hidden.bs.modal', function() {
            window.history.pushState(null, null, window.location.pathname);
        });

        $('#modalDeleteUsuario').on('hidden.bs.modal', function() {
            window.history.pushState(null, null, window.location.pathname);
        });
    });
</script>