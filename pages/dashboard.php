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

include_once(__DIR__ . "/../classes/Despesa.class.php");
include_once(__DIR__ . "/../classes/Receita.class.php");
include_once(__DIR__ . "/../classes/Conta.class.php");

$despesa = new Despesa;
$receita = new Receita;
$conta = new Conta;

$totalDespesasMes = $despesa->selectValorTotalDespesasByMonth($mesAtual);
$totalReceitasMes = $receita->selectValorTotalReceitasByMonth($mesAtual);



if ($totalReceitasMes[0] == null) {
    $totalReceitasMes[0] = 0;
}

if ($totalDespesasMes[0] == null) {
    $totalDespesasMes[0] = 0;
}

$saldoTotal = $conta->selectTotalSaldoTodasContas();

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

            <div class="col-md-12" id="contentDashboard">

                <div class="row col-12 cardsContainer d-flex justify-content-center">
                    <div class="card col-md-3 mb-3 ms-3" onclick="window.location.assign('contas.php');">
                        <div class="card-body">
                            <div>
                                <div class="cardTitle d-flex justify-content-center">
                                    <h6 class="card-title">Saldo total em conta</h6>
                                </div>
                                <div class="cardContent d-flex justify-content-center">
                                    <div class="cardContent">
                                        <h4 class="<?php echo ($saldoTotal < 0) ? 'p-danger'  : 'p-primary'; ?>"><?php echo $functions->formatarReal($saldoTotal); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-3 mb-3 ms-3" onclick="window.location.assign('receitas.php');">
                        <div class="card-body">
                            <div>
                                <div class="cardTitle d-flex justify-content-center">
                                    <h6 class="card-title">Receitas</h6>
                                </div>
                                <div class="cardContent d-flex justify-content-center">
                                    <p class="p-success" id="avisoReceita"></p>
                                    <h4 class="hide p-success" id="totalReceitas">
                                        <?php

                                        echo ($functions->formatarReal($totalReceitasMes[0]));

                                        ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-3 mb-3 ms-3" onclick="window.location.assign('despesas.php');">
                        <div class="card-body">
                            <div>
                                <div class="cardTitle d-flex justify-content-center">
                                    <h6 class="card-title">Despesas</h6>
                                </div>
                                <div class="cardContent d-flex justify-content-center">
                                    <p class="p-danger" id="avisoDespesa"></p>
                                    <h4 class="hide p-danger" id="totalDespesas">
                                        <?php

                                        echo ($functions->formatarReal($totalDespesasMes[0]));

                                        ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </main>
    </div>
</body>



<script>
    $(document).ready(function() {
        var totalDespesas = <?php echo $totalDespesasMes[0]; ?>;
        var totalReceitas = <?php echo $totalReceitasMes[0]; ?>;

        if (!totalReceitas == 0) {
            document.getElementById('totalReceitas').classList.remove("hide");
        } else {
            document.getElementById('totalReceitas').classList.add("hide");
            document.getElementById('avisoReceita').textContent = "Nenhuma receita ainda!";
        }

        if (!totalDespesas == 0) {
            document.getElementById('totalDespesas').classList.remove("hide");
        } else {
            document.getElementById('totalDespesas').classList.add("hide");
            document.getElementById('avisoDespesa').textContent = "Nenhuma despesa ainda!";
        }
    });
</script>

<?php
include_once(__DIR__ . "/../include/footer.php");
?>