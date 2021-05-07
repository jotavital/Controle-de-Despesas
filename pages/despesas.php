<?php
include("../connections/loginVerify.php");
$title = "Despesas";
include("../include/header.php");
include("../pages/modals/modalAddDespesa.php");
include("../pages/modals/modalAddConta.php");
setTitulo($title);
?>

<body id="bo">
    <div id="containerDashboard">
        <?php
        include("../include/sideNav.php");
        ?>
        <main>
            <?php
            include("../include/navBar_logged.php");
            ?>
            <div id="contentDashboard">
                <div class="col-12 mb-3 d-flex justify-content-center">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddDespesa">Nova despesa</button>
                </div>
                <div class="row col-12 cardsContainer" id="containerCardsContas">
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
                                        <a href="#" class="btn btn-outline-danger col-sm">Excluir</a>
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

<script src="../js/submitForms.js"></script>

<script>
    $('#modalAddConta').on('shown.bs.modal', function() {
        document.querySelector('#containerDashboard').classList.add('second-modal-open');
    });

    $('#modalAddConta').on('hide.bs.modal', function() {
        document.querySelector('#containerDashboard').classList.remove('second-modal-open');
    });
</script>

<?php
include("../include/footer.php");
?>