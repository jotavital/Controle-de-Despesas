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

include_once(__DIR__ . "/../classes/Receita.class.php");

function totalReceitasTodosDiasDoMes($mes)
{
    $receita = new Receita;
    $totalReceitasDias = $receita->selectValorTotalReceitasTodosDiasByMonth($mes);
    $arrayTotal = array('totalReceitasDias' => $totalReceitasDias);

    return json_encode($arrayTotal);
}


if (!isset($_GET['selectMesGraficoReceitas'])) {
    echo "<script> window.location.href = '../pages/receitas.php?selectMesGraficoReceitas=" . $mesAtual . "';</script>";
    $json = totalReceitasTodosDiasDoMes($mesAtual);
} else {
    $json = totalReceitasTodosDiasDoMes($_GET['selectMesGraficoReceitas']);
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
                    <button class="btn btn-success rounded-circle" data-bs-toggle="modal" data-bs-target="#modalAddReceita">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                <?php
                $userId = $_SESSION['userId'];
                $sql = $conexao->prepare("SELECT r.*, c.nome_conta, c.id as id_conta FROM receita as r, conta as c WHERE r.fk_usuario = :userId AND r.fk_conta = c.id GROUP BY r.id ORDER BY data_receita DESC");
                $sql->bindValue(":userId", $userId);

                try {
                    $sql->execute();
                    $data = $sql->fetchAll();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }

                ?>

                <!-- grafico receitas -->
                <div class="col-12 d-flex justify-content-center">
                    <div class="card mb-4 br-25 col-10 overflow-auto">
                        <div class="card-header text-white bg-light-blue">
                            <h3 class="col-12 d-flex justify-content-center">Estatísticas mensais</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 d-flex justify-content-center">
                                <div class="d-flex align-items-center" style="height:400px; width:500px">
                                    <div class="col-md-12">
                                        <form class="col-12" method="GET" action="../pages/receitas.php" id="formSelectMes">
                                            <div class="form-group">
                                                <div class="col-md mb-3 d-flex align-items-center justify-content-between">
                                                    <label for="selectMesGraficoReceitas">Filtre por mês:</label>
                                                    <div class="col-6">
                                                        <select class="form-select" name="selectMesGraficoReceitas" id="selectMesGraficoReceitas">
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
                        </div>
                    </div>
                </div>

                <!-- tabela do dataTables -->
                <div class="col-md-12 d-flex justify-content-center">
                    <div class="card br-25 col-10 overflow-auto">
                        <div class="card-header bg-success text-white">
                            <h3 class="col-12 d-flex justify-content-center">Todas as receitas</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                <div class="col-12 tableReceitas" id="tableReceitasContainer">
                                    <table id="tableReceitas" class="tabela table hover order-column row-border table-hover table-bordered">
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
                                                $data_receita_formatada = date('d/m/Y', strtotime($row['data_receita']));
                                            ?>

                                                <tr>
                                                    <td><?php echo $row['descricao_receita'] ?></td>
                                                    <td><?php echo $data_receita_formatada ?></td>
                                                    <td><?php echo "<span class='p-success'><strong>" . $functions->formatarReal($valor) . "</strong></span>"; ?></td>
                                                    <td><?php echo $row['nome_conta'] ?></td>
                                                    <td>
                                                        <div class="actionIcons col-12 d-flex align-items-center justify-content-center">
                                                            <i class="fas fa-edit p-primary"></i>
                                                            <?php echo '<a href="' . $_SERVER["REQUEST_URI"] . '&delete=true&type=receita&id=' . $row['id'] . '&desc_receita=' . $row['descricao_receita'] . '&nome_conta=' . $row['nome_conta'] . "&id_conta=" . $row['id_conta'] . "&valor=" . sprintf("%.2f", $row['valor']) . '"' . 'id="btnExcluirReceita"><i class="fas fas fa-trash p-danger"></i></a>' ?>
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

<script>
    $(document).ready(function() {
        var dias = new Array();

        for (var i = 1; i <= 31; i++) {
            dias.push(i);
        }

        var json = <?php echo $json; ?>;
        var mesAtual = <?php echo $mesAtual; ?>;

        // gráficos

        var optionsReceitas = {
            series: [{
                name: 'Valor total',
                data: [json['totalReceitasDias'][0], json['totalReceitasDias'][1], json['totalReceitasDias'][2], json['totalReceitasDias'][3], json['totalReceitasDias'][4], json['totalReceitasDias'][5], json['totalReceitasDias'][6], json['totalReceitasDias'][7], json['totalReceitasDias'][8], json['totalReceitasDias'][9], json['totalReceitasDias'][10], json['totalReceitasDias'][11], json['totalReceitasDias'][12], json['totalReceitasDias'][13], json['totalReceitasDias'][14], json['totalReceitasDias'][15], json['totalReceitasDias'][16], json['totalReceitasDias'][17], json['totalReceitasDias'][18], json['totalReceitasDias'][19], json['totalReceitasDias'][20], json['totalReceitasDias'][21], json['totalReceitasDias'][22], json['totalReceitasDias'][23], json['totalReceitasDias'][24], json['totalReceitasDias'][25], json['totalReceitasDias'][26], json['totalReceitasDias'][27], json['totalReceitasDias'][28], json['totalReceitasDias'][29], json['totalReceitasDias'][30]]
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
                text: 'Receitas diárias (R$)',
                align: 'left',
                floating: false
            },
            plotOptions: {
                bar: {
                    barHeight: '100%',
                    distributed: false
                }
            },
            colors: ['#198754'],
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
            //             text: 'Receitas semanais',
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