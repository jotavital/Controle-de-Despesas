<?php

include_once(__DIR__ . "/../connections/loginVerify.php");

include_once(__DIR__ . "/../connections/Connection.class.php");
$conn = new Connection;
$conexao = $conn->conectar();

$title = "Transações";
include_once(__DIR__ . "/../include/header.php");
include_once(__DIR__ . "/modals/modalDeleteDespesa.php");
include_once(__DIR__ . "/modals/modalDeleteReceita.php");
setTitulo($title);

?>

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
                <div class="row col-md">

                    <?php
                    $userId = $_SESSION['userId'];
                    $stm = $conexao->prepare("SELECT d.*, c.nome_conta, c.id as id_conta FROM despesa as d, conta as c WHERE d.fk_usuario = :userId AND d.fk_conta = c.id GROUP BY d.id");
                    $stm->bindValue(":userId", $userId);
                    $stm2 = $conexao->prepare("SELECT r.*, c.nome_conta, c.id as id_conta FROM receita as r, conta as c WHERE r.fk_usuario = :userId AND r.fk_conta = c.id GROUP BY r.id");
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
                    <div class="cardTabela">
                        <div class="col-md-12 d-flex justify-content-center">
                            <div class="card col-10 overflow-auto">
                                <div class="card-header bg-light-blue text-white">
                                    <h3 class="col-12 d-flex justify-content-center">Histórico de Transações</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <div class="col-12 tableDespesas" id="tableDespesasContainer">
                                            <table id="tableDespesas" class="tabela hover order-column row-border">
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
                                                        if (isset($row['descricao_despesa'])) {
                                                            $data_despesa_formatada = date('d/m/Y', strtotime($row['data_despesa']));
                                                            $data_vencimento_formatada = date('d/m/Y', strtotime($row['data_despesa']));
                                                    ?>

                                                            <tr>
                                                                <td class="d-flex justify-content-center">
                                                                    <i class="p-danger fas fa-arrow-circle-down"></i>
                                                                </td>
                                                                <td><?php echo $row['descricao_despesa'] ?></td>
                                                                <td><?php echo $data_despesa_formatada ?></td>
                                                                <td><?php echo $data_vencimento_formatada ?></td>
                                                                <td><?php echo "<span class='p-danger'><strong>" . $functions->formatarReal($valor) . "</strong></span>"; ?></td>
                                                                <td><?php echo $row['nome_conta'] ?></td>
                                                                <td>
                                                                    <div class="actionIcons col-12 d-flex align-items-center justify-content-center">
                                                                        <i class="fas fa-edit"></i>
                                                                        <?php echo '<a href="../pages/transacoes.php?delete=true&type=despesa&id=' . $row['id'] . '&desc_despesa=' . $row['descricao_despesa'] . '&id_conta=' . $row['fk_conta'] . '&nome_conta=' . $row['nome_conta'] . "&valor=" . sprintf("%.2f", $row['valor']) . '"' . 'id="btnExcluirDespesa"><i class="fas fa-trash-alt"></i></a>' ?>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                        <?php
                                                        } elseif (isset($row['descricao_receita'])) {
                                                            $data_receita_formatada = date('d/m/Y', strtotime($row['data_receita']));
                                                        ?>

                                                            <tr>
                                                                <td class="d-flex justify-content-center">
                                                                    <i class="p-success fas fa-arrow-circle-up"></i>
                                                                </td>
                                                                <td><?php echo $row['descricao_receita'] ?></td>
                                                                <td><?php echo $data_receita_formatada ?></td>
                                                                <td> - </td>
                                                                <td><?php echo "<span class='p-success'><strong>" . $functions->formatarReal($valor) . "</strong></span>"; ?></td>
                                                                <td><?php echo $row['nome_conta'] ?></td>
                                                                <td>
                                                                    <div class="actionIcons col-12 d-flex align-items-center justify-content-center">
                                                                        <i class="fas fa-edit"></i>
                                                                        <?php echo '<a href="../pages/transacoes.php?delete=true&type=receita&id=' . $row['id'] . '&desc_receita=' . $row['descricao_receita'] . '&nome_conta=' . $row['nome_conta'] . "&id_conta=" . $row['id_conta'] . "&valor=" . sprintf("%.2f", $row['valor']) . '"' . 'id="btnExcluirReceita"><i class="fas fa-trash-alt"></i></a>' ?>
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

if (isset($_GET['delete'])) {
    if ($_GET['delete'] != null && $_GET['delete'] == "true") {

        if (isset($_GET['desc_despesa'])) {

            echo    "<script>$(document).ready(function(){
                        $('#modalDeleteDespesa').modal('show');
                    });</script>";
        } elseif (isset($_GET['type']) == "receita") {

            echo    "<script>$(document).ready(function(){
                        $('#modalDeleteReceita').modal('show');
                    });</script>";
        }
    }
}

?>

<script>
    $(document).ready(function() {

        $('#modalDeleteDespesa').on('hidden.bs.modal', function() {
            window.history.pushState(null, null, window.location.pathname);
        });

        $('#modalDeleteReceita').on('hidden.bs.modal', function() {
            window.history.pushState(null, null, window.location.pathname);
        });
    });
</script>