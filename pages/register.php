<?php
if (!isset($_SESSION)) {
    if (!isset($_SESSION)) {
        session_start();
    }
}
$title = "Cadastro";
include_once(__DIR__ . "/../include/header.php");
setTitulo($title);

if (isset($_SESSION['userEmail'])) {
    if ($_SESSION['userEmail']) {
        header("Location: ../pages/dashboard.php");
    }
}

include_once(__DIR__ . "/../include/navBar_unlogged.php");
?>

<body>
    <div id="container">
        <div class="col-12 mt-5 d-flex justify-content-center">
            <img class="logo-inicio" src="../image/logo_inicio.png" alt="logo da pagina de inicio">
        </div>
        <div class="divForm">
            <form action="../classes/Usuario.class.php" method="POST" id="formRegister" class="col-lg-5 needs-validation" novalidate>
                <h1 class="mb-4 p-primary">Cadastre-se!</h1>
                <div class="row g-2 col-md">
                    <div class="col-md">
                        <div class="form-floating mb-3">
                            <input type="text" name="name" id="nameInput" class="form-control" placeholder="Nome" required>
                            <label for="nameInput" class="floatingLabel">Nome</label>
                            <div class="invalid-feedback">
                                <?php
                                echo ($invalidFeedback);
                                ?>
                            </div>
                            <div class="valid-feedback">
                                <?php
                                echo ($validFeedback);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating mb-3">
                            <input type="text" name="surname" id="surnameInput" class="form-control" placeholder="Sobrenome" required>
                            <label for="surnameInput" class="floatingLabel">Sobrenome</label>
                            <div class="invalid-feedback">
                                <?php
                                echo ($invalidFeedback);
                                ?>
                            </div>
                            <div class="valid-feedback">
                                <?php
                                echo ($validFeedback);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-md-center">
                    <div class="col-md">
                        <div class="form-floating mb-3">
                            <input type="email" name="email" id="emailInput" class="form-control" placeholder="nome@exemplo.com" required>
                            <label for="emailInput" class="floatingLabel">E-mail</label>
                            <div class="invalid-feedback">
                                <?php
                                echo ($invalidFeedback);
                                ?>
                            </div>
                            <div class="valid-feedback">
                                <?php
                                echo ($validFeedback);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-md-center">
                    <div class="col-md">
                        <div class="form-floating mb-3">
                            <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Senha" required>
                            <label for="passwordInput" class="floatingLabel">Senha</label>
                            <div class="invalid-feedback">
                                <?php
                                echo ($invalidFeedback);
                                ?>
                            </div>
                            <div class="valid-feedback">
                                <?php
                                echo ($validFeedback);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    <p>Já tem cadastro? <strong><a style="text-decoration:none;" class="p-warning" href="login.php">Entre aqui</a></strong></p>
                </div>
                <input name="registerUser" class="hide">
                <div class="mt-2 row d-flex justify-content-center">
                    <div class="col-8">
                        <div class="d-grid d-sm-flex justify-content-sm-center">
                            <button type="submit" name="btnRegister" class="btn btn-success">Pronto!</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

<?php
include_once(__DIR__ . "/../include/footer.php");
?>