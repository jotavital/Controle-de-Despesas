<?php
    session_start();
    include_once("../connections/conexao.php");
    $key = uniqid(md5(rand()));
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/main.css">
    <title>Controle de Despesas - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<body>
    <div id="container">
        <div class="divForm">
            <form action="#" method="" id="formulario">
                <?php 
                    //para teste de conexão ao banco
                    // if(isset($_SESSION['msg'])){
                    //     echo $_SESSION['msg'];
                    //     unset($_SESSION['msg']);
                    // }
                    // if(!$conn){
                    //     die("<div class='alert alert-danger alert-dismissible fade show' role='alert'>" . "Falha na conexão com a base de dados: " . mysqli_connect_error() . ", verifique o arquivo de conexão e tente novamente</div>");
                    // }else{
                    //     echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>" . "Conexão ao banco de dados realizada com sucesso!" . " <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                    // }
                ?>
                <h1>Entrar</h1>
                <form>
                    <div class="form-floating mb-3 d-flex justify-content-center"> 
                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                        <label class="floatingLabel" for="floatingInput">Email address</label>
                    </div>
                    <div class="form-floating mb-3 d-flex justify-content-center">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                        <label class="floatingLabel" for="floatingPassword">Password</label>
                    </div>
                    <button type="button" class="btn btn-success">Success</button>
            </form>
        </div>
    </div>
    <?php 
        mysqli_close($conn);
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>

</html>