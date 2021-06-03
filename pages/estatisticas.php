<?php

include_once("../connections/loginVerify.php");

include_once("../connections/Connection.class.php");
$conn = new Connection;
$conexao = $conn->conectar();

$title = "Estatísticas";
include_once("../include/header.php");
include_once(__DIR__ . "/../include/header.php");

include_once(__DIR__ . "/../connections/crud/Receita.class.php");

setTitulo($title);

?>

<body>
    <div id="containerDashboard">

        <?php
        include_once("../include/sideBar.php");
        ?>

        <main>

            <?php
            include_once("../include/navBar_logged.php");
            ?>

            <div style="height:300px; width:300px" id="contentDashboard">
                <div class="row col-md">
                    <h3>Este mês</h3>
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

    var options = {
        chart: {
            type: 'bar'
        },
        series: [{
            name: 'sales',
            data: [300, 450, 356]
        }],
        xaxis: {
            categories: ['Receitas', 'Despesas', 'Geral']
        }
    }

    var chart = new ApexCharts(document.querySelector("#chart"), options);

    chart.render();
</script>

<?php
include_once("../include/footer.php");
?>