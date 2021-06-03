<?php
if (!isset($_SESSION)) {
    if (!isset($_SESSION)) {
        session_start();
    }
}
$title = "Login"; //titulo para o header.php
include_once(__DIR__ . "/../include/header.php"); //cabecalho da pagina
setTitulo($title); //passa titulo pro header.php

if (isset($_SESSION['userEmail'])) {
    if ($_SESSION['userEmail']) {
        header("Location: ../pages/dashboard.php");
    }
}

include_once(__DIR__ . "/../include/navBar_unlogged.php");
?>

<body>
    <div id="container">
        <div class="divForm">
            <form action="../connections/crud/Usuario.class.php" method="POST" id="formLogin" class="col-5 needs-validation" novalidate>
                <h1 class="mb-3">Entrar</h1>
                <div class="row d-flex justify-content-center">
                    <div class="col-md">
                        <div class="form-floating mb-3">
                            <input type="email" name="email" id="emailInput" class="form-control" placeholder="E-mail" required>
                            <label class="floatingLabel">E-mail</label>
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
                    <div class="col-md">
                        <div class="form-floating mb-3">
                            <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Senha" required>
                            <label class="floatingLabel">Senha</label>
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

                <?php
                if (isset($_SESSION['msg'])) {

                    echo ("<div class='alert alert-danger alert-dismissible fade show' role='alert'>"
                        . "<p class='mt-3'>" . $_SESSION['msg'] . "</p>"
                        . "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>"
                        . "</div>");

                    unset($_SESSION['msg']);
                }
                ?>

                <div class="row d-flex justify-content-center">
                    <p>Ainda não tem cadastro? <a style="text-decoration:none;" href="register.php">Cadastre-se aqui</a>
                    </p>
                </div>
                <input name="loginUser" class="hide">
                <div class="mt-2 row d-flex justify-content-center">
                    <div class="col-8">
                        <div class="d-grid d-sm-flex justify-content-sm-center">
                            <button type="submit" class="btn btn-success">Pronto!</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
    include_once(__DIR__ . "/../include/footer.php");
    ?>
</body>