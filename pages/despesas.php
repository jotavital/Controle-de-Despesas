<?php

include("../connections/loginVerify.php");
$title = "Despesas";
include("../include/header.php");
include("../pages/modals/modalAddDespesa.php");
include("../pages/modals/modalDeleteDespesa.php");
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
                <div class="row">
                    <h3 class="mb-4 d-flex justify-content-center">Despesas</h3>
                </div>
                <div class="col-12 mb-3 d-flex justify-content-center">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddDespesa">Nova despesa</button>
                </div>
                <div class="row col-12 cardsContainer" id="containerCardsDespesas">

                    <?php
                    $userId = $_SESSION['userId'];
                    $sql = $conn->prepare("SELECT * FROM despesa WHERE fk_usuario = :userId");
                    $sql->bindValue(":userId", $userId);
                    $sql->execute();
                    $data = $sql->fetchAll();

                    foreach ($data as $row) {
                    ?>

                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body p-4">
                                    <h5 class="card-title d-flex justify-content-center">

                                        <?php
                                        echo $row['descricao_despesa'];
                                        ?>

                                    </h5>
                                    <p class="card-text d-flex justify-content-center">

                                        <?php
                                        $valor = $row['valor'];
                                        $formatter = new NumberFormatter('pt_BR',  NumberFormatter::CURRENCY);
                                        echo ($formatter->formatCurrency($valor, 'BRL'));
                                        ?>

                                    </p>
                                    <div class="row col-sm d-flex justify-content-center">
                                        <a href="#" class="btn btn-outline-primary col-sm me-3">Editar</a>
                                        <?php echo '<a href="../pages/despesas.php?delete=true&id=' . $row['id'] . '&desc_despesa=' . $row['descricao_despesa'] . '&valor=' . sprintf("%.2f", $row['valor']) . '"' . 'class="btn btn-outline-danger col-sm btnExcluirDespesa">Excluir</a>'?>
                                    </div>
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
include("../include/footer.php");
?>

<?php

    if (@$_GET['delete'] != null && @$_GET['delete'] == "true") {
        echo    "<script>$(document).ready(function(){
                    $('#modalDeleteDespesa').modal('show');
                });</script>";
    }

?>