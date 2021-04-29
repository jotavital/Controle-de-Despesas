<?php
include("../connections/loginVerify.php");
$title = "Carteiras";
include("../include/header.php");
setTitulo($title);
?>

<body>
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
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddConta">Nova conta</button>
                </div>
                <div class="row col-12 cardsContainer" id="containerCardsContas">
                    <?php
                    $sql = $conn->prepare("SELECT * FROM conta");
                    $sql->execute();
                    $data = $sql->fetchAll();

                    foreach ($data as $row) {
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
                                        <a href="#" class="btn btn-outline-danger col-sm">Excluir</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modalAddConta" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalAddContaLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalAddContaLabel">Adicione uma conta</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <form method="POST" id="formAddContas">
                                        <div class="mb-3">
                                            <label for="nomeContaInput" class="form-label">Nome da conta</label>
                                            <input type="text" class="form-control" id="nomeContaInput" name="nomeConta" aria-describedby="Nome" placeholder="Ex.: Minha Poupança">
                                        </div>
                                        <div class="mb-3">
                                            <label for="saldoInput" class="form-label">Saldo atual</label>
                                            <input type="text" class="form-control" name="saldoConta" id="saldoInput" onkeypress="$(this).mask('000.000.000,00', {reverse: true});">
                                        </div>
                                        <div class="mb-3">
                                            <label for="categoriaSelect" class="form-label">Categoria</label>
                                            <select class="form-select" name="categoriaSelect" id="categoriaSelect">
                                                <?php
                                                $sql = $conn->prepare("SELECT * FROM categoria WHERE fk_tipo = 5");
                                                $sql->execute();
                                                $data = $sql->fetchAll();

                                                foreach ($data as $row) {
                                                ?>
                                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['nome_categoria'] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-center">
                                            <button type="submit" id="submit" class="btn btn-success">Salvar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>


    <script>
        $(document).ready(function() {
            $('#formAddContas').submit(function() {
                var x = $("#saldoInput").val();
                x = x.replace(/[.]/gim, "");
                x = x.replace(/[,]/gim, ".");
                document.getElementById("saldoInput").value = x;
                var dados = jQuery(this).serialize();

                $.ajax({
                    url: '../connections/insertConta.php',
                    method: 'POST',
                    data: dados,
                    success: function(msg) {
                        $("#formAddContas").trigger('reset');
                    }
                });

                return false;
            });
        });
    </script>
</body>

<?php
include("../include/footer.php");
?>