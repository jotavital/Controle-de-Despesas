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

include_once(__DIR__ . "/../connections/classes/Despesa.class.php");
include_once(__DIR__ . "/../connections/classes/Receita.class.php");
include_once(__DIR__ . "/../connections/classes/Conta.class.php");

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

            <div id="contentDashboard">

                <div class="col-md-12 cardsContainer d-flex justify-content-center align-items-center">
                    <div class="card bg-ultralight-gray text-danger col-md-3 mb-3 me-3">
                        <div class="card-body">
                            <div>
                                <div class="cardTitle d-flex justify-content-center">
                                    <h5 class="card-title">Despesas</h5>
                                </div>
                                <div class="cardContent d-flex justify-content-center">
                                    <p id="avisoDespesa"></p>
                                    <div id="graficoDespesas">

                                    </div>
                                </div>
                            </div>
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
                    <div class="card bg-ultralight-gray text-success col-md-3 mb-3 me-3">
                        <div class="card-body">
                            <div>
                                <div class="cardTitle d-flex justify-content-center">
                                    <h5 class="card-title">Receitas</h5>
                                </div>
                                <div class="cardContent d-flex justify-content-center">
                                    <p id="avisoReceita"></p>
                                    <div id="graficoReceitas">

                                    </div>
                                </div>
                            </div>
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
                    <div class="card bg-ultralight-gray text-primary col-md-3 mb-3 me-3">
                        <div class="card-body">
                            <div>
                                <div class="cardTitle d-flex justify-content-center">
                                    <h5 class="card-title">Saldo total em conta</h5>
                                </div>
                                <div class="cardContent d-flex justify-content-center">
                                    <h4><?php echo $functions->formatarReal($saldoTotal); ?></h4>
                                </div>
                            </div>
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
                </div>

            </div>

        </main>
    </div>
</body>



<script>
    $(document).ready(function() {
        var totalDespesas = <?php echo $totalDespesasMes[0]; ?>;
        var totalReceitas = <?php echo $totalReceitasMes[0]; ?>;

        // gráficos
        var optionsDespesas = {
            series: [{
                name: 'Valor total',
                data: [totalDespesas]
            }],
            chart: {
                type: 'bar',
                width: '100%',
                height: '100%'
            },
            plotOptions: {
                bar: {
                    barHeight: '100%',
                    distributed: false
                }
            },
            colors: ['#CF1C1C'],
            xaxis: {
                categories: ['Despesas'],
                labels: {
                    show: false
                }
            },
            title: {
                text: 'Este mês',
                align: 'center',
                floating: true
            }
        };

        var optionsReceitas = {
            series: [{
                name: 'Valor total',
                data: [totalReceitas]
            }],
            chart: {
                type: 'bar',
                width: '100%',
                height: '100%'
            },
            plotOptions: {
                bar: {
                    barHeight: '100%',
                    distributed: false
                }
            },
            colors: ['#239E18'],
            xaxis: {
                categories: ['Receitas'],
                labels: {
                    show: false
                }
            },
            title: {
                text: 'Este mês',
                align: 'center',
                floating: true
            }
        };

        if (!totalReceitas == 0) {
            var chartReceitas = new ApexCharts(document.querySelector("#graficoReceitas"), optionsReceitas);
            chartReceitas.render();
        } else {
            document.getElementById('avisoReceita').textContent = "Nenhuma receita ainda!";
        }

        if (!totalDespesas == 0) {
            var chartDespesas = new ApexCharts(document.querySelector("#graficoDespesas"), optionsDespesas);
            chartDespesas.render();
        } else {
            document.getElementById('avisoDespesa').textContent = "Nenhuma despesa ainda!";
        }
    });
</script>

<?php
include_once(__DIR__ . "/../include/footer.php");
?>