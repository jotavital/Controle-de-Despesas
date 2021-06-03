<?php

include_once(__DIR__ . "/../connections/loginVerify.php");

include_once(__DIR__ . "/../connections/Connection.class.php");
$conn = new Connection;
$conexao = $conn->conectar();

$title = "Dashboard";
include_once(__DIR__ . "/../include/header.php");
include_once(__DIR__ . "/../pages/modals/modalAddConta.php");
include_once(__DIR__ . "/../pages/modals/modalAddDespesa.php");
include_once(__DIR__ . "/../pages/modals/modalAddReceita.php");
setTitulo($title);

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

            <div id="contentDashboard">
                <div class="row cardsContainer">
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex justify-content-center">Contas</h5>
                                <p class="card-text d-flex justify-content-center">Adicione suas contas</p>
                                <div class="row col-sm d-flex justify-content-center">
                                    <button class="btn btn-outline-success col-sm me-3" data-bs-toggle="modal" data-bs-target="#modalAddConta">Adicionar</button>
                                    <a href="../pages/contas.php" class="btn btn-outline-primary col-sm">Ver tudo</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex justify-content-center">Despesas</h5>
                                <p class="card-text d-flex justify-content-center">Adicione seus gastos</p>
                                <div class="row col-sm d-flex justify-content-center">
                                    <button class="btn btn-outline-success col-sm me-3" data-bs-toggle="modal" data-bs-target="#modalAddDespesa">Adicionar</button>
                                    <a href="../pages/despesas.php" class="btn btn-outline-primary col-sm">Ver tudo</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex justify-content-center">Receitas</h5>
                                <p class="card-text d-flex justify-content-center">Adicione seus ganhos</p>
                                <div class="row col-sm d-flex justify-content-center">
                                    <button class="btn btn-outline-success col-sm me-3" data-bs-toggle="modal" data-bs-target="#modalAddReceita">Adicionar</button>
                                    <a href="../pages/receitas.php" class="btn btn-outline-primary col-sm">Ver tudo</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

<?php
include_once(__DIR__ . "/../include/footer.php");
?>