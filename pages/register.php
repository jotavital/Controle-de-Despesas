<?php
    $title = "Cadastro";
    include("../include/header.php");
    setTitulo($title);
?>

<div id="container">
    <div class="divForm">
        <form action="#" method="" id="formulario" class="col-5">
            <h1>Cadastro</h1>
            <br>
            <div class="row d-flex justify-content-center">
                <div class="col-8">
                    <div class="form-floating mb-3"> 
                        <input type="email" class="form-control" placeholder="name@example.com">
                        <label class="floatingLabel">E-mail</label>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-8">
                    <div class="form-floating mb-3 d-flex justify-content-center">
                        <input type="password" class="form-control" placeholder="Password">
                        <label class="floatingLabel">Senha</label>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-8">
                    <div class="form-floating mb-3 d-flex justify-content-center">
                        <input type="password" class="form-control" placeholder="Password">
                        <label class="floatingLabel">Confirme a senha</label>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
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