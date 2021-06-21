<?php

include_once(__DIR__ . "/../connections/loginVerify.php");

include_once(__DIR__ . "/../connections/Connection.class.php");
$conn = new Connection;
$conexao = $conn->conectar();

$title = "Metas";
include_once(__DIR__ . "/../include/header.php");
setTitulo($title);

include_once(__DIR__ . "/../pages/modals/modalAddMeta.php");
include_once(__DIR__ . "/../pages/modals/modalDepositoMeta.php");
include_once(__DIR__ . "/../pages/modals/modalEditMeta.php");
include_once(__DIR__ . "/../pages/modals/modalAddCategoriaMeta.php");
include_once(__DIR__ . "/../classes/Meta.class.php");

$metaObj = new Meta;

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
                    <button class="btn btn-success rounded-circle" data-bs-toggle="modal" data-bs-target="#modalAddMeta">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="row col-12 cardsContainer d-flex justify-content-center" id="containerCardsMetas">

                    <?php

                    $data = $metaObj->selectAllFromMeta();

                    foreach ($data as $index => $row) {
                        $dataToEdit = base64_encode(serialize($row));

                    ?>

                        <div class="card mb-3 ms-3 col-4 br-25 overflow-hidden position-static">
                            <div class="card-header col-12 bg-light-blue overflow-auto d-flex justify-content-between align-items-center">
                                <div class="col-10">
                                    <h5 class="card-title" style="margin:0;">

                                        <?php

                                        echo $row['nome_meta'];

                                        ?>

                                    </h5>
                                    <p style="margin:0;">

                                        <?php

                                        echo date('d/m/Y', strtotime($row['prazo_meta']));

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
                                                    <a class="btnEditarMeta dropdown-item">
                                                        <li class="d-flex justify-content-start align-items-center">
                                                            <i class="me-2 fas fa-edit p-gray"></i>
                                                            Editar
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
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4 col-12">
                                <div class="row d-flex justify-content-center mb-3 valores">
                                    <div class="col d-flex flex-column justify-content-center">
                                        <h6 class="d-flex justify-content-center p-gray">Valor total</h6>
                                        <p class="card-text d-flex justify-content-center">
                                            <strong> <?php echo $functions->formatarReal($row['valor_total']); ?> </strong>
                                        </p>
                                    </div>
                                    <div class="col d-flex flex-column justify-content-center">
                                        <h6 class="d-flex justify-content-center p-gray">Valor atingido</h6>
                                        <p class="card-text d-flex justify-content-center">
                                            <strong> <?php echo $functions->formatarReal($row['valor_atingido']); ?> </strong>
                                        </p>
                                    </div>
                                </div>

                                <?php

                                $porcentagemAtingida = $functions->calcularPorcentagem($row['valor_atingido'], $row['valor_total']);

                                ?>

                                <div class="mb-3 progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $porcentagemAtingida ?>%;" aria-valuenow="<?php echo $porcentagemAtingida ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $porcentagemAtingida ?>%</div>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <form action="?depositoMeta=true" method="post">
                                        <input type="hidden" name="newRow" value="<?php echo $dataToEdit; ?>">
                                        <button type="submit" class="btn btn-outline-primary">
                                            Depositar
                                        </button>
                                    </form>
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

if (isset($_POST['newRow'])) {

    if (@$_GET['depositoMeta'] != null && @$_GET['depositoMeta'] == "true") {


        echo    "<script>
                    $(document).ready(function(){
                        $('#modalDepositoMeta').modal('show');
                    });
                </script>";
    }

    if (@$_GET['edit'] != null && @$_GET['edit'] == "true") {


        echo    "<script>
                    $(document).ready(function(){
                        $('#modalEditMeta').modal('show');
                    });
                </script>";
    }
}

?>

<script>
    $(document).ready(function() {
        $('#modalDepositoMeta').on('hidden.bs.modal', function() {
            window.history.pushState(null, null, window.location.pathname);
        });

        $('#modalEditMeta').on('hidden.bs.modal', function() {
            window.history.pushState(null, null, window.location.pathname);
        });
    });
</script>