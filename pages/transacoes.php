<?php

include("../connections/loginVerify.php");

include("../connections/connection.php");
$conn = new Connection;
$conexao = $conn->conectar();

$title = "Transações";
include("../include/header.php");
include("../pages/modals/modalDespesa.php");
include("../pages/modals/modalReceita.php");
setTitulo($title);

?>

<body>
    <div id="containerDashboard">

        <?php
        include("../include/sideBar.php");
        ?>

        <main>

            <?php
            include("../include/navBar_logged.php");
            ?>

            <div id="contentDashboard">
                <div class="row col-md">

                    <?php
                    $userId = $_SESSION['userId'];
                    $stm = $conexao->prepare("SELECT d.*, c.nome_conta FROM despesa as d, conta as c WHERE d.fk_usuario = :userId AND d.fk_conta = c.id GROUP BY d.id");
                    $stm->bindValue(":userId", $userId);
                    $stm2 = $conexao->prepare("SELECT r.*, c.nome_conta FROM receita as r, conta as c WHERE r.fk_usuario = :userId AND r.fk_conta = c.id GROUP BY r.id");
                    $stm2->bindValue(":userId", $userId);

                    try {
                        $stm->execute();
                        $data = $stm->fetchAll();
                        $stm2->execute();
                        $data2 = $stm2->fetchAll();
                        $result = array_merge($data, $data2);
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }

                    ?>

                    <!-- tabela do dataTables -->
                    <div class="d-flex justify-content-center">
                        <div class="col-12 tableDespesas" id="tableDespesasContainer">
                            <table id="tableDespesas" class="tabela display">
                                <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Descrição</th>
                                        <th>Data</th>
                                        <th>Vencimento</th>
                                        <th>Valor</th>
                                        <th>Conta</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    foreach ($result as $row) {
                                        $valor = $row['valor'];
                                        $formatter = new NumberFormatter('pt_BR',  NumberFormatter::CURRENCY);
                                        if (isset($row['descricao_despesa'])) {
                                    ?>

                                            <tr>
                                                <td class="d-flex justify-content-center">
                                                    <i style="color:red;" class="fas fa-hand-holding-usd"></i>
                                                </td>
                                                <td><?php echo $row['descricao_despesa'] ?></td>
                                                <td><?php echo $row['data_despesa'] ?></td>
                                                <td><?php echo $row['data_vencimento'] ?></td>
                                                <td><?php echo ($formatter->formatCurrency($valor, 'BRL')); ?></td>
                                                <td><?php echo $row['nome_conta'] ?></td>
                                                <td>
                                                    <div class="actionIcons col-12 d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-edit"></i>
                                                        <?php echo '<a href="../pages/transacoes.php?delete=true&type=despesa&id=' . $row['id'] . '&desc_despesa=' . $row['descricao_despesa'] . '&nome_conta=' . $row['nome_conta'] . "&valor=" . sprintf("%.2f", $row['valor']) . '"' . 'id="btnExcluirDespesa"><i class="fas fa-trash-alt"></i></a>' ?>
                                                    </div>
                                                </td>
                                            </tr>

                                        <?php
                                        } elseif (isset($row['descricao_receita'])) {
                                        ?>

                                            <tr>
                                                <td class="d-flex justify-content-center">
                                                    <i style="color:green;" class="fas fa-chart-line"></i>
                                                </td>
                                                <td><?php echo $row['descricao_receita'] ?></td>
                                                <td><?php echo $row['data_receita'] ?></td>
                                                <td> - </td>
                                                <td><?php echo ($formatter->formatCurrency($valor, 'BRL')); ?></td>
                                                <td><?php echo $row['nome_conta'] ?></td>
                                                <td>
                                                    <div class="actionIcons col-12 d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-edit"></i>
                                                        <?php echo '<a href="../pages/transacoes.php?delete=true&type=receita&id=' . $row['id'] . '&desc_receita=' . $row['descricao_receita'] . '&nome_conta=' . $row['nome_conta'] . "&valor=" . sprintf("%.2f", $row['valor']) . '"' . 'id="btnExcluirReceita"><i class="fas fa-trash-alt"></i></a>' ?>
                                                    </div>
                                                </td>
                                            </tr>

                                    <?php
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

</body>

<?php
include("../include/footer.php");
?>

<?php

if ($_GET['delete'] != null && $_GET['delete'] == "true") {

    if (isset($_GET['desc_despesa'])) {

        echo    "<script>$(document).ready(function(){
                    $('#modalDespesa').modal('show');
                });</script>";
    } elseif (isset($_GET['type']) == "receita") {

        echo    "<script>$(document).ready(function(){
                    $('#modalReceita').modal('show');
                });</script>";
    }
}

?>

<script>
    $(document).ready(function() {

        $('#modalDespesa').on('hidden.bs.modal', function() {
            window.history.pushState(null, null, window.location.pathname);
        });

        $('#modalReceita').on('hidden.bs.modal', function() {
            window.history.pushState(null, null, window.location.pathname);
        });
    });
</script>