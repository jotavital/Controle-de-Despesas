<?php
    session_start();
    $title = "Cadastro";
    include("../include/header.php");
    setTitulo($title);

    if(isset($_SESSION['userEmail'])){
        if($_SESSION['userEmail']){
            header("Location: ../pages/dashboard.php");
        }
    }
    
    include("../include/navBar_unlogged.php");
?>

<div id="container">
    <div class="divForm">
        <form action="../connections/registerUser.php" method="POST" id="formRegister" class="col-5 needs-validation" novalidate>
        <img style="display: block; margin-left: auto; margin-right: auto; width: 180px" src="../image/apresentação.png" alt="">
                <h1 style="font-weight: bolder; font-style: italic; font-size: 3em; text-align: center; color: #86EB51; margin-top: 5px; text-shadow: 4px 4px 3px #3D6B24">EasyLize Finanças</h1>
            <h1 class="mb-4">Cadastro</h1>
            <div class="row g-2 col-md">
                <div class="col-md">
                    <div class="form-floating mb-3"> 
                        <input type="text" name="name" id="nameInput" class="form-control" placeholder="Nome" required>
                        <label for="nameInput" class="floatingLabel">Nome</label>
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
                <div class="col-md">
                    <div class="form-floating mb-3"> 
                        <input type="text" name="surname" id="surnameInput" class="form-control" placeholder="Sobrenome" required>
                        <label for="surnameInput" class="floatingLabel">Sobrenome</label>
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
            <div class="row d-flex justify-content-md-center">
                <div class="col-md">
                    <div class="form-floating mb-3"> 
                        <input type="email" name="email" id="emailInput" class="form-control" placeholder="nome@exemplo.com" required>
                        <label for="emailInput" class="floatingLabel">E-mail</label>
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
            <div class="row d-flex justify-content-md-center">
                <div class="col-md">
                    <div class="form-floating mb-3">
                        <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Senha" required>
                        <label for="passwordInput" class="floatingLabel">Senha</label>
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
                <p>Já tem cadastro? <a style="text-decoration:none;" href="login.php">Entre aqui</a></p>
            </div>
            <div class="mt-2 row d-flex justify-content-center">
                <div class="col-8">
                    <div class="d-grid d-sm-flex justify-content-sm-center">
                        <button type="submit" name ="btnRegister" class="btn btn-success">Pronto!</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
    include("../include/footer.php");
?>