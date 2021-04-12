<?php
    $title = "Login"; //titulo para o header.php
    include("../include/header.php"); //cabecalho da pagina
    setTitulo($title); //passa titulo pro header.php
?>

<body>
    <div id="container">
        <div class="divForm">
            <form action="#" method="" id="formulario">
                <h1>Entrar</h1>
                <br>
                <form>
                    <div class="form-floating mb-3 d-flex justify-content-center"> 
                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                        <label class="floatingLabel" for="floatingInput">Email address</label>
                    </div>
                    <div class="form-floating mb-3 d-flex justify-content-center">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                        <label class="floatingLabel" for="floatingPassword">Password</label>
                    </div>
                    <button type="button" class="btn btn-success">Pronto!</button>
            </form>
        </div>
    </div>

    <?php
        include("../include/footer.php");
    ?>
</body>