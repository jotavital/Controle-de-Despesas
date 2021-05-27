<?php

include("../connections/loginVerify.php");

include("../connections/connection.php");
$conn = new Connection;
$conexao = $conn->conectar();

$title = "Contas";
include("../include/header.php");
include("../pages/modals/modalAddConta.php");
include("../pages/modals/modalDeleteConta.php");
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
                <h3 class="mb-4 d-flex justify-content-center">Contas</h3>
                <div class="col-12 mb-3 d-flex justify-content-center">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddConta">Nova conta</button>
                </div>
                <div class="row col-12 cardsContainer" id="containerCardsContas">

                    <?php
                    $userId = $_SESSION['userId'];
                    $sql = $conexao->prepare("SELECT * FROM conta WHERE fk_usuario = :userId");
                    $sql->bindValue(":userId", $userId);
                    $sql->execute();
                    $data = $sql->fetchAll();

                    foreach ($data as $index => $row) {
                    ?>

                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body p-4">
                                    <h5 class="card-title d-flex justify-content-center">

                                        <?php
                                        echo $row['nome_conta'];
                                        ?>

                                    </h5>
                                    <p class="card-text d-flex justify-content-center">

                                        <?php
                                        $valor = $row['saldo_atual'];
                                        $formatter = new NumberFormatter('pt_BR',  NumberFormatter::CURRENCY);
                                        echo ($formatter->formatCurrency($valor, 'BRL'));
                                        ?>

                                    </p>
                                    <div class="row col-sm d-flex justify-content-center">
                                        <a href="#" class="btn btn-outline-primary col-sm me-3">Gerenciar</a>
                                        <?php echo '<a href="../pages/contas.php?delete=true&id=' . $row['id'] . '&nome_conta=' . $row['nome_conta'] . "&saldo_atual=" . sprintf("%.2f", $row['saldo_atual']) . '"' . 'class="btn btn-outline-danger col-sm btnExcluirConta">Excluir</a>' ?>
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
                $('#modalDeleteConta').modal('show');
            });</script>";
}

?>