<?php
    session_start();
    $title = "Login"; //titulo para o header.php
    include("../include/header.php"); //cabecalho da pagina
    setTitulo($title); //passa titulo pro header.php

    if(isset($_SESSION['userEmail'])){
        if($_SESSION['userEmail']){
            header("Location: ../pages/dashboard.php");
        }
    }
    
    include("../include/navBar_unlogged.php");
?>

<body>
    <div id="container">
        <div class="divForm">
            <form action="../connections/logUser.php" method="POST" id="formLogin" class="col-5 needs-validation"
                novalidate>
                <img style="display: block; margin-left: auto; margin-right: auto; width: 180px" src="../image/apresentação.png" alt="">
                <h1 style="font-weight: bolder; font-style: italic; font-size: 3em; text-align: center; color: #86EB51; margin-top: 5px; text-shadow: 4px 4px 3px #3D6B24">EasyLize Finanças</h1>
                <h1 class="mb-3">Entrar</h1>
                <div class="row d-flex justify-content-center">
                    <div class="col-md">
                        <div class="form-floating mb-3">
                            <input type="email" name="email" id="emailInput" class="form-control" placeholder="E-mail"
                                required>
                            <label class="floatingLabel">E-mail</label>
                            <div class="invalid-feedback">
                                <?php
                                    echo($invalidFeedback);
                                ?>
                            </div>
                            <div class="valid-feedback">
                                <?php
                                    echo($validFeedback);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-md">
                        <div class="form-floating mb-3">
                            <input type="password" name="password" id="passwordInput" class="form-control"
                                placeholder="Senha" required>
                            <label class="floatingLabel">Senha</label>
                            <div class="invalid-feedback">
                                <?php
                                    echo($invalidFeedback);
                                ?>
                            </div>
                            <div class="valid-feedback">
                                <?php
                                    echo($validFeedback);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                    if(isset($_SESSION['msg'])) {

                        echo("<div class='alert alert-danger alert-dismissible fade show' role='alert'>" 
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
        include("../include/footer.php");
    ?>
</body>