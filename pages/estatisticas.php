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
include_once(__DIR__ . "/../connections/crud/Despesa.class.php");


function totalReceitasDespesas($mes)
{
    $receita = new Receita;
    $despesa = new Despesa;
    $totalReceitas = $receita->selectValorTotalReceitasByMonth($mes);
    $totalDespesas = $despesa->selectValorTotalDespesasByMonth($mes);
    $arrayTotal = array('totalDespesas' => $totalDespesas, 'totalReceitas' => $totalReceitas);

    return json_encode($arrayTotal);
}

?>

<script>
    
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

            <div style="height:300px; width:300px" id="contentDashboard">
                <div class="col-md-12">
                    <h3 class="col-12 d-flex justify-content-center">Estatísticas mensais</h3>
                    <form class="col-12" id="formSelectMes">
                        <div class="form-group">
                            <div class="col-md d-flex align-items-center justify-content-between">
                                <label for="">Filtre por mês:</label>
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

                    <div id="graficoGeral">

                    </div>
                </div>
            </div>
        </main>
    </div>

</body>

<script>
    $(document).ready(function() {

        // gráficos

        var options = {
            chart: {
                type: 'bar'
            },
            series: [{
                name: 'Valor',
                data: [34, 35]
            }],
            xaxis: {
                categories: ['Receitas', 'Despesas']
            }
        }

        var chart = new ApexCharts(document.querySelector("#graficoGeral"), options);

        chart.render();
    });
</script>

<?php
include_once("../include/footer.php");
?>