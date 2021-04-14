<?php
    $title = "Login"; //titulo para o header.php
    include("../include/header.php"); //cabecalho da pagina
    setTitulo($title); //passa titulo pro header.php
?>

<body>
    <div id="container">
        <div class="divForm">
            <form action="#" method="" id="formLogin" class="col-5">
                <h1>Entrar</h1>
                <br>
                <div class="row d-flex justify-content-center">
                    <div class="col-8">
                        <div class="form-floating mb-3"> 
                            <input type="email" class="form-control" placeholder="E-mail">
                            <label class="floatingLabel">E-mail</label>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-8">
                        <div class="form-floating mb-3 d-flex justify-content-center">
                            <input type="password" class="form-control" placeholder="Senha">
                            <label class="floatingLabel">Senha</label>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    <p>Ainda não tem cadastro? <a href="register.php">Cadastre-se aqui</a></p>
                </div>
                <div class="mt-2 row d-flex justify-content-center">
                    <div class="col-8">
                        <div class="d-grid d-sm-flex justify-content-sm-center">
                            <button type="button" class="btn btn-success">Pronto!</button>
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