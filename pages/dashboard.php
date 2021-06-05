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
            <!-- F2F2F2 -->
            <?php
            include_once(__DIR__ . "/../include/navBar_logged.php");
            ?>

            <div id="contentDashboard">

                <div class="col-md-12 cardsContainer d-flex justify-content-center align-items-center">
                    <div class="card bg-ultralight-gray text-primary col-md-3 mb-3 me-3">
                        <div class="card-body">
                            <h5 class="card-title">Contas</h5>
                            <p>conteudo</p>
                        </div>
                        <div class="card-footer d-flex justify-content-center" style="border:none;">
                            <span data-bs-toggle="modal" data-bs-target="#modalAddConta">
                                <button class="btn btn-primary btn-circle me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Nova conta">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </span>
                            <a href="../pages/contas.php">
                                <button class="btn bg-orange btn-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Todas as contas">
                                    <i class="fas fa-list"></i>
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="card bg-ultralight-gray text-success col-md-3 mb-3 me-3">
                        <div class="card-body">
                            <h5 class="card-title">Receitas</h5>
                            <p>conteudo</p>
                        </div>
                        <div class="card-footer d-flex justify-content-center" style="border:none;">
                            <span data-bs-toggle="modal" data-bs-target="#modalAddReceita">
                                <button class="btn btn-success btn-circle me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Nova receita">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </span>
                            <a href="../pages/receitas.php">
                                <button class="btn bg-orange btn-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Todas as receitas">
                                    <i class="fas fa-list"></i>
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="card bg-ultralight-gray text-danger col-md-3 mb-3 me-3">
                        <div class="card-body">
                            <h5 class="card-title">Despesas</h5>
                            <p>conteudo</p>
                        </div>
                        <div class="card-footer d-flex justify-content-center" style="border:none;">
                            <span data-bs-toggle="modal" data-bs-target="#modalAddDespesa">
                                <button class="btn btn-danger btn-circle me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Nova despesa">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </span>
                            <a href="../pages/despesas.php">
                                <button class="btn bg-orange btn-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Todas as receitas">
                                    <i class="fas fa-list"></i>
                                </button>
                            </a>
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