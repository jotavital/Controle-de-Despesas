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
include_once(__DIR__ . "/modals/modalReajusteSaldo.php");
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
                        $dataToEdit = base64_encode(serialize($row));

                        $categoria = $categoriaObj->selectAllFromCategoria("id = " . $row['fk_categoria']);
                    ?>

                        <div class="card mb-3 ms-3 col-4 br-25 overflow-hidden position-static">
                            <div class="card-header col-12 bg-light-blue overflow-auto d-flex justify-content-between align-items-center">
                                <div class="col-10">
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
                                <div class="col-2 d-flex align-items-center">
                                    <div class="col-12 d-flex justify-content-center" style="cursor:pointer;">
                                        <div class="dropdown d-flex justify-content-center" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-h" style="font-size:30px;"></i>
                                        </div>
                                        <ul class="dropdown-menu">
                                            <form method="post" action="?edit=true">
                                                <input type="hidden" name="newRow" value="<?php echo $dataToEdit; ?>">
                                                <button type="submit" class="p-0 col-12 justify-content-start iconButton">
                                                    <a class="btnEditarConta dropdown-item">
                                                        <li class="d-flex justify-content-start align-items-center">
                                                            <i class="me-2 fas fa-edit p-gray"></i>
                                                            Editar
                                                        </li>
                                                    </a>
                                                </button>
                                            </form>
                                            <form action="?reajuste=true" method="post">
                                                <input type="hidden" name="newRow" value="<?php echo $dataToEdit; ?>">
                                                <button type="submit" class="p-0 col-12 justify-content-start iconButton">
                                                    <a class="btnReajusteSaldo dropdown-item">
                                                        <li class="d-flex justify-content-start align-items-center">
                                                            <i class="me-2 fas fa-wrench p-gray"></i>
                                                            Reajustar saldo
                                                        </li>
                                                    </a>
                                                </button>
                                            </form>
                                            <form action="?delete=true" method="post">
                                                <input type="hidden" name="newRow" value="<?php echo $dataToEdit; ?>">
                                                <button type="submit" class="p-0 col-12 justify-content-start iconButton">
                                                    <a class="dropdown-item">
                                                        <li class="d-flex justify-content-start align-items-center">
                                                            <i class="me-2 fas fa-trash p-gray" style="width:16px"></i>
                                                            Excluir
                                                        </li>
                                                    </a>
                                                </button>
                                            </form>
                                            <a class="dropdown-item" href="../pages/transacoes.php">
                                                <li class="d-flex justify-content-start align-items-center">
                                                    <i class="me-2 fas fa-history p-gray"></i>
                                                    Transações
                                                </li>
                                            </a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4 col-12">
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

if (@$_GET['reajuste'] != null && @$_GET['reajuste'] == "true") {
    echo    "<script>$(document).ready(function(){
                $('#modalReajusteSaldo').modal('show');
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

        $('#modalReajusteSaldo').on('hidden.bs.modal', function() {
            window.history.pushState(null, null, window.location.pathname);
        });
    });
</script>