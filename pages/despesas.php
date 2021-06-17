<?php

include_once(__DIR__ . "/../connections/loginVerify.php");

include_once(__DIR__ . "/../connections/Connection.class.php");
$conn = new Connection;
$conexao = $conn->conectar();

$title = "Despesas";
include_once(__DIR__ . "/../include/header.php");
include_once(__DIR__ . "/modals/modalAddDespesa.php");
include_once(__DIR__ . "/modals/modalDeleteDespesa.php");
include_once(__DIR__ . "/modals/modalEditDespesa.php");
setTitulo($title);

include_once(__DIR__ . "/../classes/Despesa.class.php");

function totalDespesasTodosDiasDoMes($mes)
{
    $despesa = new Despesa;
    $totalDespesasDias = $despesa->selectValorTotalDespesasTodosDiasByMonth($mes);
    $arrayTotal = array('totalDespesasDias' => $totalDespesasDias);

    return json_encode($arrayTotal);
}


if (!isset($_GET['selectMesGraficoDespesas'])) {
    echo "<script> window.location.href = '../pages/despesas.php?selectMesGraficoDespesas=" . $mesAtual . "';</script>";
    $json = totalDespesasTodosDiasDoMes($mesAtual);
} else {
    $json = totalDespesasTodosDiasDoMes($_GET['selectMesGraficoDespesas']);
}

?>

<script>
    var mes = <?php echo $_GET['selectMesGraficoDespesas'] ?>;
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
                    <button class="btn btn-success rounded-circle" data-bs-toggle="modal" data-bs-target="#modalAddDespesa">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                <?php
                $userId = $_SESSION['userId'];
                $stm = $conexao->prepare("SELECT d.*, c.nome_conta FROM despesa as d, conta as c WHERE d.fk_usuario = :userId AND d.fk_conta = c.id GROUP BY d.id ORDER BY data_despesa DESC");
                $stm->bindValue(":userId", $userId);

                try {
                    $stm->execute();
                    $data = $stm->fetchAll();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }

                ?>

                <!-- grafico despesas -->
                <div class="col-12 d-flex justify-content-center">
                    <div class="card br-25 mb-4 col-10 overflow-auto">
                        <div class="card-header text-white bg-light-blue">
                            <h3 class="col-12 d-flex justify-content-center">Estatísticas mensais</h3>
                        </div>
                        <div class="card-body p-2">
                            <div class="col-md-12 d-flex justify-content-center">
                                <div class="d-flex align-items-center" style="height:400px; width:500px">
                                    <div class="col-md-12">
                                        <form class="col-12" method="GET" action="../pages/despesas.php" id="formSelectMes">
                                            <div class="form-group">
                                                <div class="col-md mb-3 d-flex align-items-center justify-content-between">
                                                    <label for="selectMesGraficoDespesas">Filtre por mês:</label>
                                                    <div class="col-6">
                                                        <select class="form-select" name="selectMesGraficoDespesas" id="selectMesGraficoDespesas">
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
                                            $('#selectMesGraficoDespesas').val(mes);
                                        </script>

                                        <div id="graficoDespesas">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- tabela do dataTables -->
                <div class="col-md-12 d-flex justify-content-center">
                    <div class="card br-25 col-10 overflow-auto">
                        <div class="card-header bg-danger text-white">
                            <h3 class="col-12 mb-3 d-flex justify-content-center">Todas as despesas</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                <div class="col-12 tableDespesas" id="tableDespesasContainer">
                                    <table id="tableDespesas" class="tabela table hover order-column row-border table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="d-flex justify-content-center">
                                                        Descrição
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="d-flex justify-content-center">
                                                        Data
                                                        <div class="ms-2 iconOrdenacao">
                                                            <i class="p-warning fas fa-sort-amount-down"></i>
                                                        </div>
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="d-flex justify-content-center">
                                                        Vencimento
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="d-flex justify-content-center">
                                                        Valor
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="d-flex justify-content-center">
                                                        Conta
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="d-flex justify-content-center">
                                                        Ações
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            foreach ($data as $row) {
                                                $valor = $row['valor'];
                                                $data_despesa_formatada = date('d/m/Y', strtotime($row['data_despesa']));
                                                $data_vencimento_formatada = ($row['data_vencimento'] == "0000-00-00") ? ("-") : date('d/m/Y', strtotime($row['data_vencimento']));
                                            ?>

                                                <tr>
                                                    <td><?php echo $row['descricao_despesa'] ?></td>
                                                    <td><?php echo $data_despesa_formatada ?></td>
                                                    <td><?php echo $data_vencimento_formatada ?></td>
                                                    <td><?php echo "<span class='p-danger'><strong>" . $functions->formatarReal($valor) . "</strong></span>"; ?></td>
                                                    <td><?php echo $row['nome_conta'] ?></td>
                                                    <td>
                                                        <div class="actionIcons col-12 d-flex align-items-center justify-content-center">
                                                            <?php echo '<a href="' . $_SERVER["REQUEST_URI"] . '&edit=true"' . 'id="btnEditDespesa" class="me-2">
                                                                            <i class="fas fa-edit"></i>
                                                                        </a>'
                                                            ?>
                                                            <?php echo '<a href="' . $_SERVER["REQUEST_URI"] . '&delete=true&type=despesa&id=' . $row['id'] . '&desc_despesa=' . $row['descricao_despesa'] . '&id_conta=' . $row['fk_conta'] . '&nome_conta=' . $row['nome_conta'] . "&valor=" . sprintf("%.2f", $row['valor']) . '"' . 'id="btnExcluirDespesa">
                                                                            <i class="fas fa-trash-alt"></i>
                                                                        </a>'
                                                            ?>
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
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>

<?php
include_once(__DIR__ . "/../include/footer.php");
?>

<?php

if (@$_GET['delete'] != null && @$_GET['delete'] == "true") {
    echo    "<script>$(document).ready(function(){
                $('#modalDeleteDespesa').modal('show');
            });</script>";
}

if (@$_GET['edit'] != null && @$_GET['edit'] == "true") {
    echo    "<script>$(document).ready(function(){
                $('#modalEditDespesa').modal('show');
            });</script>";
}

?>

<script>
    $(document).ready(function() {
        var dias = new Array();

        for (var i = 1; i <= 31; i++) {
            dias.push(i);
        }

        var json = <?php echo $json; ?>;
        var mesAtual = <?php echo $mesAtual; ?>;

        // gráficos

        var optionsDespesas = {
            series: [{
                name: 'Valor total',
                data: [json['totalDespesasDias'][0], json['totalDespesasDias'][1], json['totalDespesasDias'][2], json['totalDespesasDias'][3], json['totalDespesasDias'][4], json['totalDespesasDias'][5], json['totalDespesasDias'][6], json['totalDespesasDias'][7], json['totalDespesasDias'][8], json['totalDespesasDias'][9], json['totalDespesasDias'][10], json['totalDespesasDias'][11], json['totalDespesasDias'][12], json['totalDespesasDias'][13], json['totalDespesasDias'][14], json['totalDespesasDias'][15], json['totalDespesasDias'][16], json['totalDespesasDias'][17], json['totalDespesasDias'][18], json['totalDespesasDias'][19], json['totalDespesasDias'][20], json['totalDespesasDias'][21], json['totalDespesasDias'][22], json['totalDespesasDias'][23], json['totalDespesasDias'][24], json['totalDespesasDias'][25], json['totalDespesasDias'][26], json['totalDespesasDias'][27], json['totalDespesasDias'][28], json['totalDespesasDias'][29], json['totalDespesasDias'][30]]
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
            title: {
                text: 'Despesas diárias (R$)',
                align: 'left',
                floating: false
            },
            plotOptions: {
                bar: {
                    barHeight: '100%',
                    distributed: false
                }
            },
            colors: ['#dc3545'],
            xaxis: {
                type: "categories",
                categories: [dias[0], dias[1], dias[2], dias[3], dias[4], dias[5], dias[6], dias[7], dias[8], dias[9], dias[10], dias[11], dias[12], dias[13], dias[14], dias[15], dias[16], dias[17], dias[18], dias[19], dias[20], dias[21], dias[22], dias[23], dias[24], dias[25], dias[26], dias[27], dias[28], dias[29], dias[30]],
                labels: {
                    show: true
                }
            },
            // responsive: [{
            //     breakpoint: 699,
            //     options: {
            //         series: [{
            //             name: 'Valor total',
            //             data: [dias[0], dias[1], dias[2], dias[3], dias[4]]
            //         }],
            //         stroke: {
            //             curve: 'smooth',
            //         },
            //         markers: {
            //             size: 7
            //         },
            //         chart: {
            //             type: 'line',
            //             width: '100%',
            //             height: '100%'
            //         },
            //         title: {
            //             text: 'Despesas semanais',
            //             align: 'left',
            //             floating: false
            //         },
            //         plotOptions: {
            //             bar: {
            //                 barHeight: '100%',
            //                 distributed: false
            //             }
            //         },
            //         colors: ['#239E18'],
            //         xaxis: {
            //             categories: ["Semana 1", "Semana 2", "Semana 3", "Semana 4", "Semana 5"],
            //             labels: {
            //                 show: true
            //             }
            //         }
            //     },
            // }]
        };

        if ($('#selectMesGraficoDespesas').val() == mesAtual) {
            var chart = new ApexCharts(document.querySelector("#graficoDespesas"), optionsDespesas);
            chart.render();
        } else {
            var chart = new ApexCharts(document.querySelector("#graficoDespesas"), optionsDespesas);
            chart.render();
        }


        $('#selectMesGraficoDespesas').change(function() {

            $('#formSelectMes').submit();

        });

    });

    $(document).ready(function() {

        $('#modalDeleteDespesa').on('hidden.bs.modal', function() {
            window.history.pushState(null, null, window.location.pathname);
        });

        $('#modalEditDespesa').on('hidden.bs.modal', function() {
            window.history.pushState(null, null, window.location.pathname);
        });
    });
</script>