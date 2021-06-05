<?php

include_once("../connections/loginVerify.php");
include_once("../connections/Connection.class.php");
$conn = new Connection;
$conexao = $conn->conectar();

$title = "Estatísticas";
include_once("../include/header.php");
include_once(__DIR__ . "/../include/header.php");
setTitulo($title);

include_once(__DIR__ . "/../connections/classes/Receita.class.php");
include_once(__DIR__ . "/../connections/classes/Despesa.class.php");


function totalReceitasDespesas($mes)
{
    $receita = new Receita;
    $despesa = new Despesa;
    $totalReceitas = $receita->selectValorTotalReceitasByMonth($mes);
    $totalDespesas = $despesa->selectValorTotalDespesasByMonth($mes);
    $arrayTotal = array('totalDespesas' => $totalDespesas, 'totalReceitas' => $totalReceitas);

    return json_encode($arrayTotal);
}

if (!isset($_GET['selectMesGraficoGeral'])) {
    header("Location: ../pages/estatisticas.php?selectMesGraficoGeral=" . $mesAtual);
    $json = totalReceitasDespesas($mesAtual);
} else {
    $json = totalReceitasDespesas($_GET['selectMesGraficoGeral']);
}

?>

<script>
    var mes = <?php echo $_GET['selectMesGraficoGeral'] ?>;
</script>

<body>
    <div id="containerDashboard">

        <?php
        include_once("../include/sideBar.php");
        ?>

        <main>

            <?php
            include_once("../include/navBar_logged.php");
            ?>

            <div style="height:400px; width:350px" id="contentDashboard">
                <div class="col-md-12">
                    <h3 class="col-12 d-flex justify-content-center">Estatísticas mensais</h3>
                    <form class="col-12" method="GET" action="../pages/estatisticas.php" id="formSelectMes">
                        <div class="form-group">
                            <div class="col-md mb-3 d-flex align-items-center justify-content-between">
                                <label for="selectMesGraficoGeral">Filtre por mês:</label>
                                <div class="col-6">
                                    <select class="form-select" name="selectMesGraficoGeral" id="selectMesGraficoGeral">
                                        <option value="0" selected class="hide"></option>
                                        <option value="1">Janeiro</option>
                                        <option value="2">Fevereiro</option>
                                        <option value="3">Março</option>
                                        <option value="4">Abril</option>
                                        <option value="5">Maio</option>
                                        <option value="6">Junho</option>
                                        <option value="7">Julho</option>
                                        <option value="8">Agosto</option>
                                        <option value="9">Setembro</option>
                                        <option value="10">Outubro</option>
                                        <option value="11">Novembro</option>
                                        <option value="12">Dezembro</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>

                    <script>
                        $('#selectMesGraficoGeral').val(mes);
                    </script>

                    <div id="graficoGeral">

                    </div>
                </div>
            </div>
        </main>
    </div>

</body>

<script>
    $(document).ready(function() {
        var json = <?php echo $json; ?>;
        var mesAtual = <?php echo $mesAtual; ?>;

        // gráficos
        var options = {
            series: [{
                name: 'Valor total',
                data: [json['totalDespesas'][0], json['totalReceitas'][0]]
            }],
            chart: {
                type: 'bar',
                width: '100%',
                height: '100%'
            },
            plotOptions: {
                bar: {
                    barHeight: '100%',
                    distributed: true
                }
            },
            colors: ['#CF1C1C', '#239E18'],
            xaxis: {
                categories: ['Despesas', 'Receitas'],
                labels: {
                    show: false
                }
            },
            title: {
                text: 'Mês atual',
                align: 'center',
                floating: true
            },
            subtitle: {
                text: 'Valor mensal de receitas e despesas em reais',
                align: 'center',
                margin: 15
            }
        };

        var newOptions = {
            series: [{
                data: [json['totalDespesas'][0], json['totalReceitas'][0]]
            }],
            chart: {
                type: 'bar',
                width: '100%',
                height: '100%'
            },
            plotOptions: {
                bar: {
                    barHeight: '100%',
                    distributed: true
                }
            },
            colors: ['#CF1C1C', '#239E18'],
            xaxis: {
                categories: ['Despesas', 'Receitas'],
                labels: {
                    show: false
                }
            },
            title: {
                text: 'Mês de ' + $('#selectMesGraficoGeral :selected').text(),
                align: 'center',
                floating: true
            },
            subtitle: {
                text: 'Valor mensal de receitas e despesas em reais',
                align: 'center',
                margin: 15
            }
        };

        if ($('#selectMesGraficoGeral').val() == mesAtual) {
            var chart = new ApexCharts(document.querySelector("#graficoGeral"), options);
            chart.render();
        } else {
            var chart = new ApexCharts(document.querySelector("#graficoGeral"), newOptions);
            chart.render();
        }


        $('#selectMesGraficoGeral').change(function() {

            $('#formSelectMes').submit();

        });


    });
</script>

<?php
include_once("../include/footer.php");
?>