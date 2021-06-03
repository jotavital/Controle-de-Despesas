<?php

include_once("../connections/loginVerify.php");
include_once("../connections/Connection.class.php");
$conn = new Connection;
$conexao = $conn->conectar();

$title = "Estatísticas";
include_once("../include/header.php");
include_once(__DIR__ . "/../include/header.php");
setTitulo($title);

include_once(__DIR__ . "/../connections/crud/Receita.class.php");
$receita = new Receita;
include_once(__DIR__ . "/../connections/crud/Despesa.class.php");
$despesa = new Despesa;

?>

<body>
    <div id="containerDashboard">

        <?php
        include_once("../include/sideBar.php");
        ?>

        <main>

            <?php
            include_once("../include/navBar_logged.php");

            $totalReceitas = $receita->selectValorTotalReceitasByMonth(6);
            $totalDespesas = $despesa->selectValorTotalDespesasByMonth(6);
            ?>

            <div style="height:300px; width:300px" id="contentDashboard">
                <div class="row col-md">
                    <h3>Estatísticas mensais</h3>
                    <div id="chart">
                    </div>
                </div>
                <div class="row col-md">
                    <div id="chart2">
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>

<script>

    var totalReceitas = <?php echo json_encode($totalReceitas); ?>;
    var totalDespesas = <?php echo json_encode($totalDespesas); ?>;

    var options = {
        chart: {
            type: 'bar'
        },
        series: [{
            name: 'Valor',
            data: [totalReceitas[0], totalDespesas[0]]
        }],
        xaxis: {
            categories: ['Receitas', 'Despesas']
        }
    }

    var chart = new ApexCharts(document.querySelector("#chart"), options);

    chart.render();
</script>

<?php
include_once("../include/footer.php");
?>