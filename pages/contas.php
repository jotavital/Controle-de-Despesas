<?php

include_once(__DIR__ . "/../connections/loginVerify.php");

include_once(__DIR__ . "/../connections/Connection.class.php");
$conn = new Connection;
$conexao = $conn->conectar();

include_once(__DIR__ . "/../classes/Conta.class.php");
include_once(__DIR__ . "/../classes/Categoria.class.php");
$contasObj = new Conta;
$categoriaObj = new Categoria;

$title = "Contas";
include_once(__DIR__ . "/../include/header.php");
include_once(__DIR__ . "/modals/modalAddConta.php");
include_once(__DIR__ . "/modals/modalDeleteConta.php");
include_once(__DIR__ . "/modals/modalEditConta.php");
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
                <div class="col-12 mb-4 d-flex justify-content-center">
                    <button class="btn btn-success rounded-circle" data-bs-toggle="modal" data-bs-target="#modalAddConta">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="row col-12 cardsContainer d-flex justify-content-center" id="containerCardsContas">

                    <?php

                    $data = $contasObj->selectAllFromConta();

                    foreach ($data as $index => $row) {
                        $categoria = $categoriaObj->selectAllFromCategoria("id = " . $row['fk_categoria']);
                    ?>

                        <div class="card mb-3 ms-3 col-3 br-25 overflow-auto">
                            <div class="card-header col-12 bg-light-blue overflow-auto d-flex justify-content-between align-items-center">
                                <div class="col-11">
                                    <h5 class="card-title" style="margin:0;">

                                        <?php
                                        echo $row['nome_conta'];
                                        ?>

                                    </h5>
                                    <p style="margin:0;">
                                        <?php
                                        echo $categoria[0]['nome_categoria'];
                                        ?>
                                    </p>
                                </div>
                                <div class="col-1 d-flex align-items-center" style="cursor:pointer;">
                                    <div class="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v" style="font-size: 1.3rem;"></i>
                                    </div>
                                    <ul class="dropdown-menu">
                                        <?php echo '<a href="../pages/contas.php?edit=true&id=' . $row['id'] . '&nome_conta=' . $row['nome_conta'] . '&idCategoria=' . $categoria[0]['id'] . '"' . 'class="btnEditarConta dropdown-item">
                                                        <li>
                                                            <i class="fas fa-edit"></i>
                                                            Editar
                                                        </li>
                                                    </a>' ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-center">
                                    <h5>Saldo atual</h5>
                                </div>
                                <p class="card-text d-flex justify-content-center">

                                    <?php
                                    $valor = $row['saldo_atual'];
                                    if ($valor < 0) {
                                        echo "<span class='p-danger'><strong>" . $functions->formatarReal($valor) . "</strong></span>";
                                    } else {
                                        echo "<span class='p-success'><strong>" . $functions->formatarReal($valor) . "</strong></span>";
                                    }

                                    ?>

                                </p>
                                <div class="col-sm d-flex justify-content-center">
                                    <a href="#" class="btn btn-outline-primary col-sm me-3">Transações</a>
                                    <?php echo '<a href="../pages/contas.php?delete=true&id=' . $row['id'] . '&nome_conta=' . $row['nome_conta'] . "&saldo_atual=" . sprintf("%.2f", $row['saldo_atual']) . '"' . 'class="btn btn-outline-danger col-sm btnExcluirConta">Excluir</a>' ?>
                                </div>
                            </div>
                        </div>

                    <?php
                    }
                    ?>

                </div>

            </div>
        </main>
    </div>
</body>

<?php
include_once(__DIR__ . "/../include/footer.php");
?>

<?php

if (@$_GET['delete'] != null && @$_GET['delete'] == "true") {
    echo    "<script>$(document).ready(function(){
                $('#modalDeleteConta').modal('show');
            });</script>";
}

if (@$_GET['edit'] != null && @$_GET['edit'] == "true") {
    echo    "<script>$(document).ready(function(){
                $('#modalEditConta').modal('show');
            });</script>";
}

?>

<script>
    $(document).ready(function() {
        $('#modalDeleteConta').on('hidden.bs.modal', function() {
            window.history.pushState(null, null, window.location.pathname);
        });

        $('#modalEditConta').on('hidden.bs.modal', function() {
            window.history.pushState(null, null, window.location.pathname);
        });
    });
</script>