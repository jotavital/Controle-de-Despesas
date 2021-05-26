<?php
include("../connections/loginVerify.php");
$title = "Dashboard";
include("../include/header.php");
include("../pages/modals/modalAddConta.php");
include("../pages/modals/modalAddDespesa.php");
include("../pages/modals/modalAddReceita.php");
setTitulo($title);
?>

<body>
    <div id="containerDashboard">
        <?php
        include("../include/sideBar.php");
        ?>
        <main>
            <?php
            include("../include/navBar_logged.php");
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
include("../include/footer.php");
?>