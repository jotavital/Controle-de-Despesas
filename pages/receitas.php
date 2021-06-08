<?php

include_once(__DIR__ . "/../connections/loginVerify.php");

include_once(__DIR__ . "/../connections/Connection.class.php");
$conn = new Connection;
$conexao = $conn->conectar();

$title = "Receitas";
include_once(__DIR__ . "/../include/header.php");
include_once(__DIR__ . "/modals/modalAddReceita.php");
include_once(__DIR__ . "/modals/modalDeleteReceita.php");
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

if (!isset($_GET['selectMesGraficoReceitas'])) {
    echo "<script> window.location.href = '../pages/receitas.php?selectMesGraficoReceitas=" . $mesAtual . "';</script>";
    $json = totalReceitasDespesas($mesAtual);
} else {
    $json = totalReceitasDespesas($_GET['selectMesGraficoReceitas']);
}

?>

<script>
    var mes = <?php echo $_GET['selectMesGraficoReceitas'] ?>;
</script>

<body>
    <div id="containerDashboard">

        <?php
        include_once(__DIR__ . "/../include/sideBar.php");
        ?>

        <main>

            <?php
            include_once(__DIR__ . "/../include/navBar_logged.php");
            ?>

            <div id="contentDashboard">
                <div class="col-12 mb-3 d-flex justify-content-center">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddReceita">Nova receita</button>
                </div>

                <?php
                $userId = $_SESSION['userId'];
                $sql = $conexao->prepare("SELECT r.*, c.nome_conta, c.id as id_conta FROM receita as r, conta as c WHERE r.fk_usuario = :userId AND r.fk_conta = c.id GROUP BY r.id");
                $sql->bindValue(":userId", $userId);

                try {
                    $sql->execute();
                    $data = $sql->fetchAll();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }

                ?>

                <!-- grafico receitas -->
                <div class="col-md-12 d-flex justify-content-center">
                    <div style="height:400px; width:350px" id="contentDashboard">
                        <div class="col-md-12">
                            <h3 class="col-12 d-flex justify-content-center">Estatísticas mensais</h3>
                            <form class="col-12" method="GET" action="../pages/receitas.php" id="formSelectMes">
                                <div class="form-group">
                                    <div class="col-md mb-3 d-flex align-items-center justify-content-between">
                                        <label for="selectMesGraficoReceitas">Filtre por mês:</label>
                                        <div class="col-6">
                                            <select class="form-select" name="selectMesGraficoReceitas" id="selectMesGraficoReceitas">
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
                                $('#selectMesGraficoReceitas').val(mes);
                            </script>

                            <div id="graficoReceitas">

                            </div>
                        </div>
                    </div>
                </div>

                <!-- tabela do dataTables -->
                <div class="d-flex justify-content-center">
                    <div class="col-12 tableReceitas" id="tableReceitasContainer">
                        <table id="tableReceitas" class="tabela display">
                            <thead>
                                <tr>
                                    <th>Descrição</th>
                                    <th>Data</th>
                                    <th>Valor</th>
                                    <th>Conta</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                foreach ($data as $row) {
                                    $valor = $row['valor'];
                                    $data_receita_formatada = date('d/m/Y', strtotime($row['data_receita']));
                                ?>

                                    <tr>
                                        <td><?php echo $row['descricao_receita'] ?></td>
                                        <td><?php echo $data_receita_formatada ?></td>
                                        <td><?php echo "<span class='p-success'><strong>" . $functions->formatarReal($valor) . "</strong></span>"; ?></td>
                                        <td><?php echo $row['nome_conta'] ?></td>
                                        <td>
                                            <div class="actionIcons col-12 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-edit"></i>
                                                <?php echo '<a href="../pages/receitas.php?delete=true&type=receita&id=' . $row['id'] . '&desc_receita=' . $row['descricao_receita'] . '&nome_conta=' . $row['nome_conta'] . "&id_conta=" . $row['id_conta'] . "&valor=" . sprintf("%.2f", $row['valor']) . '"' . 'id="btnExcluirReceita"><i class="fas fa-trash-alt"></i></a>' ?>
                                            </div>
                                        </td>
                                    </tr>

                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
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

        var optionsReceitas = {
            series: [{
                name: 'Valor total',
                data: [35, 36, 34, 36, 36, 34, 23, 24]
            }],
            stroke: {
                curve: 'smooth',
            },
            markers: {
                size: 7
            },
            chart: {
                type: 'line',
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
            }
        };

        if ($('#selectMesGraficoReceitas').val() == mesAtual) {
            var chart = new ApexCharts(document.querySelector("#graficoReceitas"), optionsReceitas);
            chart.render();
        } else {
            var chart = new ApexCharts(document.querySelector("#graficoReceitas"), optionsReceitas);
            chart.render();
        }


        $('#selectMesGraficoReceitas').change(function() {

            $('#formSelectMes').submit();

        });


    });
</script>

<?php
include_once(__DIR__ . "/../include/footer.php");

if (@$_GET['delete'] != null && @$_GET['delete'] == "true") {
    echo    "<script>
                $(document).ready(function(){
                    $('#modalDeleteReceita').modal('show');
                });
            </script>";
}

?>

<script>
    $(document).ready(function() {

        $('#modalDeleteReceita').on('hidden.bs.modal', function() {
            window.history.pushState(null, null, window.location.pathname);
        });
    });
</script>